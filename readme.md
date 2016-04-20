# Themes for Laravel

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/petercoles/Themes/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/petercoles/Themes/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/petercoles/Themes/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/petercoles/Themes/?branch=master)
[![Build Status](https://travis-ci.org/petercoles/Themes.svg?branch=master)](https://travis-ci.org/petercoles/Themes)
[![License](http://img.shields.io/:license-mit-blue.svg)](http://doge.mit-license.org)

## Introduction
This is far from being the only theme management package available for Laravel (see below). Each has its own approach. This one's point of uniqueness is its no-coding approach. Instead you simply install it, set config rules and the package uses those rules to determine which theme to use.

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

## Creating Your Themes

By default this package will continue to use your views and assets in their default Laravel locations. To start to over-ride these defaults with context-based alternatives, first create a theme folder at the same level as your Laravel's resource folder. Inside that create a folder for one or more themes.

For example:
```
.
|-- app
|-- ...
|-- resources
|-- storage
|-- themes
    |-- myFirstTheme
    |-- mySecondTheme
|--vendor
```
Within each theme place your config, asset and views files. For example:
```
.
|-- themes
    |-- myFirstTheme
        |-- config
        |-- assets
            |-- img
            |-- js
            |-- sass
        |-- views
```

### Configs

Config files will be detected and loaded automatically. They will _completely replace_ any files with the same name in the normal config folder, rather than overriding individual settings.

### Assets

There is no automatic management of assets. Elixir is recommended, but any similar build system can be used to process, prepare and place them in you site's public folder. To avoid collisions, it's recommended that you place them in subfolders with the same name as the theme's folder, for example:
```
.
|-- public
    |-- myFirstTheme
        |-- img
        |-- js
        |-- sass
```
If you do so, then the theme_assets() and secure_theme_assets() helper functions are available for inserting links to the assets into view. For example the following will autodetect which theme is in use and point to the appropriate scripts file:
```
theme_assets('app.js') // will generate "http://www.example.com/theme-name/app.js" 
```

### Views

Views are detected automatically. If your route, your controller or another view calls for a view and it's present in your theme, that's the version that will be used, otherwise it will look for the view in the normal views hierarchy, and if it doesn't find it there either, the normal exception will be thrown.

### ... one more thing

There's also a helper, ```themes_path()``` to build the file path to the themes folder and, like other path helpers in Laravel will prepend that path to any received as a string parameter.

## Setting Rules for Theme Selection

To control the selection of themes, rules are added to the themes config file. The package will process each set of rules in turn and if a match is found will set the themes to the given value.

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
