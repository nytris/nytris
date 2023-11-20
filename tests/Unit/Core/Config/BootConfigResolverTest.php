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

namespace Nytris\Tests\Unit\Core\Config;

use LogicException;
use Mockery\MockInterface;
use Nytris\Boot\BootConfigInterface;
use Nytris\Core\Config\BootConfigResolver;
use Nytris\Core\Includer\IncluderInterface;
use Nytris\Core\Resolver\ResolverInterface;
use Nytris\Tests\AbstractTestCase;
use stdClass;

/**
 * Class BootConfigResolverTest.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class BootConfigResolverTest extends AbstractTestCase
{
    private MockInterface&BootConfigInterface $bootConfig;
    private BootConfigResolver $bootConfigResolver;
    private string $fixturesPath;
    private MockInterface&IncluderInterface $includer;
    private MockInterface&ResolverInterface $resolver;

    public function setUp(): void
    {
        $this->bootConfig = mock(BootConfigInterface::class);
        $this->fixturesPath = dirname(__DIR__, 2) . '/Fixtures';
        $this->includer = mock(IncluderInterface::class, [
            'isolatedInclude' => $this->bootConfig,
        ]);
        $this->resolver = mock(ResolverInterface::class, [
            'resolveProjectRoot' => $this->fixturesPath . '/BootConfig',
        ]);

        $this->bootConfigResolver = new BootConfigResolver(
            $this->resolver,
            $this->includer,
            'my.config.php'
        );
    }

    public function testResolveBootConfigReturnsResolvedBootConfigWhenPresent(): void
    {
        static::assertSame($this->bootConfig, $this->bootConfigResolver->resolveBootConfig());
    }

    public function testResolveBootConfigReturnsNullWhenConfigFileNotPresent(): void
    {
        $this->resolver->allows()
            ->resolveProjectRoot()
            ->andReturn(
                dirname(__DIR__, 2) . '/Fixtures/BootConfig/not_present'
            );

        static::assertNull($this->bootConfigResolver->resolveBootConfig());
    }

    public function testResolveBootConfigRaisesExceptionWhenConfigModuleReturnValueIsInvalid(): void
    {
        $configFilePath = $this->fixturesPath . '/BootConfig/my.config.php';
        $this->includer->allows()
            ->isolatedInclude($configFilePath)
            ->andReturn(new stdClass);

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Return value of module %s is expected to be an instance of %s but was not',
                $configFilePath,
                BootConfigInterface::class
            )
        );

        $this->bootConfigResolver->resolveBootConfig();
    }
}
