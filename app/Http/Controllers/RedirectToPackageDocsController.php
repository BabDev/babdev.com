<?php

namespace BabDev\Http\Controllers;

use BabDev\Models\Package;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RedirectToPackageDocsController
{
    public function __invoke(Request $request, Package $package): RedirectResponse
    {
        // Redirect if package does not have docs
        if (!$package->has_documentation) {
            return redirect()->route('open-source.packages');
        }

        $slug = $request->get('slug', 'intro');
        $version = $request->get('version');

        if ($version === null) {
            $version = $package->getDefaultDocsVersion();
        }

        return redirect()->route(
            'open-source.packages.package-docs-page',
            [
                'package' => $package,
                'version' => $version,
                'slug' => $slug,
            ]
        );
    }
}
