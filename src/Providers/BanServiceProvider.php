<?php

/*
 * This file is part of Laravel Ban.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Ban\Providers;

use Cog\Ban\Console\Commands\DeleteExpiredBans;
use Cog\Ban\Contracts\Ban as BanContract;
use Cog\Ban\Contracts\BanService as BanServiceContract;
use Cog\Ban\Models\Ban;
use Cog\Ban\Observers\BanObserver;
use Cog\Ban\Services\BanService;
use Illuminate\Support\ServiceProvider;

/**
 * Class BanServiceProvider.
 *
 * @package Cog\Ban\Providers
 */
class BanServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../database/migrations' => database_path('migrations'),
            ], 'migrations');
        }

        $this->bootObservers();
    }

    /**
     * Register bindings in the container.
     */
    public function register()
    {
        $this->app->bind(BanContract::class, Ban::class);
        $this->app->singleton(BanServiceContract::class, BanService::class);

        if ($this->app->runningInConsole()) {
            $this->app->bind('command.ban:delete-expired', DeleteExpiredBans::class);

            $this->commands([
                'command.ban:delete-expired',
            ]);
        }
    }

    /**
     * Package models observers.
     */
    protected function bootObservers()
    {
        app(BanContract::class)->observe(new BanObserver());
    }
}
