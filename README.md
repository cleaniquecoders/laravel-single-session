
[![Build Status](https://travis-ci.org/cleaniquecoders/laravel-single-session.svg?branch=master)](https://travis-ci.org/cleaniquecoders/laravel-single-session) [![Latest Stable Version](https://poser.pugx.org/cleaniquecoders/laravel-single-session/v/stable)](https://packagist.org/packages/cleaniquecoders/laravel-single-session) [![Total Downloads](https://poser.pugx.org/cleaniquecoders/laravel-single-session/downloads)](https://packagist.org/packages/cleaniquecoders/laravel-single-session) [![License](https://poser.pugx.org/cleaniquecoders/laravel-single-session/license)](https://packagist.org/packages/cleaniquecoders/laravel-single-session)

## About Your Package

This package let only single user logged in at one time. If user try to login from multiple devices / browsers, it will prevent the user login from other sources.

## Installation

1. In order to install `cleaniquecoders/laravel-single-session` in your Laravel project, just run the *composer require* command from your terminal:

```
$ composer require cleaniquecoders/laravel-single-session
```

2. Then in your `config/app.php` add the following to the providers array:

```php
CleaniqueCoders\LaravelSingleSession\LaravelSingleSessionServiceProvider::class,
```

3. In the same `config/app.php` add the following to the aliases array:

```php
'LaravelSingleSession' => CleaniqueCoders\LaravelSingleSession\LaravelSingleSessionFacade::class,
```

4. Publish assets and configuration:

```
$ php artisan vendor:publish --provider=CleaniqueCoders\LaravelSingleSession\LaravelSingleSessionServiceProvider
```

5. Add the following in your `app/Exception/Handler.php` on `render` method:

```php

use CleaniqueCoders\LaravelSingleSession\Exceptions\SingleSessionException;
...
public function render($request, Exception $exception)
{
	if ($exception instanceof SingleSessionException) {
	    return response()->view('single-session::errors.single-session', [], 401);
	}
...
```

## Usage

By default Laravel Single Session is disabled. You can turn it on in `.env`:

```
SINGLE_SESSION_ENABLED=true
```

By default, Laravel Single Session use `email` field from login form. You may overwrite it in `config/single-session.php`, key `credential`.

## Test

Run the following command:

```
$ vendor/bin/phpunit  --testdox --verbose
```

## Contributing

Thank you for considering contributing to the `cleaniquecoders/laravel-single-session`!

### Bug Reports

To encourage active collaboration, it is strongly encourages pull requests, not just bug reports. "Bug reports" may also be sent in the form of a pull request containing a failing test.

However, if you file a bug report, your issue should contain a title and a clear description of the issue. You should also include as much relevant information as possible and a code sample that demonstrates the issue. The goal of a bug report is to make it easy for yourself - and others - to replicate the bug and develop a fix.

Remember, bug reports are created in the hope that others with the same problem will be able to collaborate with you on solving it. Do not expect that the bug report will automatically see any activity or that others will jump to fix it. Creating a bug report serves to help yourself and others start on the path of fixing the problem.

## Coding Style

`cleaniquecoders/laravel-single-session` follows the PSR-2 coding standard and the PSR-4 autoloading standard. 

You may use PHP CS Fixer in order to keep things standardised. PHP CS Fixer configuration can be found in `.php_cs`.

## License

This package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).