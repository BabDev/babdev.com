<?php

namespace Database\Factories;

use BabDev\Models\Package;
use BabDev\Models\PackageUpdate;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PackageUpdate>
 */
class PackageUpdateFactory extends Factory
{
    /**
     * @var class-string<PackageUpdate>
     */
    protected $model = PackageUpdate::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'slug' => $this->faker->slug,
            'intro' => $this->faker->paragraph,
            'content' => $this->faker->paragraphs(3, true),
            'published_at' => Carbon::now(),
            'package_id' => Package::factory(),
        ];
    }

    public function unpublished(): static
    {
        return $this->state(
            [
                'published_at' => Carbon::now()->addYear(),
            ],
        );
    }
}
