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
 * Class PlatformFactory.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class PlatformFactory implements PlatformFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function createPlatform(BootConfigInterface $bootConfig): PlatformInterface
    {
        return new Platform($bootConfig);
    }
}
