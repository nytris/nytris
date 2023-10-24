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
     * @var class-string<PackageInterface>[]
     */
    private array $packageFqcns = [];

    public function __construct(
        private readonly PlatformConfigInterface $platformConfig
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getPackages(): array
    {
        return $this->packageFqcns;
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
    public function installPackage(string $packageFqcn): void
    {
        if (!is_a($packageFqcn, PackageInterface::class, true)) {
            throw new InvalidArgumentException(
                sprintf(
                    '%s() :: $packageFqcn must be a "%s" but it was a "%s"',
                    __METHOD__,
                    PackageInterface::class,
                    $packageFqcn
                )
            );
        }

        $this->packageFqcns[] = $packageFqcn;
    }
}
