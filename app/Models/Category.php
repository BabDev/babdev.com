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
 * @property int                    $id
 * @property string                 $title
 * @property string                 $slug
 * @property Carbon|null            $created_at
 * @property Carbon|null            $updated_at
 * @property-read Collection|Post[] $posts
 * @property-read int|null          $posts_count
 *
 * @method static Builder|Category query()
 */
class Category extends Model
{
    use HasSlug;

    protected $fillable = [
        'title',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
