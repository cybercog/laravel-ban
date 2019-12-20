<?php

/*
 * This file is part of Laravel Ban.
 *
 * (c) Anton Komarev <anton@komarev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cog\Laravel\Ban\Providers;

use Cog\Contracts\Ban\Ban as BanContract;
use Cog\Contracts\Ban\BanService as BanServiceContract;
use Cog\Laravel\Ban\Console\Commands\DeleteExpiredBans;
use Cog\Laravel\Ban\Models\Ban;
use Cog\Laravel\Ban\Observers\BanObserver;
use Cog\Laravel\Ban\Services\BanService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class BanServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerContracts();
        $this->registerConsoleCommands();
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function boot(): void
    {
        $this->configure();
        $this->registerPublishes();
        $this->registerObservers();
    }

    /**
     * Register Ban's console commands.
     *
     * @return void
     */
    protected function registerConsoleCommands(): void
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
    protected function registerContracts(): void
    {
        $this->app->bind(BanContract::class, Ban::class);
        $this->app->singleton(BanServiceContract::class, BanService::class);
    }

    /**
     * Register Ban's models observers.
     *
     * @return void
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function registerObservers(): void
    {
        $this->app->make(BanContract::class)->observe(new BanObserver);
    }

    /**
     * Setup the resource publishing groups for Ban.
     *
     * @return void
     */
    protected function registerPublishes(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/ban.php' => config_path('ban.php'),
            ], 'ban-config');

            $this->publishes([
                __DIR__ . '/../../database/migrations' => database_path('migrations'),
            ], 'migrations');
        }

        $this->registerMigrations();
    }

    /**
     * Register the Ban migrations.
     *
     * @return void
     */
    private function registerMigrations(): void
    {
        if ($this->app->runningInConsole() && $this->shouldLoadDefaultMigrations()) {
            $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        }
    }

    /**
     * Merge Ban configuration with the application configuration.
     *
     * @return void
     */
    private function configure(): void
    {
        if (!$this->app->configurationIsCached()) {
            $this->mergeConfigFrom(__DIR__ . '/../../config/ban.php', 'ban');
        }
    }

    /**
     * Determine if we should register default migrations.
     *
     * @return bool
     */
    private function shouldLoadDefaultMigrations(): bool
    {
        return Config::get('ban.load_default_migrations', true);
    }
}
