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

/**
 * Interface PackageInterface.
 *
 * Implemented by Nytris packages.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface PackageInterface
{
    /**
     * Fetches the name of the package within its vendor.
     */
    public static function getName(): string;

    /**
     * Fetches the unique name of the package vendor.
     */
    public static function getVendor(): string;

    /**
     * Installs the package.
     */
    public static function install(PackageConfigInterface $packageConfig): void;

    /**
     * Uninstalls the package.
     */
    public static function uninstall(): void;
}
