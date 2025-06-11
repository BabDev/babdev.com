<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Contracts\View\View;

final class ViewOpenSourcePackagesController
{
    public function __invoke(): View
    {
        return view('open_source.packages.index', [
            'packages' => Package::visible()
                ->orderBy('display_name')
                ->get(),
        ]);
    }
}
