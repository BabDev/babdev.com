<?php

namespace BabDev\Http\Controllers;

use BabDev\Contracts\Services\DocumentationProcessor;
use BabDev\Contracts\Services\Exceptions\PageNotFoundException;
use BabDev\Models\Package;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class ViewOpenSourcePackageDocsPageController
{
    /**
     * @return RedirectResponse|View
     */
    public function __invoke(Package $package, string $version, string $slug, DocumentationProcessor $documentationProcessor)
    {
        abort_if(!$package->visible, 404);

        // Redirect if package does not have docs
        if (!$package->has_documentation) {
            return redirect()->route('open-source.packages');
        }

        abort_unless($package->hasDocsVersion($version), 404);

        // Don't allow the index (sidebar contents) to be requested
        abort_if($slug === 'index', 404);

        try {
            $contents = $documentationProcessor->fetchPageContents($package, $package->mapDocsVersionToGitBranch($version), $slug);
        } catch (PageNotFoundException $exception) {
            throw new NotFoundHttpException($exception->getMessage(), $exception);
        }

        $sidebar = $documentationProcessor->fetchPageContents($package, $package->mapDocsVersionToGitBranch($version), 'index');

        return view(
            'open_source.packages.docs_page',
            [
                'package' => $package,
                'contents' => $contents,
                'sidebar' => $sidebar,
                'title' => $documentationProcessor->extractTitle($contents),
                'version' => $version,
                'slug' => $slug,
            ]
        );
    }
}
