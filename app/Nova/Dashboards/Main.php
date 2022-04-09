<?php

namespace BabDev\Nova\Dashboards;

use Laravel\Nova\Card;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Dashboards\Main as Dashboard;

class Main extends Dashboard
{
    /**
     * @return Card[]
     */
    public function cards(): array
    {
        return [
            new Help(),
        ];
    }
}
