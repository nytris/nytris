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
        private readonly BootConfigInterface $config
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

            $packageContext = new PackageContext($platformConfig, $packageFacadeFqcn);

            /** @noinspection PhpUndefinedMethodInspection */
            $packageFacadeFqcn::install($packageContext, $package);
        }
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
