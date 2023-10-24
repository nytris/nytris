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

namespace Nytris\Core\Platform;

/**
 * Interface PlatformInterface.
 *
 * Represents the Nytris platform for the application.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface PlatformInterface
{
    /**
     * Boots the Nytris platform.
     */
    public function boot(): void;

    /**
     * Shuts down the Nytris platform.
     */
    public function shutdown(): void;
}