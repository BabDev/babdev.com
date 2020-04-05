<?php

namespace BabDev\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @property int          $id
 * @property int          $package_id
 * @property string       $title
 * @property string       $slug
 * @property string|null  $intro
 * @property string|null  $content
 * @property Carbon       $published_at
 * @property array|null   $data
 * @property Carbon|null  $created_at
 * @property Carbon|null  $updated_at
 * @property-read Package $package
 *
 * @method static Builder|PackageUpdate published()
 * @method static Builder|PackageUpdate query()
 */
class PackageUpdate extends Model
{
    use HasSlug;

    protected $fillable = [
        'title',
        'intro',
        'content',
        'published_at',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    protected $dates = [
        'published_at',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('publish_at', '<=', Carbon::now()->format('Y-m-d H:i:s'));
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}
