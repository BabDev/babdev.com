<?php

namespace BabDev\Models;

use Illuminate\Database\Eloquent\Model;
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
        'stars',
        'downloads',
        'language',
        'supported',
        'visible',
    ];

    protected $casts = [
        'topics' => 'array',
        'stars' => 'integer',
        'downloads' => 'integer',
        'supported' => 'boolean',
        'visible' => 'boolean',
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
}
