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

namespace Nytris\Boot;

use Nytris\Core\Package\PackageInterface;

/**
 * Interface BootConfigInterface.
 *
 * Configures the Nytris platform for the application.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface BootConfigInterface
{
    /**
     * Fetches the installed packages.
     *
     * @return PackageInterface[]
     */
    public function getPackages(): array;

    /**
     * Fetches the defined Nytris platform config.
     */
    public function getPlatformConfig(): PlatformConfigInterface;

    /**
     * Installs a Nytris package to be used.
     */
    public function installPackage(PackageInterface $package): void;
}
