# Themes for Laravel

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/petercoles/Themes/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/petercoles/Themes/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/petercoles/Themes/badges/build.png?b=master)](https://scrutinizer-ci.com/g/petercoles/Themes/build-status/master)

## Introduction
This is far from being the only theme management package available for Laravel (see below). Each has its own approach. This one's point of uniqueness is its no-coding approach. Instead you simply install it, set config rules and the package takes care of their interpretation and execution.

## Other Laravel Theme Packages that you might want to consider
+ [teeplus/theme](https://packagist.org/packages/teepluss/theme)
+ [igaster/laravel-theme](https://packagist.org/packages/igaster/laravel-theme)
+ [karlomikus/theme](https://packagist.org/packages/karlomikus/theme)
+ [buzz/laravel-theme](https://packagist.org/packages/buzz/laravel-theme)

## Installation

At the command line run

```
composer require petercoles/themes
```

then add the service provider to the providers entry in your config/app.php file

```
    'providers' => [
        // ...
        PeterColes\Themes\ThemesServiceProvider::class,
        // ...
    ],
```

this will cause the themes middleware to be applied to all routes in the "web" group. If you have defined your own groups you can the middleware to them in your app/Http/Kernal.php file, or apply it to all routes (as below), though this manual registration will rarely be necessary.

```
    protected $middleware = [
        // ...
        \PeterColes\Themes\ThemesMiddleware::class,
    ];
```

## Configuration

Publish the configuration file from the command line with

```
php artisan vendor:publish
```

or if you only want to publish this package

```
php artisan vendor:publish --provider="PeterColes\Themes\ThemesServiceProvider"
```

The resulting themes config file has a single default setting that will leave your site untouched. To start controlling the themes used, see the next section ...

## Usage

By default this package will continue to use your views and assets in their default Laravel locations. To start to over-ride these defaults with context-based alternatives, first create a theme folder at the same level as your Laravel's resource folder. Inside that create a folder for one or more themes.

To be continued ...

## Matches

Supported matches (more to come) are:

+ dates
+ domain
+ environment
+ http_scheme
+ subdomain
+ url_segment

Planned include:

+ country
+ language

To be continued ...