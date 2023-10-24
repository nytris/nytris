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
use Nytris\Core\Package\PackageConfigInterface;
use Nytris\Core\Package\PackageInterface;
use Nytris\Core\Platform\Platform;
use Nytris\Tests\AbstractTestCase;
use Nytris\Tests\Unit\Harness\PackageSpyInterface;

/**
 * Class PlatformTest.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class PlatformTest extends AbstractTestCase
{
    private MockInterface&BootConfigInterface $config;
    /**
     * @var class-string<PackageInterface>
     */
    private string $package1Fqcn;
    public MockInterface&PackageSpyInterface $package1Spy;
    /**
     * @var class-string<PackageInterface>
     */
    private string $package2Fqcn;
    public MockInterface&PackageSpyInterface $package2Spy;
    private Platform $platform;
    private MockInterface&PlatformConfigInterface $platformConfig;

    public function setUp(): void
    {
        $this->platformConfig = mock(PlatformConfigInterface::class);
        $this->package1Spy = spy(PackageSpyInterface::class);
        $this->package1Fqcn = get_class(new class implements PackageInterface {
            public static PlatformTest $test;

            public static function getName(): string
            {
                return 'package1';
            }

            public static function getVendor(): string
            {
                return 'test';
            }

            public static function install(PackageConfigInterface $packageConfig): void
            {
                self::$test->package1Spy->install($packageConfig);
            }

            public static function uninstall(): void
            {
                self::$test->package1Spy->uninstall();
            }
        });
        $this->package1Fqcn::$test = $this;

        $this->package2Spy = spy(PackageSpyInterface::class);
        $this->package2Fqcn = get_class(new class implements PackageInterface {
            public static PlatformTest $test;

            public static function getName(): string
            {
                return 'package2';
            }

            public static function getVendor(): string
            {
                return 'test';
            }

            public static function install(PackageConfigInterface $packageConfig): void
            {
                self::$test->package2Spy->install($packageConfig);
            }

            public static function uninstall(): void
            {
                self::$test->package2Spy->uninstall();
            }
        });
        $this->package2Fqcn::$test = $this;

        $this->config = mock(BootConfigInterface::class, [
            'getPackages' => [$this->package1Fqcn, $this->package2Fqcn],
            'getPlatformConfig' => $this->platformConfig,
        ]);

        $this->platform = new Platform($this->config);
    }

    public function testBootInstallsAllRegisteredPackages(): void
    {
        $this->package1Spy->expects()
            ->install(Mockery::type(PackageConfigInterface::class))
            ->once();
        $this->package2Spy->expects()
            ->install(Mockery::type(PackageConfigInterface::class))
            ->once();

        $this->platform->boot();
    }

    public function testShutdownUninstallsAllRegisteredPackages(): void
    {
        $this->package1Spy->expects()
            ->uninstall()
            ->once();
        $this->package2Spy->expects()
            ->uninstall()
            ->once();

        $this->platform->shutdown();
    }
}
