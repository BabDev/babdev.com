<?php

namespace BabDev\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Hero extends Component
{
    public string $title;
    public ?string $subtitle;

    /**
     * @param string[] $modifiers
     */
    public function __construct(string $title, ?string $subtitle = null)
    {
        $this->title = $title;
        $this->subtitle = $subtitle;
    }

    public function render(): View
    {
        return view('components.hero');
    }
}
