![Cover image](/cover.png)
# Cloudflare Turnstile for Laravel 8+

[![Latest Version on Packagist](https://img.shields.io/packagist/v/njoguamos/laravel-turnstile.svg?style=flat-square)](https://packagist.org/packages/njoguamos/laravel-turnstile)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/njoguamos/laravel-turnstile/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/njoguamos/laravel-turnstile/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/njoguamos/laravel-turnstile/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/njoguamos/laravel-turnstile/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/njoguamos/laravel-turnstile.svg?style=flat-square)](https://packagist.org/packages/njoguamos/laravel-turnstile)

[Turnstile](https://developers.cloudflare.com/turnstile/) is a new user friendly, privacy preserving alternative to CAPTCHA. This package provides a flexible way of integrating turnstile into your Laravel application. This package can be turned on and off for your convenience.  

## Installation

You can install the package via composer:

```bash
composer require njoguamos/laravel-turnstile
```

You can initialise the package with:

```bash
php artisan turnstile:install
```

The install command will publish the [config file](/config/turnstile.php).

Ensure that you have update your application `.env` with credentials from [cloudflare](https://developers.cloudflare.com/turnstile/get-started/) i.e.

```dotenv
#.env file

TURNSTILE_SECRET_KEY=
TURNSTILE_SITE_KEY=
```

## Usage
There are two way to use this package.

### 1. As a middleware
To use turnstile is specific routes of your application, you can register a new middleware in your laravel `app/Http/Kernel.php`. 

````php
class Kernel extends HttpKernel {
    // other class code
    
    protected $routeMiddleware = [
    // Other middlewares
        'turnstile' => \NjoguAmos\Turnstile\Http\Middleware\TurnstileMiddleware::class
    ];
}
````

Once the middleware has been defined in the HTTP kernel, you may use the middleware method to assign middleware to a route:

```php
Route::get('/register', function () {
    //
})->middleware('turnstile');
```

Ensure your frontend form submit a turnstile token using a name defined in turnstile config file. Your can learn how to implement client side render from [cloudflare website](https://developers.cloudflare.com/turnstile/get-started/client-side-rendering/#implicitly-render-the-turnstile-widget). Example:

```php
<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>

<form action="/register" method="POST">
    ...
    
    <div class="cf-turnstile" data-sitekey="<YOUR_SITE_KEY>"></div> 
 
    ...
</form>
```

Upon submitting the form, the turnstile token will be validated against turnstile api. If it fails, the request will be redirected back with `status` message. You can handle this message however you want in client side.

### 2. As a validation rule
```text
@TODO: Working on it
```

## Testing
>**Info**
> This package does not mock request. It uses the secret keys [provided by Cloudflare](https://developers.cloudflare.com/turnstile/frequently-asked-questions/#are-there-sitekeys-and-secret-keys-that-can-be-used-for-testing). Therefore, test scenarios hits the real turnstile api.

```bash
composer test
```

## Changelog

Please see [releases](https://github.com/njoguamos/laravel-turnstile/releases) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Njogu Amos](https://github.com/njoguamos)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
