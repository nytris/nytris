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

namespace Nytris\Boot;

/**
 * Class PlatformConfig.
 *
 * Provides the base configuration for the Nytris platform.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class PlatformConfig implements PlatformConfigInterface
{
    public function __construct(
        private readonly string $baseCachePath
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getBaseCachePath(): string
    {
        return $this->baseCachePath;
    }
}
