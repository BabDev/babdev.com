<?php

namespace BabDev\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class JoomlaExtensionRelease extends Model implements Sortable
{
    use SortableTrait;

    public const STABILITY_ALPHA = 'alpha';
    public const STABILITY_BETA = 'beta';
    public const STABILITY_RC = 'rc';
    public const STABILITY_STABLE = 'stable';

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

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function buildSortQuery()
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
