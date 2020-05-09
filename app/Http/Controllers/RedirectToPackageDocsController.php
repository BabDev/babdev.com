<?php

namespace BabDev\Http\Controllers;

use BabDev\DocumentationType;
use BabDev\Models\Package;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RedirectToPackageDocsController
{
    public function __invoke(Request $request, Package $package): RedirectResponse
    {
        // Redirect if package does not have docs
        if ($package->documentation_type !== DocumentationType::GITHUB) {
            return redirect()->route('open-source.packages');
        }

        $slug = $request->get('slug', 'intro');
        $version = $request->get('version');

        if ($version === null) {
            // TODO - Get from model
            $version = '1.x';
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
