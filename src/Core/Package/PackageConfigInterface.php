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

namespace Nytris\Core\Package;

use Nytris\Core\Config\ConfigInterface;

/**
 * Interface PackageConfigInterface.
 *
 * Provides the configuration for a specific Nytris package.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface PackageConfigInterface extends ConfigInterface
{
    /**
     * Fetches the cache path for this package.
     */
    public function getPackageCachePath(): string;
}
