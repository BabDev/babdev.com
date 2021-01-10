<?php

namespace Database\Factories;

use BabDev\Models\Package;
use BabDev\Models\PackageUpdate;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class PackageUpdateFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = PackageUpdate::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'intro' => $this->faker->paragraph,
            'content' => $this->faker->paragraphs(3, true),
            'published_at' => Carbon::now(),
            'package_id' => Package::factory(),
        ];
    }

    public function unpublished()
    {
        return $this->state(
            [
                'published_at' => Carbon::now()->addYear(),
            ]
        );
    }
}
