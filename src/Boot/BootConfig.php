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

use InvalidArgumentException;
use Nytris\Core\Package\PackageFacadeInterface;
use Nytris\Core\Package\PackageInterface;

/**
 * Class BootConfig.
 *
 * Configures the Nytris platform for the application.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class BootConfig implements BootConfigInterface
{
    /**
     * @var PackageInterface[]
     */
    private array $packages = [];

    public function __construct(
        private readonly PlatformConfigInterface $platformConfig
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getPackages(): array
    {
        return $this->packages;
    }

    /**
     * @inheritDoc
     */
    public function getPlatformConfig(): PlatformConfigInterface
    {
        return $this->platformConfig;
    }

    /**
     * @inheritDoc
     */
    public function installPackage(PackageInterface $package): void
    {
        $packageFqcn = $package->getPackageFacadeFqcn();

        if (!is_a($packageFqcn, PackageFacadeInterface::class, true)) {
            throw new InvalidArgumentException(
                sprintf(
                    '%s() :: Package facade FQCN must be a "%s" but it was a "%s"',
                    __METHOD__,
                    PackageFacadeInterface::class,
                    $packageFqcn
                )
            );
        }

        $this->packages[] = $package;
    }
}
