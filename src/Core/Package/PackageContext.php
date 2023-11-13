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

use Nytris\Boot\PlatformConfigInterface;

/**
 * Class PackageContext.
 *
 * Provides the context for a specific Nytris package.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class PackageContext implements PackageContextInterface
{
    /**
     * @param PlatformConfigInterface $platformConfig
     * @param class-string<PackageFacadeInterface> $packageFacadeFqcn
     */
    public function __construct(
        private readonly PlatformConfigInterface $platformConfig,
        private readonly string $packageFacadeFqcn
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getBaseCachePath(): string
    {
        return $this->platformConfig->getBaseCachePath();
    }

    /**
     * @inheritDoc
     */
    public function getPackageCachePath(): string
    {
        return $this->platformConfig->getBaseCachePath() . DIRECTORY_SEPARATOR .
            $this->packageFacadeFqcn::getVendor() . DIRECTORY_SEPARATOR .
            $this->packageFacadeFqcn::getName();
    }
}
