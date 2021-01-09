<?php

namespace BabDev\Http\Controllers;

use BabDev\Models\Package;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;

final class ViewOpenSourcePackagesController
{
    public function __invoke(): View
    {
        /** @var Collection<Package> $packages */
        $packages = Package::query()
            ->visible()
            ->orderBy('display_name')
            ->get();

        return view(
            'open_source.packages.index',
            [
                'packages' => $packages,
            ]
        );
    }
}
