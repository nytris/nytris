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

use Composer\Autoload\ClassLoader;
use Nytris\Core\Bootstrap\Bootstrap;
use Nytris\Core\Includer\Includer;
use Nytris\Core\Platform\PlatformFactory;

(new Bootstrap(new ReflectionClass(ClassLoader::class), new Includer(), new PlatformFactory()))->bootstrap();
