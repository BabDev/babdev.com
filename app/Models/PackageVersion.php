<?php

namespace BabDev\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int         $id
 * @property int         $package_id
 * @property string      $version
 * @property Carbon|null $released
 * @property Carbon|null $end_of_support
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Package $package
 *
 * @method static Builder|PackageVersion newModelQuery()
 * @method static Builder|PackageVersion newQuery()
 * @method static Builder|PackageVersion query()
 * @method static Builder|PackageVersion whereCreatedAt($value)
 * @method static Builder|PackageVersion whereEndOfSupport($value)
 * @method static Builder|PackageVersion whereId($value)
 * @method static Builder|PackageVersion wherePackageId($value)
 * @method static Builder|PackageVersion whereReleased($value)
 * @method static Builder|PackageVersion whereUpdatedAt($value)
 * @method static Builder|PackageVersion whereVersion($value)
 */
class PackageVersion extends Model
{
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'version',
        'released',
        'end_of_support',
    ];

    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'released' => 'date',
        'end_of_support' => 'date',
    ];

    public function getRouteKeyName(): string
    {
        return 'version';
    }

    /**
     * @return BelongsTo<Package, self>
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}
