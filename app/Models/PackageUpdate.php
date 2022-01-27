<?php

namespace BabDev\Models;

use Carbon\Carbon;
use Database\Factories\PackageUpdateFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int         $id
 * @property int         $package_id
 * @property string      $title
 * @property string      $slug
 * @property string|null $intro
 * @property string|null $content
 * @property Carbon      $published_at
 * @property array|null  $data
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Package $package
 *
 * @method static PackageUpdateFactory factory(...$parameters)
 * @method static Builder|PackageUpdate published()
 * @method static Builder|PackageUpdate newModelQuery()
 * @method static Builder|PackageUpdate newQuery()
 * @method static Builder|PackageUpdate query()
 * @method static Builder|PackageUpdate whereContent($value)
 * @method static Builder|PackageUpdate whereCreatedAt($value)
 * @method static Builder|PackageUpdate whereData($value)
 * @method static Builder|PackageUpdate whereId($value)
 * @method static Builder|PackageUpdate whereIntro($value)
 * @method static Builder|PackageUpdate wherePackageId($value)
 * @method static Builder|PackageUpdate wherePublishedAt($value)
 * @method static Builder|PackageUpdate whereSlug($value)
 * @method static Builder|PackageUpdate whereTitle($value)
 * @method static Builder|PackageUpdate whereUpdatedAt($value)
 */
class PackageUpdate extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'intro',
        'content',
        'published_at',
        'data',
    ];

    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'data' => 'array',
        'published_at' => 'datetime',
    ];

    protected static function newFactory(): Factory
    {
        return PackageUpdateFactory::new();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published_at', '<=', now()->format('Y-m-d H:i:s'));
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function isPublished(): bool
    {
        if (!$this->published_at) {
            return false;
        }

        return $this->published_at <= now();
    }
}
