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

namespace Nytris\Tests\Unit\Core\Package;

use Mockery\MockInterface;
use Nytris\Boot\PlatformConfigInterface;
use Nytris\Core\Package\PackageContext;
use Nytris\Core\Package\PackageContextInterface;
use Nytris\Core\Package\PackageFacadeInterface;
use Nytris\Core\Package\PackageInterface;
use Nytris\Tests\AbstractTestCase;

/**
 * Class PackageContextTest.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class PackageContextTest extends AbstractTestCase
{
    private PackageContext $packageContext;
    /**
     * @var class-string<PackageFacadeInterface>
     */
    private string $packageFacadeFqcn;
    private MockInterface&PlatformConfigInterface $platformConfig;

    public function setUp(): void
    {
        $this->platformConfig = mock(PlatformConfigInterface::class, [
            'getBaseCachePath' => '/path/to/my_cache',
        ]);
        $this->packageFacadeFqcn = get_class(new class implements PackageFacadeInterface {
            private static bool $installed = false;

            public static function getName(): string
            {
                return 'my_package';
            }

            public static function getVendor(): string
            {
                return 'my_vendor';
            }

            public static function install(PackageContextInterface $packageContext, PackageInterface $package): void
            {
                self::$installed = true;
            }

            public static function isInstalled(): bool
            {
                return self::$installed;
            }

            public static function uninstall(): void
            {
                self::$installed = false;
            }
        });

        $this->packageContext = new PackageContext($this->platformConfig, $this->packageFacadeFqcn);
    }

    public function testGetBaseCachePathFetchesPathFromPlatformConfig(): void
    {
        static::assertSame('/path/to/my_cache', $this->packageContext->getBaseCachePath());
    }

    public function testGetPackageCachePathBuildsCorrectPath(): void
    {
        static::assertSame('/path/to/my_cache/my_vendor/my_package', $this->packageContext->getPackageCachePath());
    }
}
