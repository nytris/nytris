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

use Mockery\MockInterface;
use Nytris\Boot\BootConfigInterface;
use Nytris\Core\Bootstrap\Bootstrap;
use Nytris\Core\Platform\PlatformFactoryInterface;
use Nytris\Core\Platform\PlatformInterface;
use Nytris\Tests\AbstractTestCase;

/**
 * Class BootstrapTest.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class BootstrapTest extends AbstractTestCase
{
    private MockInterface&BootConfigInterface $bootConfig;
    private Bootstrap $bootstrap;
    private MockInterface&PlatformInterface $platform;
    private MockInterface&PlatformFactoryInterface $platformFactory;

    public function setUp(): void
    {
        $this->bootConfig = mock(BootConfigInterface::class);
        $this->platform = mock(PlatformInterface::class, [
            'boot' => null,
        ]);
        $this->platformFactory = mock(PlatformFactoryInterface::class);

        $this->platformFactory->allows()
            ->createPlatform($this->bootConfig)
            ->andReturn($this->platform)
            ->byDefault();

        $this->bootstrap = new Bootstrap($this->platformFactory);
    }

    public function testBootBootsNytrisPlatform(): void
    {
        $this->platform->expects()
            ->boot()
            ->once();

        $this->bootstrap->boot($this->bootConfig);
    }

    public function testBootReturnsNytrisPlatformInstance(): void
    {
        static::assertSame($this->platform, $this->bootstrap->boot($this->bootConfig));
    }
}
