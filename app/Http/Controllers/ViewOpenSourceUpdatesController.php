<?php

namespace BabDev\Http\Controllers;

use BabDev\Models\PackageUpdate;
use BabDev\Pagination\RoutableLengthAwarePaginator;
use Illuminate\Contracts\View\View;

final class ViewOpenSourceUpdatesController
{
    public function __invoke(): View
    {
        /** @var RoutableLengthAwarePaginator|PackageUpdate[] $updates */
        $updates = PackageUpdate::query()
            ->published()
            ->orderByDesc('published_at')
            ->orderBy('title')
            ->paginate(10);

        return view(
            'open_source.updates.index',
            [
                'updates' => $updates,
            ]
        );
    }
}
