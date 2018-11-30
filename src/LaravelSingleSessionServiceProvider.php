<?php

namespace CleaniqueCoders\LaravelSingleSession;

use CleaniqueCoders\LaravelSingleSession\Listeners\DestroySingleSession;
use CleaniqueCoders\LaravelSingleSession\Listeners\StoreSingleSession;
use CleaniqueCoders\LaravelSingleSession\Listeners\ValidateSingleSession;
use Illuminate\Auth\Events\Attempting;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class LaravelSingleSessionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /* Configuration */
        $this->publishes([
            __DIR__ . '/../config/single-session.php' => config_path('single-session.php'),
        ]);
        $this->mergeConfigFrom(
            __DIR__ . '/../config/single-session.php', 'single-session'
        );

        /* Translation */
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang/en', 'single-session');
        $this->publishes([
            __DIR__ . '/../resources/lang/en' => resource_path('lang/vendor/single-session'),
        ]);

        /* Views */
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'single-session');
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/single-session'),
        ]);
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->registerListeners();
    }

    private function registerListeners()
    {
        Event::listen(Attempting::class, ValidateSingleSession::class);
        Event::listen(Login::class, StoreSingleSession::class);
        Event::listen(Logout::class, DestroySingleSession::class);
    }
}
