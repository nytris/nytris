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

namespace Nytris\Tests\Unit\Core\Bootstrap;

use Composer\Autoload\ClassLoader;
use LogicException;
use Mockery\MockInterface;
use Nytris\Boot\BootConfigInterface;
use Nytris\Core\Bootstrap\Bootstrap;
use Nytris\Core\Includer\IncluderInterface;
use Nytris\Core\Platform\PlatformFactoryInterface;
use Nytris\Core\Platform\PlatformInterface;
use Nytris\Nytris;
use Nytris\Tests\AbstractTestCase;
use ReflectionClass;
use stdClass;

/**
 * Class BootstrapTest.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class BootstrapTest extends AbstractTestCase
{
    private MockInterface&BootConfigInterface $bootConfig;
    private Bootstrap $bootstrap;
    /**
     * @var MockInterface&ReflectionClass<ClassLoader>
     */
    private MockInterface&ReflectionClass $classLoaderReflectionClass;
    private MockInterface&IncluderInterface $includer;
    private MockInterface&PlatformInterface $platform;
    private MockInterface&PlatformFactoryInterface $platformFactory;

    public function setUp(): void
    {
        Nytris::setPlatform(null);

        $this->bootConfig = mock(BootConfigInterface::class);
        $this->classLoaderReflectionClass = mock(ReflectionClass::class, [
            'getFileName' => '/my/path/to/vendor/composer/ClassLoader.php',
        ]);
        $this->includer = mock(IncluderInterface::class, [
            'suppressedIsolatedInclude' => $this->bootConfig,
        ]);
        $this->platform = mock(PlatformInterface::class, [
            'boot' => null,
        ]);
        $this->platformFactory = mock(PlatformFactoryInterface::class, [
            'createPlatform' => $this->platform,
        ]);

        $this->bootstrap = new Bootstrap(
            $this->classLoaderReflectionClass,
            $this->includer,
            $this->platformFactory,
            'my.config.php'
        );
    }

    public function tearDown(): void
    {
        Nytris::setPlatform(null);
    }

    public function testBootstrapBootsNytrisPlatform(): void
    {
        $this->platform->expects()
            ->boot()
            ->once();

        $this->bootstrap->bootstrap();
    }

    public function testBootstrapStoresNytrisPlatformInstance(): void
    {
        $this->bootstrap->bootstrap();

        static::assertSame($this->platform, Nytris::getPlatform());
    }

    public function testBootstrapRaisesExceptionWhenConfigModuleReturnValueIsInvalid(): void
    {
        $this->includer->allows()
            ->suppressedIsolatedInclude('/my/path/to/my.config.php')
            ->andReturn(new stdClass);

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Return value of module /my/path/to/my.config.php is expected to be an instance of %s but was not',
                BootConfigInterface::class
            )
        );

        $this->bootstrap->bootstrap();
    }
}
