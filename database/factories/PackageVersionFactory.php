<?php

namespace Database\Factories;

use App\Models\Package;
use App\Models\PackageVersion;
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
        return $this->state([
            'released' => now()->subYear(),
        ]);
    }

    public function unsupported(): static
    {
        return $this->state([
            'released' => now(),
        ]);
    }
}
