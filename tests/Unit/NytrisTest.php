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

namespace Nytris\Tests\Unit;

use LogicException;
use Mockery;
use Mockery\MockInterface;
use Nytris\Boot\BootConfigInterface;
use Nytris\Core\Bootstrap\BootstrapInterface;
use Nytris\Core\Config\BootConfigResolverInterface;
use Nytris\Core\Platform\PlatformInterface;
use Nytris\Nytris;
use Nytris\Tests\AbstractTestCase;

/**
 * Class NytrisTest.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class NytrisTest extends AbstractTestCase
{
    private MockInterface&BootConfigInterface $bootConfig;
    private MockInterface&BootConfigResolverInterface $bootConfigResolver;
    private MockInterface&BootstrapInterface $bootstrap;
    private MockInterface&PlatformInterface $platform;

    public function setUp(): void
    {
        $this->bootConfig = mock(BootConfigInterface::class);
        $this->bootConfigResolver = mock(BootConfigResolverInterface::class, [
            'resolveBootConfig' => $this->bootConfig,
        ]);
        $this->platform = mock(PlatformInterface::class, [
            'shutdown' => null,
        ]);
        $this->bootstrap = mock(BootstrapInterface::class, [
            'boot' => $this->platform,
        ]);

        // Undo the automatic initialisation of this library for this test.
        Nytris::uninitialise();
    }

    public function tearDown(): void
    {
        Nytris::uninitialise();
    }

    public function testBootThrowsWhenNytrisHasNotYetBeenInitialised(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Nytris platform has not yet been initialised');

        Nytris::boot($this->bootConfig);
    }

    public function testBootThrowsWhenNytrisHasAlreadyBeenBooted(): void
    {
        Nytris::initialise($this->bootstrap, $this->bootConfigResolver);

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Nytris platform has already been booted');

        Nytris::boot($this->bootConfig);
        Nytris::boot(mock(BootConfigInterface::class));
    }

    public function testGetPlatformRaisesExceptionWhenNoPlatformHasYetBeenBooted(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('No Nytris platform has yet been booted');

        Nytris::getPlatform();
    }

    public function testHasBootedInitiallyReturnsFalse(): void
    {
        static::assertFalse(Nytris::hasBooted());
    }

    public function testInitialiseResolvesBootConfigViaResolver(): void
    {
        $this->bootConfigResolver->expects()
            ->resolveBootConfig()
            ->once()
            ->andReturn($this->bootConfig);

        Nytris::initialise($this->bootstrap, $this->bootConfigResolver);
    }

    public function testInitialiseBootsViaBootstrapWhenBootConfigIsResolved(): void
    {
        $this->bootstrap->expects()
            ->boot($this->bootConfig)
            ->once()
            ->andReturn($this->platform);

        Nytris::initialise($this->bootstrap, $this->bootConfigResolver);
    }

    public function testInitialiseStoresPlatformGloballyWhenBootConfigIsResolved(): void
    {
        Nytris::initialise($this->bootstrap, $this->bootConfigResolver);

        static::assertSame($this->platform, Nytris::getPlatform());
    }

    public function testInitialiseDoesNotBootWhenNoBootConfigIsResolved(): void
    {
        $this->bootConfigResolver->allows()
            ->resolveBootConfig()
            ->andReturnNull();

        $this->bootstrap->expects()
            ->boot(Mockery::any())
            ->never();

        Nytris::initialise($this->bootstrap, $this->bootConfigResolver);

        static::assertFalse(Nytris::hasBooted());
    }
}
