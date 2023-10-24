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

namespace Nytris\Core\Bootstrap;

use Composer\Autoload\ClassLoader;
use LogicException;
use Nytris\Boot\BootConfigInterface;
use Nytris\Core\Includer\IncluderInterface;
use Nytris\Core\Platform\PlatformFactoryInterface;
use Nytris\Nytris;
use ReflectionClass;

/**
 * Class Bootstrap.
 *
 * Bootstraps the Nytris platform.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * @param ReflectionClass<ClassLoader> $classLoaderReflectionClass
     * @param IncluderInterface $includer
     * @param PlatformFactoryInterface $platformFactory
     * @param string $configFileName
     */
    public function __construct(
        private readonly ReflectionClass $classLoaderReflectionClass,
        private readonly IncluderInterface $includer,
        private readonly PlatformFactoryInterface $platformFactory,
        private readonly string $configFileName = 'nytris.config.php'
    ) {
    }

    /**
     * @inheritDoc
     */
    public function bootstrap(): void
    {
        $projectRoot = dirname($this->classLoaderReflectionClass->getFileName(), 3);

        $configPath = $projectRoot . '/' . $this->configFileName;

        // Use a suppressed include rather than is_file(...) etc. to avoid disk hits when opcache can serve.
        $bootConfig = $this->includer->suppressedIsolatedInclude($configPath);

        if ($bootConfig === false) {
            // Nytris boot config isn't present: nothing to do.
            return;
        }

        if (!($bootConfig instanceof BootConfigInterface)) {
            throw new LogicException(
                sprintf(
                    'Return value of module %s is expected to be an instance of %s but was not',
                    $configPath,
                    BootConfigInterface::class
                )
            );
        }

        $platform = $this->platformFactory->createPlatform($bootConfig);

        // Store the platform globally.
        Nytris::setPlatform($platform);

        $platform->boot();
    }
}
