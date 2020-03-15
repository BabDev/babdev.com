<?php

namespace BabDev\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class PackageRelease extends Model implements Sortable
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
        'visible',
        'released_at',
    ];

    protected $casts = [
        'visible' => 'boolean',
    ];

    protected $dates = [
        'released_at',
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
        return static::query()->where('package_id', '=', $this->package_id);
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('visible', '=', true);
    }

    public function extension(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}
