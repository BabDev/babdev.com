<?php

namespace BabDev\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int         $id
 * @property string      $sponsorship_node_id
 * @property bool        $is_public
 * @property string      $sponsor_node_id
 * @property string      $sponsor_username
 * @property string|null $sponsor_display_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read SponsorshipTier $sponsorship_tier
 *
 * @method static Builder|Sponsor query()
 */
class Sponsor extends Model
{
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'sponsorship_node_id',
        'is_public',
        'sponsor_node_id',
        'sponsor_username',
        'sponsor_display_name',
    ];

    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'is_public' => 'boolean',
    ];

    public function sponsorship_tier(): BelongsTo
    {
        return $this->belongsTo(SponsorshipTier::class);
    }
}
