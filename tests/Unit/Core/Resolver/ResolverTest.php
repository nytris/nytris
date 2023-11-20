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

namespace Nytris\Tests\Unit\Core\Resolver;

use Composer\Autoload\ClassLoader;
use Mockery\MockInterface;
use Nytris\Core\Resolver\Resolver;
use Nytris\Tests\AbstractTestCase;
use ReflectionClass;

/**
 * Class ResolverTest.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class ResolverTest extends AbstractTestCase
{
    /**
     * @var MockInterface&ReflectionClass<ClassLoader>
     */
    private MockInterface&ReflectionClass $classLoaderReflectionClass;
    private string $fixturesPath;
    private Resolver $resolver;

    public function setUp(): void
    {
        $this->fixturesPath = dirname(__DIR__, 2) . '/Fixtures';
        $this->classLoaderReflectionClass = mock(ReflectionClass::class, [
            'getFileName' => $this->fixturesPath . '/BootConfig/vendor/composer/ClassLoader.php',
        ]);

        $this->resolver = new Resolver($this->classLoaderReflectionClass);
    }

    public function testResolveProjectRootReturnsRootPath(): void
    {
        static::assertSame($this->fixturesPath . '/BootConfig', $this->resolver->resolveProjectRoot());
    }
}
