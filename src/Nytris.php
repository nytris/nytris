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

use LogicException;
use Nytris\Core\Platform\PlatformInterface;

/**
 * Class Nytris.
 *
 * Stores the global Nytris platform instance.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class Nytris
{
    private static ?PlatformInterface $platform = null;

    /**
     * Fetches the current global Nytris Platform.
     */
    public static function getPlatform(): PlatformInterface
    {
        if (self::$platform === null) {
            throw new LogicException('No Nytris Platform is currently set');
        }

        return self::$platform;
    }

    /**
     * Sets the current global Nytris Platform.
     */
    public static function setPlatform(?PlatformInterface $platform): void
    {
        self::$platform = $platform;
    }
}
