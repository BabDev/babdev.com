<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Php81\Rector\Array_\FirstClassCallableRector;
use Rector\PostRector\Rector\NameImportingPostRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/database',
        __DIR__ . '/resources',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ])
    ->withSkip([
        /*
         * Skip selected rules
         */

        /*
         * Skip rules for select files
         */
        FirstClassCallableRector::class => [
            __DIR__ . '/config/*.php',
        ],
        NameImportingPostRector::class  => [
            __DIR__ . '/app/Http/Kernel.php',
            __DIR__ . '/config/*.php',
        ],
    ])
    ->withPreparedSets(codeQuality: true, phpunitCodeQuality: true)
    ->withComposerBased(phpunit: true)
    ->withPhpSets()
    ->withImportNames(importShortClasses: false)
    ->withBootstrapFiles([
        __DIR__ . '/vendor/larastan/larastan/bootstrap.php',
    ])
    ->withPHPStanConfigs([
        __DIR__ . '/vendor/larastan/larastan/extension.neon',
        __DIR__ . '/vendor/phpstan/phpstan-mockery/extension.neon',
        __DIR__ . '/vendor/phpstan/phpstan-phpunit/extension.neon',
        __DIR__ . '/phpstan.neon',
    ])
;
