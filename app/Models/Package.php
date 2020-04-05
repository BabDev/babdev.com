<?php

namespace BabDev\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @property int                              $id
 * @property string                           $name
 * @property string                           $display_name
 * @property string|null                      $packagist_name
 * @property string                           $slug
 * @property string|null                      $logo
 * @property string|null                      $description
 * @property array|null                       $topics
 * @property string                           $documentation_type
 * @property string|null                      $package_type
 * @property int                              $stars
 * @property int|null                         $downloads
 * @property string|null                      $language
 * @property bool                             $supported
 * @property bool                             $visible
 * @property bool                             $has_local_releases
 * @property bool                             $is_packagist
 * @property Carbon|null                      $created_at
 * @property Carbon|null                      $updated_at
 * @property-read string                      $github_url
 * @property-read Collection|PackageRelease[] $releases
 * @property-read int|null                    $releases_count
 *
 * @method static Builder|Package hasLocalReleases()
 * @method static Builder|Package isPackagist()
 * @method static Builder|Package query()
 * @method static Builder|Package visible()
 */
class Package extends Model
{
    use HasSlug;

    protected $fillable = [
        'name',
        'display_name',
        'packagist_name',
        'logo',
        'description',
        'topics',
        'documentation_type',
        'package_type',
        'stars',
        'downloads',
        'language',
        'supported',
        'visible',
        'has_local_releases',
        'is_packagist',
    ];

    protected $casts = [
        'topics' => 'array',
        'stars' => 'integer',
        'downloads' => 'integer',
        'supported' => 'boolean',
        'visible' => 'boolean',
        'has_local_releases' => 'boolean',
        'is_packagist' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function scopeHasLocalReleases(Builder $query): Builder
    {
        return $query->where('has_local_releases', '=', true);
    }

    public function scopeIsPackagist(Builder $query): Builder
    {
        return $query->where('is_packagist', '=', true);
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('visible', '=', true);
    }

    public function releases(): HasMany
    {
        return $this->hasMany(PackageRelease::class);
    }

    public function getGithubUrlAttribute(): string
    {
        return 'https://github.com/BabDev/' . $this->name;
    }
}
