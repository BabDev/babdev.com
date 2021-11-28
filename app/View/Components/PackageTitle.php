<?php

namespace BabDev\View\Components;

use BabDev\Models\Package;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PackageTitle extends Component
{
    public function __construct(
        public readonly Package $package,
        public readonly ?string $secondaryTitle = null,
    ) {
    }

    public function render(): View
    {
        return view('components.package-title');
    }
}
