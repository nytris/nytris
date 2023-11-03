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

namespace Nytris\Core\Bootstrap;

use Nytris\Boot\BootConfigInterface;
use Nytris\Core\Platform\PlatformInterface;

/**
 * Interface BootstrapInterface.
 *
 * Handles booting Nytris platform from a boot config nytris.config.php.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface BootstrapInterface
{
    /**
     * Boots Nytris platform from a boot config.
     */
    public function boot(BootConfigInterface $bootConfig): PlatformInterface;
}
