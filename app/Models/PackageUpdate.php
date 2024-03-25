<?php

namespace BabDev\Models;

use Carbon\Carbon;
use Database\Factories\PackageUpdateFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

/**
 * @property int         $id
 * @property int         $package_id
 * @property string      $title
 * @property string      $slug
 * @property string|null $intro
 * @property string|null $content
 * @property Carbon      $published_at
 * @property array|null  $data
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read bool    $is_published
 * @property-read Package $package
 *
 * @method static PackageUpdateFactory  factory(...$parameters)
 * @method static Builder|PackageUpdate published()
 * @method static Builder|PackageUpdate newModelQuery()
 * @method static Builder|PackageUpdate newQuery()
 * @method static Builder|PackageUpdate query()
 * @method static Builder|PackageUpdate whereContent($value)
 * @method static Builder|PackageUpdate whereCreatedAt($value)
 * @method static Builder|PackageUpdate whereData($value)
 * @method static Builder|PackageUpdate whereId($value)
 * @method static Builder|PackageUpdate whereIntro($value)
 * @method static Builder|PackageUpdate wherePackageId($value)
 * @method static Builder|PackageUpdate wherePublishedAt($value)
 * @method static Builder|PackageUpdate whereSlug($value)
 * @method static Builder|PackageUpdate whereTitle($value)
 * @method static Builder|PackageUpdate whereUpdatedAt($value)
 */
class PackageUpdate extends Model implements Feedable
{
    use HasFactory;

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
     * @return Collection<array-key, self>
     */
    public static function getFeedItems(): Collection
    {
        return self::all();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function toFeedItem(): FeedItem
    {
        return FeedItem::create()
            ->id($this->id)
            ->title($this->title)
            ->summary($this->intro)
            ->updated($this->updated_at)
            ->link(route('open-source.update', ['update' => $this]))
            ->authorName('Michael Babker');
    }

    /**
     * @param Builder<self> $query
     *
     * @return Builder<self>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published_at', '<=', now()->format('Y-m-d H:i:s'));
    }

    /**
     * @return BelongsTo<Package, self>
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    /**
     * @return Attribute<bool, null>
     */
    protected function isPublished(): Attribute
    {
        return new Attribute(
            get: fn () => $this->published_at->isBefore(now()),
        );
    }

    /**
     * @return array<string, class-string|string>
     */
    protected function casts(): array
    {
        return [
            'data' => 'array',
            'published_at' => 'datetime',
        ];
    }
}
