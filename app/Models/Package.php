<?php

namespace BabDev\Models;

use BabDev\Models\Exceptions\DocumentationUnsupportedException;
use Carbon\Carbon;
use Database\Factories\PackageFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @property int         $id
 * @property string      $name
 * @property string      $display_name
 * @property string|null $packagist_name
 * @property string      $slug
 * @property string|null $logo
 * @property string|null $description
 * @property array|null  $topics
 * @property bool        $has_documentation
 * @property array|null  $docs_branches
 * @property string|null $default_docs_version
 * @property string|null $package_type
 * @property int         $stars
 * @property int|null    $downloads
 * @property string|null $language
 * @property bool        $supported
 * @property bool        $visible
 * @property bool        $is_packagist
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read string $github_url
 *
 * @method static Builder|Package isPackagist()
 * @method static Builder|Package query()
 * @method static Builder|Package visible()
 */
class Package extends Model
{
    use HasFactory;
    use HasSlug;

    protected $fillable = [
        'name',
        'display_name',
        'packagist_name',
        'logo',
        'description',
        'topics',
        'has_documentation',
        'docs_branches',
        'default_docs_version',
        'package_type',
        'stars',
        'downloads',
        'language',
        'supported',
        'visible',
        'is_packagist',
    ];

    protected $casts = [
        'topics' => 'array',
        'has_documentation' => 'boolean',
        'docs_branches' => 'array',
        'stars' => 'integer',
        'downloads' => 'integer',
        'supported' => 'boolean',
        'visible' => 'boolean',
        'is_packagist' => 'boolean',
    ];

    protected static function newFactory(): Factory
    {
        return PackageFactory::new();
    }

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

    public function scopeIsPackagist(Builder $query): Builder
    {
        return $query->where('is_packagist', '=', true);
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('visible', '=', true);
    }

    public function getGithubUrlAttribute(): string
    {
        return sprintf('https://github.com/BabDev/%s', $this->name);
    }

    public function hasDocsVersion(string $version): bool
    {
        if ($this->docs_branches === null) {
            return false;
        }

        return isset($this->docs_branches[$version]);
    }

    /**
     * @throws DocumentationUnsupportedException if the package does not support the given version
     */
    public function mapDocsVersionToGitBranch(string $version): string
    {
        if (!$this->hasDocsVersion($version)) {
            throw new DocumentationUnsupportedException(sprintf('Cannot map version "%s" to git branch for documentation', $version));
        }

        return $this->docs_branches[$version];
    }

    /**
     * @throws DocumentationUnsupportedException if the documentation branch map has not been created and a default documentation version has not been set
     */
    public function getDefaultDocsVersion(): string
    {
        if ($this->default_docs_version !== null) {
            return $this->default_docs_version;
        }

        if ($this->docs_branches !== null) {
            return (new Collection($this->docs_branches))->first();
        }

        throw new DocumentationUnsupportedException('No documentation mapping created');
    }
}
