<?php

namespace BabDev\Models;

use BabDev\Models\Exceptions\VersionsNotConfigured;
use BabDev\PackageType;
use Carbon\Carbon;
use Database\Factories\PackageFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @property int              $id
 * @property string           $name
 * @property string           $display_name
 * @property string|null      $packagist_name
 * @property string           $slug
 * @property string|null      $description
 * @property array|null       $topics
 * @property bool             $has_documentation
 * @property PackageType|null $package_type
 * @property int              $stars
 * @property int|null         $downloads
 * @property string|null      $language
 * @property bool             $supported
 * @property bool             $visible
 * @property bool             $is_packagist
 * @property Carbon|null      $created_at
 * @property Carbon|null      $updated_at
 *
 * @property-read string                     $github_url
 * @property-read Collection<PackageUpdate>  $updates
 * @property-read int|null                   $updates_count
 * @property-read Collection<PackageVersion> $versions
 * @property-read int|null                   $versions_count
 *
 * @method static PackageFactory  factory(...$parameters)
 * @method static Builder|Package isPackagist()
 * @method static Builder|Package visible()
 * @method static Builder|Package newModelQuery()
 * @method static Builder|Package newQuery()
 * @method static Builder|Package query()
 * @method static Builder|Package whereCreatedAt($value)
 * @method static Builder|Package whereDefaultDocsVersion($value)
 * @method static Builder|Package whereDescription($value)
 * @method static Builder|Package whereDisplayName($value)
 * @method static Builder|Package whereDocsBranches($value)
 * @method static Builder|Package whereDownloads($value)
 * @method static Builder|Package whereHasDocumentation($value)
 * @method static Builder|Package whereId($value)
 * @method static Builder|Package whereIsPackagist($value)
 * @method static Builder|Package whereLanguage($value)
 * @method static Builder|Package whereName($value)
 * @method static Builder|Package wherePackageType($value)
 * @method static Builder|Package wherePackagistName($value)
 * @method static Builder|Package whereSlug($value)
 * @method static Builder|Package whereStars($value)
 * @method static Builder|Package whereSupported($value)
 * @method static Builder|Package whereTopics($value)
 * @method static Builder|Package whereUpdatedAt($value)
 * @method static Builder|Package whereVisible($value)
 */
class Package extends Model
{
    use HasFactory;
    use HasSlug;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'display_name',
        'packagist_name',
        'description',
        'topics',
        'has_documentation',
        'package_type',
        'stars',
        'downloads',
        'language',
        'supported',
        'visible',
        'is_packagist',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'package_type' => PackageType::PHP_PACKAGE,
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

    /**
     * @param Builder<self> $query
     *
     * @return Builder<self>
     */
    public function scopeIsPackagist(Builder $query): Builder
    {
        return $query->where('is_packagist', '=', true);
    }

    /**
     * @param Builder<self> $query
     *
     * @return Builder<self>
     */
    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('visible', '=', true);
    }

    /**
     * @return HasMany<PackageUpdate>
     */
    public function updates(): HasMany
    {
        return $this->hasMany(PackageUpdate::class);
    }

    /**
     * @return HasMany<PackageVersion>
     */
    public function versions(): HasMany
    {
        return $this->hasMany(PackageVersion::class);
    }

    /**
     * @return Attribute<string, null>
     */
    protected function githubUrl(): Attribute
    {
        return new Attribute(
            get: fn () => sprintf('https://github.com/BabDev/%s', $this->name),
        );
    }

    /**
     * @throws VersionsNotConfigured if the package does not have versions
     */
    public function latestVersion(): PackageVersion
    {
        $packageVersion = $this->versions()->newestReleasedVersionForPackage()->first();

        if ($packageVersion instanceof PackageVersion) {
            return $packageVersion;
        }

        $packageVersion = $this->versions()->first();

        if (!$packageVersion instanceof PackageVersion) {
            throw new VersionsNotConfigured(sprintf('Versions are not configured for the "%s" package.', $this->display_name));
        }

        return $packageVersion;
    }

    /**
     * @return array<string, class-string|string>
     */
    protected function casts(): array
    {
        return [
            'topics' => 'array',
            'has_documentation' => 'boolean',
            'package_type' => PackageType::class,
            'stars' => 'integer',
            'downloads' => 'integer',
            'supported' => 'boolean',
            'visible' => 'boolean',
            'is_packagist' => 'boolean',
        ];
    }
}
