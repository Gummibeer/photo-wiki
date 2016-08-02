<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

$app = new Illuminate\Foundation\Application(
    realpath(__DIR__ . '/../')
);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

/*
|--------------------------------------------------------------------------
| Configure Monolog
|--------------------------------------------------------------------------
*/

$app->configureMonologUsing(function (Monolog\Logger $monolog) {
    function is_valid_log_driver(array $driver)
    {
        return (
            array_get($driver, 'enabled', true) &&
            array_key_exists('handler', $driver) &&
            array_key_exists('args', $driver) &&
            class_exists($driver['handler']) &&
            is_array($driver['args'])
        );
    }

    $drivers = config('monolog.drivers');
    if (is_array($drivers) && !empty($drivers)) {
        foreach ($drivers as $driver) {
            try {
                if (is_valid_log_driver($driver)) {
                    $handler = (new ReflectionClass($driver['handler']))->newInstanceArgs($driver['args']);
                    $monolog->pushHandler($handler);
                }
            } catch (Exception $e) {
                // ignore it
            }
        }
    }

    $monolog->pushProcessor(new \Monolog\Processor\WebProcessor($_SERVER));
    $monolog->pushProcessor(function ($record) {
        try {
            $record['extra']['session_id'] = Cookie::get(Config::get('session.cookie'));
            $record['extra']['app_name'] = config('app.name');
            $record['extra']['app_version'] = config('app.version');
            if (Auth::check()) {
                $record['extra']['account_id'] = Auth::id();
                $record['extra']['account_email'] = Auth::user()->email;
            }
        } catch (Exception $e) {
            // ignore it
        }
        return $record;
    });
});

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;
