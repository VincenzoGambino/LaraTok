# LaraTok
Laravel package for OpenTok.

## Installation
### Composer
```
composer require vincenzogambino/laratok
```
Add the package to your application service providers in config/app.php file for provider
### Open your config/app.php and add the following to the providers array:
```
'providers' => [

    /*
     * Laravel Framework Service Providers...
     */
    Illuminate\Auth\AuthServiceProvider::class,
    ...

    /**
     * Third Party Service Providers...
     */
    VincenzoGambino\LaraTok\LaraTokServiceProvider::class,

],
```
### In the same config/app.php and add the following to the aliases array:
```
'aliases' => [

        'App' => Illuminate\Support\Facades\App::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        ...
        'LaraTok' => VincenzoGambino\LaraTok\Facade\LaraTokFacade::class,

    ],
```
### Run the command below to publish the package config file config/laratok.php:
```
php artisan vendor:publish
```

### Create the database:
```
php artisan migrate
```
