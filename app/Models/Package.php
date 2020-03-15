<?php

namespace BabDev\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Package extends Model
{
    use HasSlug;

    protected $fillable = [
        'name',
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
    ];

    protected $casts = [
        'topics' => 'array',
        'stars' => 'integer',
        'downloads' => 'integer',
        'supported' => 'boolean',
        'visible' => 'boolean',
        'has_local_releases' => 'boolean',
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

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('visible', '=', true);
    }

    public function releases(): HasMany
    {
        return $this->hasMany(PackageRelease::class);
    }
}
