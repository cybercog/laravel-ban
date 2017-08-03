<?php

/*
 * This file is part of Laravel Ban.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Laravel\Ban\Providers;

use Cog\Laravel\Ban\Console\Commands\DeleteExpiredBans;
use Cog\Laravel\Ban\Contracts\Ban as BanContract;
use Cog\Laravel\Ban\Contracts\BanService as BanServiceContract;
use Cog\Laravel\Ban\Models\Ban;
use Cog\Laravel\Ban\Observers\BanObserver;
use Cog\Laravel\Ban\Services\BanService;
use Illuminate\Support\ServiceProvider;

/**
 * Class BanServiceProvider.
 *
 * @package Cog\Laravel\Ban\Providers
 */
class BanServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        $this->bootMigrations();
        $this->bootObservers();
    }

    /**
     * Register bindings in the container.
     */
    public function register()
    {
        $this->registerConsoleCommands();
        $this->registerContracts();
    }

    protected function registerConsoleCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->app->bind('command.ban:delete-expired', DeleteExpiredBans::class);

            $this->commands([
                'command.ban:delete-expired',
            ]);
        }
    }

    protected function registerContracts()
    {
        $this->app->bind(BanContract::class, Ban::class);
        $this->app->singleton(BanServiceContract::class, BanService::class);
    }

    /**
     * Package models observers.
     */
    protected function bootObservers()
    {
        $this->app->make(BanContract::class)->observe(new BanObserver);
    }

    protected function bootMigrations()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../database/migrations' => database_path('migrations'),
            ], 'migrations');
        }
    }
}
