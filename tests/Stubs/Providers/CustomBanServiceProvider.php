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

namespace Cog\Tests\Laravel\Ban\Stubs\Providers;

use Cog\Contracts\Ban\Ban as BanContract;
use Cog\Tests\Laravel\Ban\Stubs\Models\CustomBan;
use Illuminate\Support\ServiceProvider;

final class CustomBanServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(BanContract::class, CustomBan::class);
    }
}
