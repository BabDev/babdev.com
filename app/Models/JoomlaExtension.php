<?php

namespace BabDev\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class JoomlaExtension extends Model
{
    use HasSlug;

    protected $fillable = [
        'name',
        'logo',
        'description',
        'supported',
    ];

    protected $casts = [
        'supported' => 'boolean',
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

    public function releases(): HasMany
    {
        return $this->hasMany(JoomlaExtensionRelease::class, 'extension_id');
    }
}
