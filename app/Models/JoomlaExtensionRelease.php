<?php

namespace BabDev\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class JoomlaExtensionRelease extends Model
{
    use HasSlug;

    public const STABILITY_ALPHA = 'alpha';
    public const STABILITY_BETA = 'beta';
    public const STABILITY_RC = 'rc';
    public const STABILITY_STABLE = 'stable';

    protected $fillable = [
        'version',
        'maturity',
        'changelog',
        'published',
        'published_at',
    ];

    protected $casts = [
        'published' => 'boolean',
    ];

    protected $dates = [
        'published_at',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('version')
            ->saveSlugsTo('slug');
    }

    public function extension(): BelongsTo
    {
        return $this->belongsTo(JoomlaExtension::class, 'extension_id');
    }
}
