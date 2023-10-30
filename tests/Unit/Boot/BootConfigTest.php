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

namespace Nytris\Tests\Unit\Boot;

use InvalidArgumentException;
use Mockery\MockInterface;
use Nytris\Boot\BootConfig;
use Nytris\Boot\PlatformConfigInterface;
use Nytris\Core\Package\PackageFacadeInterface;
use Nytris\Core\Package\PackageInterface;
use Nytris\Tests\AbstractTestCase;
use stdClass;

/**
 * Class BootConfigTest.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class BootConfigTest extends AbstractTestCase
{
    private BootConfig $bootConfig;
    private MockInterface&PlatformConfigInterface $platformConfig;

    public function setUp(): void
    {
        $this->platformConfig = mock(PlatformConfigInterface::class);

        $this->bootConfig = new BootConfig($this->platformConfig);
    }

    public function testGetPackagesReturnsAllInstalledPackages(): void
    {
        $package1 = mock(PackageInterface::class, [
            'getPackageFacadeFqcn' => PackageFacadeInterface::class,
        ]);
        $this->bootConfig->installPackage($package1);
        $package2 = mock(PackageInterface::class, [
            'getPackageFacadeFqcn' => PackageFacadeInterface::class,
        ]);
        $this->bootConfig->installPackage($package2);

        static::assertSame([$package1, $package2], $this->bootConfig->getPackages());
    }

    public function testGetPlatformConfigFetchesThePlatformConfig(): void
    {
        static::assertSame($this->platformConfig, $this->bootConfig->getPlatformConfig());
    }

    public function testInstallPackageRaisesExceptionWhenFacadeFqcnDoesNotImplementInterface(): void
    {
        $package = mock(PackageInterface::class, [
            'getPackageFacadeFqcn' => stdClass::class,
        ]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Nytris\Boot\BootConfig::installPackage() :: Package facade FQCN ' .
            'must be a "Nytris\Core\Package\PackageFacadeInterface" but it was a "stdClass"'
        );

        $this->bootConfig->installPackage($package);
    }
}
