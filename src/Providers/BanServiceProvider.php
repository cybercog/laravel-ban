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
use Cog\Contracts\Ban\Ban as BanContract;
use Cog\Contracts\Ban\BanService as BanServiceContract;
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
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPublishes();
        $this->registerObservers();
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->registerContracts();
        $this->registerConsoleCommands();
    }

    /**
     * Register Ban's console commands.
     *
     * @return void
     */
    protected function registerConsoleCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->app->bind('command.ban:delete-expired', DeleteExpiredBans::class);

            $this->commands([
                'command.ban:delete-expired',
            ]);
        }
    }

    /**
     * Register Ban's classes in the container.
     *
     * @return void
     */
    protected function registerContracts()
    {
        $this->app->bind(BanContract::class, Ban::class);
        $this->app->singleton(BanServiceContract::class, BanService::class);
    }

    /**
     * Register Ban's models observers.
     *
     * @return void
     */
    protected function registerObservers()
    {
        $this->app->make(BanContract::class)->observe(new BanObserver);
    }

    /**
     * Setup the resource publishing groups for Ban.
     *
     * @return void
     */
    protected function registerPublishes()
    {
        if ($this->app->runningInConsole()) {
            $migrationsPath = __DIR__ . '/../../database/migrations';

            $this->publishes([
                $migrationsPath => database_path('migrations'),
            ], 'migrations');

            $this->loadMigrationsFrom($migrationsPath);
        }
    }
}
