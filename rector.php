<?php

declare(strict_types=1);

/**
 * This file is part of PHPDevsr/recaptcha-codeigniter4.
 *
 * (c) 2023 Denny Septian Panggabean <xamidimura@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use PHPDevsr\Rector\Codeigniter4\Set\CodeigniterSetList;
use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPromotedPropertyRector;
use Rector\Php55\Rector\String_\StringClassNameToClassConstantRector;
use Rector\Php73\Rector\FuncCall\JsonThrowOnErrorRector;
use Rector\Php73\Rector\FuncCall\StringifyStrNeedlesRector;
use Rector\Php80\Rector\Class_\AnnotationToAttributeRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->sets([
        CodeigniterSetList::CODEIGNITER_44,
    ]);

    // auto import fully qualified class names
    $rectorConfig->importNames();
    $rectorConfig->removeUnusedImports();

    // The paths to refactor (can also be supplied with CLI arguments)
    $rectorConfig->paths([
        __DIR__ . '/app',
        __DIR__ . '/tests',
    ]);

    // Include Composer's autoload - required for global execution, remove if running locally
    $rectorConfig->autoloadPaths([
        __DIR__ . '/vendor/autoload.php',
    ]);

    // Do you need to include constants, class aliases, or a custom autoloader?
    $rectorConfig->bootstrapFiles([
        realpath(getcwd()) . '/vendor/codeigniter4/framework/system/Test/bootstrap.php',
    ]);

    if (is_file(__DIR__ . '/phpstan.neon.dist')) {
        $rectorConfig->phpstanConfig(__DIR__ . '/phpstan.neon.dist');
    }

    // Are there files or rules you need to skip?
    $rectorConfig->skip([
        __DIR__ . '/app/Views',

        JsonThrowOnErrorRector::class,
        StringifyStrNeedlesRector::class,

        // Note: requires php 8
        RemoveUnusedPromotedPropertyRector::class,

        // May load view files directly when detecting classes
        StringClassNameToClassConstantRector::class,

        AnnotationToAttributeRector::class,
    ]);
};
