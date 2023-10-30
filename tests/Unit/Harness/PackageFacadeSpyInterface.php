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

namespace Nytris\Tests\Unit\Harness;

use Nytris\Core\Package\PackageContextInterface;
use Nytris\Core\Package\PackageInterface;

/**
 * Interface PackageFacadeSpyInterface.
 *
 * Allows type-safe testing of the static package API.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface PackageFacadeSpyInterface
{
    /**
     * Installs the package.
     */
    public function install(PackageContextInterface $packageContext, PackageInterface $package): void;

    /**
     * Uninstalls the package.
     */
    public function uninstall(): void;
}
