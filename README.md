Exception reporter for Open-Admin
=================================

This tool stores the exception information into the database and provides a developer-friendly web interface to view the exception information.

[![StyleCI](https://styleci.io/repos/508366116/shield?branch=main)](https://styleci.io/repos/508366116)
[![Packagist](https://img.shields.io/github/license/open-admin-org/reporter.svg?maxAge=2592000&style=flat-square&color=brightgreen)](https://packagist.org/packages/open-admin-ext/reporter)
[![Total Downloads](https://img.shields.io/packagist/dt/open-admin-ext/reporter.svg?style=flat-square&color=brightgreen)](https://packagist.org/packages/open-admin-admin-ext/reporter)
[![Pull request welcome](https://img.shields.io/badge/pr-welcome-green.svg?style=flat-square&color=brightgreen)]()

## Screenshot

![open-admin-reporter](https://user-images.githubusercontent.com/86517067/176226958-b3ed0a1c-7b87-4e43-a2fd-f487f110d9f5.png)


## Installation

```
$ composer require open-admin-ext/reporter

$ php artisan vendor:publish --tag=open-admin-reporter

$ php artisan migrate --path=vendor/open-admin-ext/reporter/database/migrations

$ php artisan admin:import reporter
```

Open `app/Exceptions/Handler.php`,
1) Add: `use OpenAdmin\Admin\Reporter\Reporter;`
2) Call `Reporter::report()` inside `register` ... `reportable` method:
```php
<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use OpenAdmin\Admin\Reporter\Reporter;
use Throwable;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            // Add This line
            Reporter::report($e);
        });
    }
}

```

Open `http://localhost/admin/exceptions` to view exceptions.

License
------------
Licensed under [The MIT License (MIT)](LICENSE).
