<?php

namespace BabDev\Models;

use Database\Factories\PackageVersionFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int         $id
 * @property int         $package_id
 * @property string      $version
 * @property string|null $docs_git_branch
 * @property Carbon|null $released
 * @property Carbon|null $end_of_support
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Package $package
 *
 * @method static PackageVersionFactory factory(...$parameters)
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
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'version',
        'docs_git_branch',
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

    /**
     * @return PackageVersionFactory<self>
     */
    protected static function newFactory(): Factory
    {
        return PackageVersionFactory::new();
    }

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
