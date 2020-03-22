<?php

namespace BabDev\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class PackageRelease extends Model implements HasMedia, Sortable
{
    use HasSlug, InteractsWithMedia, SortableTrait;

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
            ->allowDuplicateSlugs()
            ->saveSlugsTo('slug');
    }

    protected function otherRecordExistsWithSlug(string $slug): bool
    {
        $key = $this->getKey();

        if ($this->incrementing) {
            $key ??= '0';
        }

        $query = static::query()->where($this->slugOptions->slugField, $slug)
            ->where($this->getKeyName(), '!=', $key)
            ->withoutGlobalScopes();

        if ($this->package_id) {
            $query->where('package_id', '!=', $this->package_id);
        }

        if ($this->usesSoftDeletes()) {
            $query->withTrashed();
        }

        return $query->exists();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('downloads')->useDisk('downloads');
    }

    public function buildSortQuery(): Builder
    {
        return static::query()->where('package_id', '=', $this->package_id);
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('visible', '=', true);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}
