<?php

namespace BabDev\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Hero extends Component
{
    public function __construct(
        public readonly string $title,
        public readonly ?string $subtitle = null,
    ) {
    }

    public function render(): View
    {
        return view('components.hero');
    }
}
