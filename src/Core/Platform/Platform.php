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

namespace Nytris\Core\Platform;

use Nytris\Boot\BootConfigInterface;
use Nytris\Core\Package\PackageContext;
use Nytris\Core\Resolver\ResolverInterface;

/**
 * Class Platform.
 *
 * Represents the Nytris platform for the application.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class Platform implements PlatformInterface
{
    public function __construct(
        private readonly BootConfigInterface $config,
        private readonly ResolverInterface $resolver
    ) {
    }

    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        $platformConfig = $this->config->getPlatformConfig();

        foreach ($this->config->getPackages() as $package) {
            $packageFacadeFqcn = $package->getPackageFacadeFqcn();

            $packageContext = new PackageContext($this->resolver, $platformConfig, $packageFacadeFqcn);

            /** @noinspection PhpUndefinedMethodInspection */
            $packageFacadeFqcn::install($packageContext, $package);
        }
    }

    /**
     * @inheritDoc
     */
    public function isPackageInstalled(string $packageFqcn): bool
    {
        foreach ($this->config->getPackages() as $package) {
            if ($package instanceof $packageFqcn) {
                return true;
            }
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function resolveProjectRoot(): string
    {
        return $this->resolver->resolveProjectRoot();
    }

    /**
     * @inheritDoc
     */
    public function shutdown(): void
    {
        foreach ($this->config->getPackages() as $package) {
            $packageFacadeFqcn = $package->getPackageFacadeFqcn();

            /** @noinspection PhpUndefinedMethodInspection */
            $packageFacadeFqcn::uninstall();
        }
    }
}
