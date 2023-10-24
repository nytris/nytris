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


use Nytris\Boot\BootConfigInterface;

/**
 * Interface PlatformFactoryInterface.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface PlatformFactoryInterface
{
    /**
     * Creates the Nytris platform instance.
     */
    public function createPlatform(BootConfigInterface $bootConfig): PlatformInterface;
}
