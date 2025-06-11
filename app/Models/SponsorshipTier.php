<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int         $id
 * @property string      $node_id
 * @property bool        $one_time
 * @property int         $price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Collection<array-key, Sponsor> $sponsors
 * @property-read int|null                       $sponsors_count
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
     * @var list<string>
     */
    protected $fillable = [
        'node_id',
        'one_time',
        'price',
    ];

    /**
     * @return HasMany<Sponsor, $this>
     */
    public function sponsors(): HasMany
    {
        return $this->hasMany(Sponsor::class);
    }

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
