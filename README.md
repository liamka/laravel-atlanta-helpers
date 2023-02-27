# Helpers

This is a helpers package that provides some built in helpers, and also provides an Artisan generator to quickly create your own custom helpers.

## Install

Via Composer

``` bash
$ composer require atlanta/helpers
```

## Setup

Add the service provider to the providers array in `config/app.php`.

``` php
'providers' => [
    Atlanta\Helpers\HelperServiceProvider::class,
];
```

If you are using Laravel's automatic package discovery, you can skip this step.

## Publishing

You can publish everything at once

``` php
php artisan vendor:publish --provider="Atlanta\Helpers\HelperServiceProvider"
```

or you can publish groups individually.

``` php
php artisan vendor:publish --provider="Atlanta\Helpers\HelperServiceProvider" --tag="config"
```

## Usage

This package comes with some built in helpers that you can choose to use or not. By default all of these helpers are inactive for your application. To adjust which helpers are active and which are inactive, open `config/helpers.php` and find the `package_helpers` option. Add any helpers you wish to activate to this key. Check the source code to see what functions are included in each helper and what each does.

You can also create your own custom helpers for inclusion in your application. An Artisan generator helps you quickly make new helpers for your application. 

``` sh
php artisan make:helper MyHelper
```

Your custom helper will be placed in `app/Helpers`, unless you override the default directory in your configuration.

By default, the service provider uses the `glob` function to automatically require any PHP files in the 'Helpers' directory. If you prefer a mapper based approach, you may edit the `custom_helpers` in the configuration file, and include the file name of any helpers in your custom directory you wish to activate. Within the new helper, define your own custom functions that will be available throughout your application.

``` php
if (!function_exists('hello')) {

    /**
     * say hello
     *
     * @param string $name
     * @return string
     */
    function hello($name)
    {
        return 'Hello ' . $name . '!';
    }
}
```
