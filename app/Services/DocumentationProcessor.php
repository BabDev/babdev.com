<?php

namespace BabDev\Services;

use BabDev\Contracts\Services\DocumentationProcessor as DocumentationProcessorContract;
use BabDev\Contracts\Services\Exceptions\PageNotFoundException;
use BabDev\Contracts\Services\Exceptions\UnsupportedEncodingException;
use BabDev\GitHub\ApiConnector;
use BabDev\Models\Package;
use Github\Exception\RuntimeException;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

final class DocumentationProcessor implements DocumentationProcessorContract
{
    public function __construct(private ApiConnector $github, private Repository $cache)
    {
    }

    public function generateDocsFileCacheKey(Package $package, string $version, string $pageSlug): string
    {
        return str_replace('/', '.', sprintf('%s/%s/%s', $package->name, $version, $pageSlug));
    }

    public function extractTitle(string $markdown): string
    {
        return Str::after(
            (new Collection(explode(\PHP_EOL, $markdown)))->first(),
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
                        sprintf('docs/%s.md', $pageSlug),
                        $version,
                    );
                } catch (RuntimeException $exception) {
                    throw new PageNotFoundException(
                        sprintf('The "%s" page does not exist for the %s package', $pageSlug, $package->display_name),
                        404,
                        $exception,
                    );
                }

                return match ($file['encoding']) {
                    'base64' => base64_decode($file['content']),
                    default => throw new UnsupportedEncodingException(
                        sprintf('The "%s" encoding is not supported.', $file['encoding']),
                    ),
                };
            },
        );
    }
}
