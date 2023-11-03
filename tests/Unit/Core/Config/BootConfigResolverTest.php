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

use Composer\Autoload\ClassLoader;
use LogicException;
use Mockery\MockInterface;
use Nytris\Boot\BootConfigInterface;
use Nytris\Core\Config\BootConfigResolver;
use Nytris\Core\Includer\IncluderInterface;
use Nytris\Tests\AbstractTestCase;
use ReflectionClass;
use stdClass;

/**
 * Class BootConfigResolverTest.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class BootConfigResolverTest extends AbstractTestCase
{
    private MockInterface&BootConfigInterface $bootConfig;
    /**
     * @var MockInterface&ReflectionClass<ClassLoader>
     */
    private MockInterface&ReflectionClass $classLoaderReflectionClass;
    private string $fixturesPath;
    private MockInterface&IncluderInterface $includer;
    private BootConfigResolver $resolver;

    public function setUp(): void
    {
        $this->bootConfig = mock(BootConfigInterface::class);
        $this->fixturesPath = dirname(__DIR__, 2) . '/Fixtures';
        $this->classLoaderReflectionClass = mock(ReflectionClass::class, [
            'getFileName' => $this->fixturesPath . '/BootConfig/vendor/composer/ClassLoader.php',
        ]);
        $this->includer = mock(IncluderInterface::class, [
            'isolatedInclude' => $this->bootConfig,
        ]);

        $this->resolver = new BootConfigResolver(
            $this->classLoaderReflectionClass,
            $this->includer,
            'my.config.php'
        );
    }

    public function testResolveBootConfigReturnsResolvedBootConfigWhenPresent(): void
    {
        static::assertSame($this->bootConfig, $this->resolver->resolveBootConfig());
    }

    public function testResolveBootConfigReturnsNullWhenConfigFileNotPresent(): void
    {
        $this->classLoaderReflectionClass->allows()
            ->getFileName()
            ->andReturn(
                dirname(__DIR__, 2) . '/Fixtures/BootConfig/not_present/vendor/composer/ClassLoader.php'
            );

        static::assertNull($this->resolver->resolveBootConfig());
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

        $this->resolver->resolveBootConfig();
    }
}
