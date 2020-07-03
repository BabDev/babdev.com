<?php

namespace BabDev\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
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
        return 'https://github.com/BabDev/' . $this->name;
    }

    public function hasDocsVersion(string $version): bool
    {
        if ($this->docs_branches === null) {
            return false;
        }

        return isset($this->docs_branches[$version]);
    }

    public function mapDocsVersionToGitBranch(string $version): string
    {
        if (!$this->hasDocsVersion($version)) {
            throw new \InvalidArgumentException(\sprintf('Cannot map version "%s" to git branch for documentation', $version));
        }

        return $this->docs_branches[$version];
    }

    public function getDefaultDocsVersion(): string
    {
        if ($this->default_docs_version !== null) {
            return $this->default_docs_version;
        }

        if ($this->docs_branches === null) {
            throw new \InvalidArgumentException('No documentation mapping created');
        }

        return \array_key_first($this->docs_branches);
    }
}
