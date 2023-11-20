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

namespace Nytris\Core\Resolver;

use Composer\Autoload\ClassLoader;
use ReflectionClass;

/**
 * Class Resolver.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class Resolver implements ResolverInterface
{
    /**
     * @param ReflectionClass<ClassLoader> $classLoaderReflectionClass
     */
    public function __construct(
        private readonly ReflectionClass $classLoaderReflectionClass
    ) {
    }

    /**
     * @inheritDoc
     */
    public function resolveProjectRoot(): string
    {
        return dirname($this->classLoaderReflectionClass->getFileName(), 3);
    }
}
