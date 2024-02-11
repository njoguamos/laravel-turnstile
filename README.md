![Cover image](/cover.png)
# Cloudflare Turnstile for Laravel 10+

[![Latest Version on Packagist](https://img.shields.io/packagist/v/njoguamos/laravel-turnstile.svg?style=flat-square)](https://packagist.org/packages/njoguamos/laravel-turnstile)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/njoguamos/laravel-turnstile/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/njoguamos/laravel-turnstile/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/njoguamos/laravel-turnstile/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/njoguamos/laravel-turnstile/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/njoguamos/laravel-turnstile.svg?style=flat-square)](https://packagist.org/packages/njoguamos/laravel-turnstile)

[Turnstile](https://developers.cloudflare.com/turnstile/) is a new user friendly, privacy preserving alternative to CAPTCHA. This package provides a flexible way of integrating turnstile into your Laravel application. This package can be turned on and off for your convenience.

>**Info**
> This package focuses on server side validation. You are free to implement your preferable client side technology such vue, reach, blade e.t.c

## Version compatibility

| Version | PHP versions     | Laravel versions |
|---------|:-----------------|------------------|
| 1.x.x   | 8.0, 8.1 and 8.2 | 9.x and 10.x     |
| 2.x.x   | 8.1, 8.2 and 8.3 | 10.x             |

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
There are three way to use this package.

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

Ensure your client side technology submit a turnstile token using a name defined in turnstile config file. Your can learn how to implement client side render from [cloudflare website](https://developers.cloudflare.com/turnstile/get-started/client-side-rendering/#implicitly-render-the-turnstile-widget). Example:


Upon submitting the form, the turnstile token will be validated against turnstile api. If it fails, the request will be redirected back with `status` message. You can handle this message however you want in client side.

### 2. As a validation rule (v2.x.x)

You can user the inbuilt validation to validate form input

```php
use NjoguAmos\Turnstile\Rules\TurnstileRule;

class RegisterRequest extends FormRequest
{
    /** @return array<string, array> */
    public function rules(): array
    {
        return [
            # Other fields
            'token'   => ['required', new TurnstileRule() ],
        ];
    }
    
    # Other code
}
```

### 3. Manual
You can validate turnstile token by calling validate method of `Turnstile` facade. The result will be `true` when token passed and `false` when token fails.

```php
use NjoguAmos\Turnstile\Turnstile;

$isValid = (new Turnstile())->validate($token);

// Code is valid or invalid
```

## Disabling
To increase the speed of your unit tests, you may wish to disable the turnstile. You can do so by setting `TURNSTILE_ENABLED` to false. i.e

```dotenv
#.env
TURNSTILE_ENABLED=false
```

When disabled, 
- turnstile middleware will always pass
- turnstile validation rule will always pass

😀 Remember to turn turnstile on when you deploy.

## Testing
>**Info**
> This package does not mock request. It uses the secret keys [provided by Cloudflare](https://developers.cloudflare.com/turnstile/reference/testing/). Therefore, test scenarios hits the real turnstile api.

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
