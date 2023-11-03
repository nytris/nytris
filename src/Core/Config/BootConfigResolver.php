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

namespace Nytris\Core\Config;

use Composer\Autoload\ClassLoader;
use LogicException;
use Nytris\Boot\BootConfigInterface;
use Nytris\Core\Includer\IncluderInterface;
use ReflectionClass;

/**
 * Class BootConfigResolver.
 *
 * Resolves the boot config from nytris.config.php, if present.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class BootConfigResolver implements BootConfigResolverInterface
{
    /**
     * @param ReflectionClass<ClassLoader> $classLoaderReflectionClass
     * @param IncluderInterface $includer
     * @param string $configFileName
     */
    public function __construct(
        private readonly ReflectionClass $classLoaderReflectionClass,
        private readonly IncluderInterface $includer,
        private readonly string $configFileName = 'nytris.config.php'
    ) {
    }

    /**
     * @inheritDoc
     */
    public function resolveBootConfig(): ?BootConfigInterface
    {
        $projectRoot = dirname($this->classLoaderReflectionClass->getFileName(), 3);

        $configPath = $projectRoot . '/' . $this->configFileName;

        if (!is_file($configPath)) {
            // Nytris boot config isn't present: nothing to do.
            return null;
        }

        $bootConfig = $this->includer->isolatedInclude($configPath);

        if (!($bootConfig instanceof BootConfigInterface)) {
            throw new LogicException(
                sprintf(
                    'Return value of module %s is expected to be an instance of %s but was not',
                    $configPath,
                    BootConfigInterface::class
                )
            );
        }

        return $bootConfig;
    }
}
