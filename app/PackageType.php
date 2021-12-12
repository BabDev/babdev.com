<?php

namespace BabDev;

enum PackageType: string
{
    case JOOMLA_EXTENSION = 'joomla-extension';

    case LARAVEL_PACKAGE = 'laravel-package';

    case PHP_PACKAGE = 'php-package';

    case SYLIUS_PLUGIN = 'sylius-plugin';

    case SYMFONY_BUNDLE = 'symfony-bundle';
}
