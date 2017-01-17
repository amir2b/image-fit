# image-fit for Laravel 5
Laravel image fit


## Installation

The Image-Fit Service Provider can be installed via [Composer](http://getcomposer.org) by requiring the
`amir2b/image-fit` package and setting the `minimum-stability` to `dev` (required for Laravel 5) in your
project's `composer.json`.

```json
{
    "require": {
        "laravel/framework": "5.0.*",
        "amir2b/image-fit": "dev-master"
    },
    "minimum-stability": "dev"
}
```

or

Require this package with composer:

$```composer require amir2b/image-fit:dev-master```

Update your packages with ```composer update``` or install with ```composer install```.

## Usage

To use the Captcha Service Provider, you must register the provider when bootstrapping your Laravel application. There are
essentially two ways to do this.

Find the `providers` key in `config/app.php` and register the Captcha Service Provider.

for Laravel 5.1+
```php
    'providers' => [
        // ...
        Amir2b\ImageFit\ImageFitServiceProvider::class,
    ]
```
for Laravel 5.0
```php
    'providers' => [
        // ...
        'Amir2b\ImageFit\ImageFitServiceProvider',
    ]
```
