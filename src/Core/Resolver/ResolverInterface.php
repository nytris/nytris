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

/**
 * Interface ResolverInterface.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface ResolverInterface
{
    /**
     * Resolves the path to the root directory of the project.
     */
    public function resolveProjectRoot(): string;
}
