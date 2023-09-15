<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Php55\Rector\String_\StringClassNameToClassConstantRector;
use Rector\Php74\Rector\LNumber\AddLiteralSeparatorToNumberRector;
use Rector\Php80\Rector\Switch_\ChangeSwitchToMatchRector;
use Rector\PHPUnit\Set\PHPUnitLevelSetList;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\PostRector\Rector\NameImportingPostRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use RectorLaravel\Set\LaravelSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/database',
        __DIR__ . '/resources',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ]);

    $rectorConfig->skip([
        /*
         * Skip selected rules
         */
        AddLiteralSeparatorToNumberRector::class,

        /*
         * Skip rules for select files
         */
        ChangeSwitchToMatchRector::class => [
            // For readability, we don't want switch statements in these classes automatically being changed to match
        ],
        NameImportingPostRector::class              => [
            __DIR__ . '/app/Http/Kernel.php',
            __DIR__ . '/config/*.php',
        ],
        StringClassNameToClassConstantRector::class => [
            // Rector tries to change the 'Event' label to Event::class
            __DIR__ . '/config/app.php',
        ],
    ]);

    $rectorConfig->importNames();
    $rectorConfig->importShortClasses(false);

    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_82,
        SetList::CODE_QUALITY,
        LaravelSetList::LARAVEL_100,
        PHPUnitLevelSetList::UP_TO_PHPUNIT_100,
        PHPUnitSetList::PHPUNIT_CODE_QUALITY,
    ]);
};
