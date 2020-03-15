<?php

namespace BabDev;

final class PackageType
{
    public const JOOMLA_EXTENSION = 'joomla-extension';
    public const LARAVEL_PACKAGE = 'laravel-package';
    public const PHP_PACKAGE = 'php-package';
    public const SYLIUS_PLUGIN = 'sylius-plugin';
    public const SYMFONY_BUNDLE = 'symfony-bundle';

    private function __construct()
    {
    }
}
