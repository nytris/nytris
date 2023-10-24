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
 * Class PackageConfig.
 *
 * Provides the configuration for a specific Nytris package.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class PackageConfig implements PackageConfigInterface
{
    /**
     * @param PlatformConfigInterface $platformConfig
     * @param class-string<PackageInterface> $packageFqcn
     */
    public function __construct(
        private readonly PlatformConfigInterface $platformConfig,
        private readonly string $packageFqcn
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
        return $this->platformConfig->getBaseCachePath() . '/' . $this->packageFqcn::getName();
    }
}
