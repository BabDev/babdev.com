<?php

namespace BabDev\Http\Controllers;

use BabDev\Models\Sponsor;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

final class ViewSponsorPageController
{
    public function __invoke(): View
    {
        /** @var Collection<array-key, Sponsor> $featuredSponsors */
        $featuredSponsors = Sponsor::query()
            ->whereRelation('sponsorship_tier', 'price', '>', 2500)
            ->orderByRaw('CASE WHEN sponsor_display_name IS NULL THEN sponsor_username ELSE sponsor_display_name END ASC')
            ->get();

        /** @var Collection<array-key, Sponsor> $regularSponsors */
        $regularSponsors = Sponsor::query()
            ->whereHas('sponsorship_tier', static function (Builder $query): void {
                $query->whereBetween('price', [1000, 2499]);
            })
            ->orderByRaw('CASE WHEN sponsor_display_name IS NULL THEN sponsor_username ELSE sponsor_display_name END ASC')
            ->get();

        return view('sponsor', [
            'featured_sponsors' => $featuredSponsors,
            'regular_sponsors' => $regularSponsors,
        ]);
    }
}
