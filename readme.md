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

Views are detected automatically. If your route, your controller or another view calls for a view that is present in your theme, that's the version that will be used, otherwise it will look for the view in the normal views hierarchy, and if it doesn't find it there either, the normal exception will be thrown. So if the current theme is "foo" then ```view('pages.about')``` will look first for ```themes/foo/views/pages/about.blade.php``` and if not found then for ```resources/views/pages/about.blade.php```.

### ... one more thing

There's also a helper, ```themes_path()``` to build the file path to the themes folder and, like other path helpers in Laravel will prepend that path to any received as a string parameter.

## Setting Rules for Theme Selection

To control the selection of themes, you can rules to the themes config file. These rules follw the same syntax as Laravel's validation rules. The package will process each set of rules in turn and if a match is found will set the themes to the given value. For example the themes config:

```
<?php
return [
    [
        'match' => 'subdomain:admin',
        'theme' => 'adminV1'
    ],
    [
        'theme' => 'siteV2'
    ]

];

```
will cause any route that has a subdomain of "admin" to use the template also named "adminV1". All other routes will use the template "siteV2".

It is also possible, even normal, to use several criteria in a single match status, with each separated by a pipe ("|"). For example:
```
[
    'match' => 'domain:www.client.com|dates:2016-02-14',
    'theme' => 'valentines'
],
``` 

The matcher works from the top of the config file and the first set where all the match criteria are met is the winning theme.

If no match criteria are provided for a theme, that is treated as a successful match (see the default in the last but one example).

Whitespace is automatically stripped from match statements, so feel free to lay them out however, you like ...
```
[
    'match' => '
        domain: www.anotherclient.com |
        dates: 2016-12-14, 2016-12-26
    ',
    'theme' => 'xmas'
],
```

Currently supported matchers are:

#### dates

The rule must receive at least one date and match the server time against that date. If it receives a second date, as in the example above, then it will treat the two dates as the outers of an inclusive date range. dates must be in international format. It's likely that this will change to become more flexible in later versions.

#### domain

The rule will match if the FQDN is exactly the same as that given, so changes of subdomain or TLD will cause the match to fail. If you use different domain names in development, staging and production, you may wish to include several domain rules in a match group. Please not that it's likely that this behaviour will change to be a little more friendly in future versions of this package.

#### environment

The rule will match the paramter given against the value of Laravel's APP_ENV global variable. This is most commonly used as a supplementary criteria to safeguard against themes under development leaking out to a production environment.

#### http_scheme

Allows http routes to receive different theme to https routes. The rule takes http or https as its parameter.

#### subdomain

This rule allows just the subdomain to be matched.

#### url_segment

The rule currently receives a single parameter and compares it to the first segment in the route. It's another of those for which expansion and more flexiblity is planned, so use with care.

## Roadmap

More matchers are planned including:

+ country
+ language
+ query parameter

Some existing matchers will be reworked to make them more friendly. It is recommended that you not tie your project to the dev-master and instead target a specific branch. Breaking changes will be clearly stated in the (currently non-existent) change log.

## Contributions

Contributions and suggestions are welcome. Code should be placed on a feature branch and include tests.
