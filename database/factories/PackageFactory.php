<?php

namespace Database\Factories;

use BabDev\Models\Package;
use BabDev\PackageType;
use Illuminate\Database\Eloquent\Factories\Factory;

class PackageFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Package::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(2, true),
            'display_name' => $this->faker->words(2, true),
            'has_documentation' => false,
            'package_type' => $this->faker->randomElement(
                [
                    PackageType::JOOMLA_EXTENSION,
                    PackageType::LARAVEL_PACKAGE,
                    PackageType::PHP_PACKAGE,
                    PackageType::PHPSPEC_EXTENSION,
                    PackageType::SYLIUS_PLUGIN,
                    PackageType::SYMFONY_BUNDLE,
                ],
            ),
            'supported' => true,
            'visible' => true,
            'is_packagist' => false,
        ];
    }

    public function docs()
    {
        return $this->state(
            [
                'has_documentation' => true,
                'docs_branches' => [
                    '1.x' => '1.x',
                ],
            ],
        );
    }

    public function notVisible()
    {
        return $this->state(
            [
                'visible' => false,
            ],
        );
    }

    public function packagist()
    {
        return $this->state(
            [
                'is_packagist' => true,
                'packagist_name' => str_replace(' ', '/', $this->faker->words(2, true)),
            ],
        );
    }
}
