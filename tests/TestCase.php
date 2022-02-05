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

namespace Cog\Tests\Laravel\Ban;

use Cog\Laravel\Ban\Providers\BanServiceProvider;
use Cog\Tests\Laravel\Ban\Stubs\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\File;
use Orchestra\Database\ConsoleServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /**
     * Actions to be performed on PHPUnit start.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->destroyPackageMigrations();
        $this->publishPackageMigrations();
        $this->migratePackageTables();
        $this->migrateUnitTestTables();
        $this->registerPackageFactories();
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app): void
    {
        $this->setDefaultUserModel($app);
    }

    /**
     * Load package service provider.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            BanServiceProvider::class,
            ConsoleServiceProvider::class,
        ];
    }

    /**
     * Publish package migrations.
     *
     * @return void
     */
    protected function publishPackageMigrations(): void
    {
        $this->artisan('vendor:publish', [
            '--force' => '',
            '--tag' => 'migrations',
        ]);
    }

    /**
     * Delete all published package migrations.
     *
     * @return void
     */
    protected function destroyPackageMigrations(): void
    {
        File::cleanDirectory('vendor/orchestra/testbench-core/laravel/database/migrations');
    }

    /**
     * Perform unit test database migrations.
     *
     * @return void
     */
    protected function migrateUnitTestTables(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }

    /**
     * Perform package database migrations.
     *
     * @return void
     */
    protected function migratePackageTables(): void
    {
        $this->loadMigrationsFrom(database_path('migrations'));
    }

    /**
     * Register package related model factories.
     *
     * @return void
     */
    private function registerPackageFactories(): void
    {
        $pathToFactories = realpath(__DIR__ . '/database/factories');
        $this->withFactories($pathToFactories);
    }

    /**
     * Set default user model used by tests.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return void
     */
    private function setDefaultUserModel($app): void
    {
        $app->make('config')->set('auth.providers.users.model', User::class);
    }
}
