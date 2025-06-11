<?php

namespace App\Http\Controllers;

use App\Models\PackageUpdate;
use Illuminate\Contracts\View\View;

final class ViewOpenSourceUpdateController
{
    public function __invoke(PackageUpdate $update): View
    {
        abort_unless($update->is_published, 404, 'Update Not Found');

        return view('open_source.updates.show', [
            'update' => $update->load('package'),
        ]);
    }
}
