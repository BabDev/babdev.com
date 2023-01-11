<?php

namespace BabDev\Http\Controllers;

use BabDev\Contracts\Services\DocumentationProcessor;
use BabDev\Models\Package;
use BabDev\Models\PackageVersion;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

final class ViewOpenSourcePackageDocsPageController
{
    public function __invoke(Package $package, string $version, string $slug, DocumentationProcessor $documentationProcessor): RedirectResponse|Response|View
    {
        abort_if(!$package->visible, 404);

        // Redirect if package does not have docs
        if (!$package->has_documentation) {
            return redirect()->route('open-source.packages');
        }

        $package->load('versions');

        $packageVersion = $package->versions->where('version', '=', $version)->first();

        if (!$packageVersion instanceof PackageVersion) {
            return response()->view('open_source.packages.docs_not_found_for_version', [
                'package' => $package,
                'version' => $version,
            ], 404);
        }

        // Don't allow the index (sidebar contents) to be requested
        abort_if($slug === 'index', 404);

        $contents = $documentationProcessor->fetchPageContents($package, $packageVersion->git_branch, $slug);
        $sidebar = $documentationProcessor->fetchPageContents($package, $packageVersion->git_branch, 'index');

        return view('open_source.packages.docs_page', [
            'package' => $package,
            'package_version' => $packageVersion,
            'contents' => $contents,
            'sidebar' => $sidebar,
            'title' => $documentationProcessor->extractTitle($contents),
            'version' => $version,
            'slug' => $slug,
        ]);
    }
}
