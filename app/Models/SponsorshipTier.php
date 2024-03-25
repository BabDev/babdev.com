<?php

namespace BabDev\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int         $id
 * @property string      $node_id
 * @property bool        $one_time
 * @property int         $price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|SponsorshipTier newModelQuery()
 * @method static Builder|SponsorshipTier newQuery()
 * @method static Builder|SponsorshipTier query()
 * @method static Builder|SponsorshipTier whereCreatedAt($value)
 * @method static Builder|SponsorshipTier whereId($value)
 * @method static Builder|SponsorshipTier whereNodeId($value)
 * @method static Builder|SponsorshipTier whereOneTime($value)
 * @method static Builder|SponsorshipTier wherePrice($value)
 * @method static Builder|SponsorshipTier whereUpdatedAt($value)
 */
class SponsorshipTier extends Model
{
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'node_id',
        'one_time',
        'price',
    ];

    /**
     * @return array<string, class-string|string>
     */
    protected function casts(): array
    {
        return [
            'one_time' => 'boolean',
            'price' => 'int',
        ];
    }
}
