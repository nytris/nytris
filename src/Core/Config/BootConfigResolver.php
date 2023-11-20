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

use LogicException;
use Nytris\Boot\BootConfigInterface;
use Nytris\Core\Includer\IncluderInterface;
use Nytris\Core\Resolver\ResolverInterface;

/**
 * Class BootConfigResolver.
 *
 * Resolves the boot config from nytris.config.php, if present.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class BootConfigResolver implements BootConfigResolverInterface
{
    public function __construct(
        private readonly ResolverInterface $resolver,
        private readonly IncluderInterface $includer,
        private readonly string $configFileName = 'nytris.config.php'
    ) {
    }

    /**
     * @inheritDoc
     */
    public function resolveBootConfig(): ?BootConfigInterface
    {
        $configPath = $this->resolver->resolveProjectRoot() . DIRECTORY_SEPARATOR . $this->configFileName;

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
