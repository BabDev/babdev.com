<?php

namespace BabDev\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int         $id
 * @property int         $category_id
 * @property string      $title
 * @property string      $slug
 * @property string|null $intro
 * @property string|null $content
 * @property Carbon      $published_at
 * @property array|null  $data
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Category $category
 *
 * @method static Builder|Post published()
 * @method static Builder|Post newModelQuery()
 * @method static Builder|Post newQuery()
 * @method static Builder|Post query()
 * @method static Builder|Post whereCategoryId($value)
 * @method static Builder|Post whereContent($value)
 * @method static Builder|Post whereCreatedAt($value)
 * @method static Builder|Post whereData($value)
 * @method static Builder|Post whereId($value)
 * @method static Builder|Post whereIntro($value)
 * @method static Builder|Post wherePublishedAt($value)
 * @method static Builder|Post whereSlug($value)
 * @method static Builder|Post whereTitle($value)
 * @method static Builder|Post whereUpdatedAt($value)
 */
class Post extends Model
{
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'intro',
        'content',
        'published_at',
        'data',
    ];

    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'data' => 'array',
        'published_at' => 'datetime',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('publish_at', '<=', now()->format('Y-m-d H:i:s'));
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
