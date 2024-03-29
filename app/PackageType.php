<?php

namespace BabDev;

enum PackageType: string
{
    case JOOMLA_EXTENSION = 'joomla-extension';

    case LARAVEL_PACKAGE = 'laravel-package';

    case PHP_PACKAGE = 'php-package';

    case PHPSPEC_EXTENSION = 'phpspec-extension';

    case SYLIUS_PLUGIN = 'sylius-plugin';

    case SYMFONY_BUNDLE = 'symfony-bundle';

    public function label(): string
    {
        return trans('package_type.' . $this->value);
    }
}
