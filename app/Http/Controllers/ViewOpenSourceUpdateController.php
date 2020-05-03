<?php

namespace BabDev\Http\Controllers;

use Illuminate\Contracts\View\View;

class ViewOpenSourceUpdateController
{
    public function __invoke(): View
    {
        abort_unless($update->isPublished(), 404, 'Update Not Found');

        $update->load(
            [
                'package',
            ]
        );

        return view(
            'open_source.updates.show',
            [
                'update' => $update,
            ]
        );
    }
}
