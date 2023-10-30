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
 * Provides the configuration for a specific Nytris package.
 * Implemented by Nytris packages.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface PackageInterface
{
    /**
     * Fetches the FQCN of the Nytris package facade.
     *
     * @return class-string<PackageFacadeInterface>
     */
    public function getPackageFacadeFqcn(): string;
}
