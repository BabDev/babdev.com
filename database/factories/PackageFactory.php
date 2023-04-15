<?php

namespace Database\Factories;

use BabDev\Models\Package;
use BabDev\PackageType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @template TModel of Package
 * @extends Factory<TModel>
 */
class PackageFactory extends Factory
{
    /**
     * @var class-string<TModel>
     */
    protected $model = Package::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(2, true),
            'display_name' => fake()->words(2, true),
            'has_documentation' => false,
            'package_type' => fake()->randomElement(PackageType::cases()),
            'supported' => true,
            'visible' => true,
            'is_packagist' => false,
        ];
    }

    public function docs(): static
    {
        return $this->state([
            'has_documentation' => true,
        ]);
    }

    public function notVisible(): static
    {
        return $this->state([
            'visible' => false,
        ]);
    }

    public function packagist(): static
    {
        return $this->state([
            'is_packagist' => true,
            'packagist_name' => str_replace(' ', '/', fake()->words(2, true)),
        ]);
    }
}
