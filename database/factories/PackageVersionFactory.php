<?php

namespace Database\Factories;

use BabDev\Models\Package;
use BabDev\Models\PackageVersion;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @template TModel of PackageVersion
 * @extends Factory<TModel>
 */
class PackageVersionFactory extends Factory
{
    /**
     * @var class-string<TModel>
     */
    protected $model = PackageVersion::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'version' => '1.x',
            'package_id' => Package::factory(),
        ];
    }

    public function released(): static
    {
        return $this->state(
            [
                'released' => Carbon::now()->subYear(),
            ],
        );
    }

    public function unsupported(): static
    {
        return $this->state(
            [
                'released' => Carbon::now(),
            ],
        );
    }
}
