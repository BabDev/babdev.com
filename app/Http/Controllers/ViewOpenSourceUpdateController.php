<?php

namespace BabDev\Http\Controllers;

use BabDev\Models\PackageUpdate;
use Illuminate\Contracts\View\View;

final class ViewOpenSourceUpdateController
{
    public function __invoke(PackageUpdate $update): View
    {
        abort_unless($update->is_published, 404, 'Update Not Found');

        $update->load(
            [
                'package',
            ],
        );

        return view(
            'open_source.updates.show',
            [
                'update' => $update,
            ],
        );
    }
}
