Exception reporter for open-admin
======================

This tool stores the exception information into the database and provides a developer-friendly web interface to view the exception information.

[![StyleCI](https://styleci.io/repos/97900053/shield?branch=master)](https://styleci.io/repos/97900053)
[![Packagist](https://img.shields.io/packagist/l/open-admin-ext/reporter.svg?maxAge=2592000)](https://packagist.org/packages/open-admin-ext/reporter)
[![Total Downloads](https://img.shields.io/packagist/dt/open-admin-ext/reporter.svg?style=flat-square)](https://packagist.org/packages/open-admin-ext/reporter)
[![Pull request welcome](https://img.shields.io/badge/pr-welcome-green.svg?style=flat-square)]()

## Screenshot

![open-admin_exceptions](https://user-images.githubusercontent.com/1479100/30947042-0f667d9a-a43a-11e7-99c3-cf0fe236fedd.png)

## Installation

```
$ composer require open-admin-ext/reporter -vvv

$ php artisan vendor:publish --tag=open-admin-reporter

$ php artisan migrate --path=vendor/open-admin-ext/reporter/database/migrations

$ php artisan admin:import reporter
```

Open `app/Exceptions/Handler.php`, call `Reporter::report()` inside `report` method:
```php
<?php

namespace App\Exceptions;

use OpenAdmin\Admin\Reporter\Reporter;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    ...

    public function report(Exception $exception)
    {
        if ($this->shouldReport($exception)) {
            Reporter::report($exception);
        }

//        parent::report($exception);
    }

    ...

}
```

Open `http://localhost/admin/exceptions` to view exceptions.

License
------------
Licensed under [The MIT License (MIT)](LICENSE).
