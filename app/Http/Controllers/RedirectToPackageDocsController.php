<?php

namespace App\Http\Controllers;

use App\Models\Exceptions\VersionsNotConfigured;
use App\Models\Package;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class RedirectToPackageDocsController
{
    public function __invoke(Package $package, string $slug = 'intro'): RedirectResponse
    {
        abort_if(!$package->visible, 404);

        // Redirect if package does not have docs
        if (!$package->has_documentation) {
            return redirect()->route('open-source.packages');
        }

        try {
            $packageVersion = $package->latestVersion();
        } catch (VersionsNotConfigured $exception) {
            throw new NotFoundHttpException($exception->getMessage(), $exception);
        }

        return redirect()->route('open-source.packages.package-docs-page', [
            'package' => $package,
            'version' => $packageVersion->version,
            'slug' => $slug,
        ]);
    }
}
