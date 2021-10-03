<?php

namespace BabDev\Http\Controllers;

use BabDev\Models\PackageUpdate;
use BabDev\Pagination\RoutableLengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

final class ViewOpenSourceUpdatesController
{
    public function __invoke(Request $request, int $page = 1): RedirectResponse|View
    {
        abort_if($page < 1, 404);

        $route = $request->route();

        if ($route instanceof Route && $page === 1 && $route->getName() === 'open-source.updates.paginated') {
            return redirect()->route('open-source.updates');
        }

        /** @var RoutableLengthAwarePaginator<PackageUpdate> $updates */
        $updates = PackageUpdate::query()
            ->published()
            ->orderByDesc('published_at')
            ->orderBy('title')
            ->paginate(10);

        abort_if($updates->currentPage() > $updates->lastPage(), 404);

        return view(
            'open_source.updates.index',
            [
                'updates' => $updates,
            ],
        );
    }
}
