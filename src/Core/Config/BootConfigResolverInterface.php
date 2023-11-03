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

namespace Nytris\Core\Config;

use Nytris\Boot\BootConfigInterface;

/**
 * Interface BootConfigResolverInterface.
 *
 * Resolves the boot config from nytris.config.php, if present.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface BootConfigResolverInterface
{
    /**
     * Resolves the boot config, if present.
     */
    public function resolveBootConfig(): ?BootConfigInterface;
}
