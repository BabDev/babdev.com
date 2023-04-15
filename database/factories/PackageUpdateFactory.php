<?php

namespace Database\Factories;

use BabDev\Models\Package;
use BabDev\Models\PackageUpdate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @template TModel of PackageUpdate
 * @extends Factory<TModel>
 */
class PackageUpdateFactory extends Factory
{
    /**
     * @var class-string<TModel>
     */
    protected $model = PackageUpdate::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence,
            'slug' => fake()->slug,
            'intro' => fake()->paragraph,
            'content' => fake()->paragraphs(3, true),
            'published_at' => now(),
            'package_id' => Package::factory(),
        ];
    }

    public function unpublished(): static
    {
        return $this->state([
            'published_at' => now()->addYear(),
        ]);
    }
}
