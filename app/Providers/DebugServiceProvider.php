<?php

namespace App\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class DebugServiceProvider extends ServiceProvider
{
    protected $providerNames = [
        'Barryvdh\Debugbar\ServiceProvider',
        'Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider',
    ];

    protected $providers = [];

    public function __construct($app)
    {
        parent::__construct($app);

        if (config('app.debug')) {
            foreach ($this->providerNames as $providerName) {
                if (class_exists($providerName)) {
                    $this->providers[$providerName] = $this->getProviderInstance($providerName);
                }
            }
        }
    }

    public function boot()
    {
        foreach ($this->providers as $provider) {
            $provider->boot();
        }
    }

    public function register()
    {
        foreach ($this->providers as $provider) {
            $provider->register();
        }
        $loader = AliasLoader::getInstance();
        $loader->alias('Debugbar', \Barryvdh\Debugbar\Facade::class);
    }

    private function getProviderInstance($providerName)
    {
        return new $providerName($this->app);
    }
}
