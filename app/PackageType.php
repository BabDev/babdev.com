<?php

namespace App;

enum PackageType: string
{
    case JoomlaExtension = 'joomla-extension';

    case LaravelPackage = 'laravel-package';

    case PHPPackage = 'php-package';

    case PHPSpecExtension = 'phpspec-extension';

    case SyliusPlugin = 'sylius-plugin';

    case SymfonyBundle = 'symfony-bundle';

    public function label(): string
    {
        return match ($this) {
            PackageType::JoomlaExtension => 'Joomla! Extension',
            PackageType::LaravelPackage => 'Laravel Package',
            PackageType::PHPPackage => 'PHP Package',
            PackageType::PHPSpecExtension => 'phpspec Extension',
            PackageType::SyliusPlugin => 'Sylius Plugin',
            PackageType::SymfonyBundle => 'Symfony Bundle',
        };
    }
}
