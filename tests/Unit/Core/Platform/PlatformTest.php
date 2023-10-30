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

namespace Nytris\Tests\Unit\Core\Platform;

use Mockery;
use Mockery\MockInterface;
use Nytris\Boot\BootConfigInterface;
use Nytris\Boot\PlatformConfigInterface;
use Nytris\Core\Package\PackageContextInterface;
use Nytris\Core\Package\PackageFacadeInterface;
use Nytris\Core\Package\PackageInterface;
use Nytris\Core\Platform\Platform;
use Nytris\Tests\AbstractTestCase;
use Nytris\Tests\Unit\Harness\PackageFacadeSpyInterface;

/**
 * Class PlatformTest.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class PlatformTest extends AbstractTestCase
{
    private MockInterface&BootConfigInterface $bootConfig;
    private MockInterface&PackageInterface $package1;
    /**
     * @var class-string<PackageFacadeInterface>
     */
    private string $packageFacade1Fqcn;
    public MockInterface&PackageFacadeSpyInterface $packageFacade1Spy;
    private MockInterface&PackageInterface $package2;
    /**
     * @var class-string<PackageFacadeInterface>
     */
    private string $packageFacade2Fqcn;
    public MockInterface&PackageFacadeSpyInterface $packageFacade2Spy;
    private Platform $platform;
    private MockInterface&PlatformConfigInterface $platformConfig;

    public function setUp(): void
    {
        $this->platformConfig = mock(PlatformConfigInterface::class);
        $this->packageFacade1Spy = spy(PackageFacadeSpyInterface::class);
        $this->packageFacade1Fqcn = get_class(new class implements PackageFacadeInterface {
            public static PlatformTest $test;

            public static function getName(): string
            {
                return 'package1';
            }

            public static function getVendor(): string
            {
                return 'test';
            }

            public static function install(PackageContextInterface $packageContext, PackageInterface $package): void
            {
                self::$test->packageFacade1Spy->install($packageContext, $package);
            }

            public static function uninstall(): void
            {
                self::$test->packageFacade1Spy->uninstall();
            }
        });
        $this->package1 = mock(PackageInterface::class, [
            'getPackageFacadeFqcn' => $this->packageFacade1Fqcn,
        ]);
        $this->packageFacade1Fqcn::$test = $this;

        $this->packageFacade2Spy = spy(PackageFacadeSpyInterface::class);
        $this->packageFacade2Fqcn = get_class(new class implements PackageFacadeInterface {
            public static PlatformTest $test;

            public static function getName(): string
            {
                return 'package2';
            }

            public static function getVendor(): string
            {
                return 'test';
            }

            public static function install(PackageContextInterface $packageContext, PackageInterface $package): void
            {
                self::$test->packageFacade2Spy->install($packageContext, $package);
            }

            public static function uninstall(): void
            {
                self::$test->packageFacade2Spy->uninstall();
            }
        });
        $this->package2 = mock(PackageInterface::class, [
            'getPackageFacadeFqcn' => $this->packageFacade2Fqcn,
        ]);
        $this->packageFacade2Fqcn::$test = $this;

        $this->bootConfig = mock(BootConfigInterface::class, [
            'getPackages' => [$this->package1, $this->package2],
            'getPlatformConfig' => $this->platformConfig,
        ]);

        $this->platform = new Platform($this->bootConfig);
    }

    public function testBootInstallsAllRegisteredPackages(): void
    {
        $this->packageFacade1Spy->expects()
            ->install(Mockery::type(PackageContextInterface::class), $this->package1)
            ->once();
        $this->packageFacade2Spy->expects()
            ->install(Mockery::type(PackageContextInterface::class), $this->package2)
            ->once();

        $this->platform->boot();
    }

    public function testShutdownUninstallsAllRegisteredPackages(): void
    {
        $this->packageFacade1Spy->expects()
            ->uninstall()
            ->once();
        $this->packageFacade2Spy->expects()
            ->uninstall()
            ->once();

        $this->platform->shutdown();
    }
}
