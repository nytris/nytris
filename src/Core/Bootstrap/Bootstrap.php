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
use Nytris\Core\Platform\PlatformFactoryInterface;
use Nytris\Core\Platform\PlatformInterface;

/**
 * Class Bootstrap.
 *
 * Handles booting Nytris platform from a boot config nytris.config.php.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class Bootstrap implements BootstrapInterface
{
    public function __construct(
        private readonly PlatformFactoryInterface $platformFactory
    ) {
    }

    /**
     * @inheritDoc
     */
    public function boot(BootConfigInterface $bootConfig): PlatformInterface
    {
        $platform = $this->platformFactory->createPlatform($bootConfig);

        $platform->boot();

        return $platform;
    }
}
