<?php

declare(strict_types=1);

use Jose\Component\Console\JKULoaderCommand;
use Jose\Component\Console\X5ULoaderCommand;
/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2020 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $container): void {
    $container = $container->services()
        ->defaults()
        ->private()
        ->autoconfigure()
        ->autowire()
    ;

    $container->set(JKULoaderCommand::class);
    $container->set(X5ULoaderCommand::class);
};