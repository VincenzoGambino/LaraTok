# LaraTok
Laravel package for OpenTok.

## Installation
### Composer
```
composer require vincenzogambino/laratok
```

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

### Set configuration on config/laratok.php:
Minimum configuration:
- api_key
- api_secret

You must have a tokbox account in order to have the parameteres above.


## Admin Pages:
- /laratok

From this page you can see existing tokens grouped by sessions.

## Example Pages:
- /laratok/examples

Pages showing example session and token. If example session and token does not exist it can be generated from there.

- /laratok/examples/simple

Simple video chat example

- /laratok/examples/signaling

Example page with videochat and messaging.

# Usage:

### Generate Session and persist it in the database:
```
$latarok = new Laratok();
$laratok->generateSession();
```

### Generate Token and persist it in the database:
```
$latarok = new Laratok();
$laratok->generateToken();
```
## Usage:
```
$laratok = new LaraTok();
$session_id = $laratok->generateSession();
$token_id = $laratok->generateToken($session_id);

return view('YOUR_VIEW', compact('session_id', 'token_id'));
```

## OpenTok documentation:
https://tokbox.com/developer/
