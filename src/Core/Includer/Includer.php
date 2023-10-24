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

use Closure;

/**
 * Class Includer.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class Includer implements IncluderInterface
{
    /**
     * @var callable
     */
    private $include;

    public function __construct()
    {
        $this->include = Closure::bind(static fn ($path) => @include $path, null, null);
    }

    /**
     * @inheritDoc
     */
    public function suppressedIsolatedInclude(string $path): mixed
    {
        // Use a suppressed include rather than is_file(...) etc. to avoid disk hits when opcache can serve.
        return ($this->include)($path);
    }
}
