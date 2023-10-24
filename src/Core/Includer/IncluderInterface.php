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

namespace Nytris\Core\Includer;

/**
 * Interface IncluderInterface.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface IncluderInterface
{
    /**
     * Includes a PHP module with errors suppressed.
     */
    public function suppressedIsolatedInclude(string $path): mixed;
}
