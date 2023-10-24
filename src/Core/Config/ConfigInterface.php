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

/**
 * Interface ConfigInterface.
 *
 * Provides the common configuration shared between Nytris packages.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface ConfigInterface
{
    /**
     * Fetches the base cache path.
     */
    public function getBaseCachePath(): string;
}
