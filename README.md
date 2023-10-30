# Nytris

[![Build Status](https://github.com/nytris/nytris/workflows/CI/badge.svg)](https://github.com/nytris/nytris/actions?query=workflow%3ACI)

Bootstrap library for Nytris.

## Usage
You won't usually need to install this package directly with Composer,
as it will be required by whichever Nytris packages you are using, but if so:

```shell
$ composer install nytris/nytris
```

### Configuring platform boot config

`nytris.config.php`

```php
<?php

declare(strict_types=1);

use Nytris\Boot\BootConfig;
use Nytris\Boot\PlatformConfig;

$bootConfig = new BootConfig(new PlatformConfig(__DIR__ . '/var/cache/nytris/'));

$bootConfig->installPackage(new MyNytrisPackage([...]));

return $bootConfig;
```
