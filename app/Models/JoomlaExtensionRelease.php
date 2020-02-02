<?php

namespace BabDev\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class JoomlaExtensionRelease extends Model implements Sortable
{
    use HasSlug, SortableTrait;

    public $sortable = [
        'order_column_name' => 'ordering',
    ];

    protected $fillable = [
        'version',
        'maturity',
        'summary',
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

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('version')
            ->saveSlugsTo('slug');
    }

    public function buildSortQuery(): Builder
    {
        return static::query()->where('extension_id', '=', $this->extension_id);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published', '=', true);
    }

    public function extension(): BelongsTo
    {
        return $this->belongsTo(JoomlaExtension::class, 'extension_id');
    }
}
