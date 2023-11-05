<?php

/*
 * Nytris - Bootstrap library for Nytris.
 * Copyright (c) Dan Phillimore (asmblah)
 * https://github.com/nytris/nytris/
 *
 * Released under the MIT license.
 * https://github.com/nytris/nytris/raw/main/MIT-LICENSE.txt
 */

declare(strict_types=1);

namespace Nytris;

use Composer\Autoload\ClassLoader;
use LogicException;
use Nytris\Boot\BootConfigInterface;
use Nytris\Core\Bootstrap\Bootstrap;
use Nytris\Core\Bootstrap\BootstrapInterface;
use Nytris\Core\Config\BootConfigResolver;
use Nytris\Core\Config\BootConfigResolverInterface;
use Nytris\Core\Includer\Includer;
use Nytris\Core\Platform\PlatformFactory;
use Nytris\Core\Platform\PlatformInterface;
use ReflectionClass;

/**
 * Class Nytris.
 *
 * Boots and manages the global Nytris platform.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class Nytris
{
    private static ?BootstrapInterface $bootstrap;
    private static ?PlatformInterface $platform = null;

    /**
     * Boots Nytris platform with the given config.
     *
     * If nytris.config.php is present in the root project, this will be done automatically.
     */
    public static function boot(BootConfigInterface $bootConfig): void
    {
        if (self::$bootstrap === null) {
            throw new LogicException('Nytris platform has not yet been initialised');
        }

        if (self::$platform !== null) {
            throw new LogicException('Nytris platform has already been booted');
        }

        // Store the platform globally.
        self::$platform = self::$bootstrap->boot($bootConfig);
    }

    /**
     * Fetches the current global Nytris Platform.
     */
    public static function getPlatform(): PlatformInterface
    {
        if (self::$platform === null) {
            throw new LogicException('No Nytris platform has yet been booted');
        }

        return self::$platform;
    }

    /**
     * Determines whether Nytris platform has booted.
     */
    public static function hasBooted(): bool
    {
        return self::$platform !== null;
    }

    /**
     * Initialises Nytris platform ready to be booted.
     */
    public static function initialise(
        ?BootstrapInterface $bootstrap = null,
        ?BootConfigResolverInterface $bootConfigResolver = null
    ): void {
        self::$bootstrap = $bootstrap ?? new Bootstrap(new PlatformFactory());
        $bootConfigResolver ??= new BootConfigResolver(new ReflectionClass(ClassLoader::class), new Includer());

        $bootConfig = $bootConfigResolver->resolveBootConfig();

        if ($bootConfig !== null) {
            // nytris.config.php is present and valid, so we can boot from it.
            self::boot($bootConfig);
        }
    }

    /**
     * Uninitialises Nytris platform, shutting it down if it has previously been booted.
     */
    public static function uninitialise(): void
    {
        if (self::$platform !== null) {
            self::$platform->shutdown();

            self::$platform = null;
        }

        self::$bootstrap = null;
    }
}
