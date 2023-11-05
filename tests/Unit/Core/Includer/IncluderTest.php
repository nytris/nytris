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

namespace Nytris\Tests\Unit\Core\Includer;

use Nytris\Core\Includer\Includer;
use Nytris\Tests\AbstractTestCase;

/**
 * Class IncluderTest.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class IncluderTest extends AbstractTestCase
{
    private Includer $includer;

    public function setUp(): void
    {
        $this->includer = new Includer();
    }

    public function testIsolatedIncludeReturnsModuleResult(): void
    {
        $path = dirname(__DIR__, 2) . '/Fixtures/compactor.php';

        $result = $this->includer->isolatedInclude($path);

        static::assertEquals(
            [
                'my_vars' => [
                    // The only variable visible should be the isolated includer's $path parameter.
                    'path' => $path,
                ],
            ],
            $result
        );
    }
}
