<?php

namespace BabDev\View\Components;

use BabDev\Models\Package;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PackageTitle extends Component
{
    public Package $package;
    public ?string $secondaryTitle;

    public function __construct(Package $package, ?string $secondaryTitle = null)
    {
        $this->package = $package;
        $this->secondaryTitle = $secondaryTitle;
    }

    public function render(): View
    {
        return view('components.package-title');
    }
}
