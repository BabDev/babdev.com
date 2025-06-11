<?php

namespace App\Services;

use App\Contracts\Services\DocumentationProcessor as DocumentationProcessorContract;
use App\Contracts\Services\Exceptions\PageNotFoundException;
use App\Contracts\Services\Exceptions\UnsupportedEncodingException;
use App\GitHub\ApiConnector;
use App\Models\Package;
use Github\Exception\RuntimeException;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

final readonly class DocumentationProcessor implements DocumentationProcessorContract
{
    public function __construct(private ApiConnector $github, private Repository $cache) {}

    public function generateDocsFileCacheKey(Package $package, string $version, string $pageSlug): string
    {
        return str_replace('/', '.', \sprintf('%s/%s/%s', $package->name, $version, $pageSlug));
    }

    public function extractTitle(string $markdown): string
    {
        return Str::after(
            Str::of($markdown)->explode(\PHP_EOL)->first(default: $markdown),
            '# ',
        );
    }

    /**
     * @throws PageNotFoundException        if the requested page does not exist
     * @throws UnsupportedEncodingException if the file encoding type is not supported
     */
    public function fetchPageContents(Package $package, string $version, string $pageSlug): string
    {
        return $this->cache->remember(
            $this->generateDocsFileCacheKey($package, $version, $pageSlug),
            new \DateInterval('P1D'),
            function () use ($package, $version, $pageSlug): string {
                try {
                    $file = $this->github->fetchFileContents(
                        'BabDev',
                        $package->name,
                        \sprintf('docs/%s.md', $pageSlug),
                        $version,
                    );
                } catch (RuntimeException $exception) {
                    throw new PageNotFoundException(
                        \sprintf('The "%s" page does not exist for the %s package', $pageSlug, $package->display_name),
                        previous: $exception,
                    );
                }

                return match (Arr::string($file, 'encoding', 'unknown')) {
                    'base64' => base64_decode(Arr::string($file, 'content')),
                    default => throw new UnsupportedEncodingException(
                        \sprintf('The "%s" encoding is not supported.', Arr::string($file, 'encoding', 'unknown')),
                    ),
                };
            },
        );
    }
}
