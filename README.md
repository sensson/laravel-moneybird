# Moneybird

[![Latest Version on Packagist](https://img.shields.io/packagist/v/sensson/laravel-moneybird.svg?style=flat-square)](https://packagist.org/packages/sensson/laravel-moneybird)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/sensson/laravel-moneybird/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/sensson/laravel-moneybird/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/sensson/laravel-moneybird/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/sensson/laravel-moneybird/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/sensson/laravel-moneybird.svg?style=flat-square)](https://packagist.org/packages/sensson/laravel-moneybird)

This package allows you to connect your Laravel application to the accounting
software by Moneybird.

## Installation

You can install the package via composer:

```bash
composer require sensson/laravel-moneybird
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-moneybird-config"
```

## Usage

```php
\Sensson\Moneybird\Facades\Moneybird::administration('id')->contacts()->all();
```

### Authentication / OAuth2

You can use OAuth2 to authorize your application with Moneybird.

```php
$moneybird = \Sensson\Moneybird\Facades\Moneybird::auth();
$url = $moneybird->getAuthorizationUrl();

session()->put('moneybird.state', $moneybird->getState());

return redirect()->to($url);
```

And retrieve the callback from Moneybird:

```php
$code = $request->string('code');
$state = $request->string('state');
$expected = session()->pull('moneybird.state');

$moneybird = \Sensson\Moneybird\Facades\Moneybird::auth();
$authorization = $moneybird->getAccessToken($code, $state, $expected);
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Sensson](https://github.com/sensson)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
