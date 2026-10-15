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

namespace Cog\Tests\Laravel\Ban\Unit\Services;

use Cog\Laravel\Ban\Providers\BanServiceProvider;
use Cog\Tests\Laravel\Ban\AbstractTestCase;
use Cog\Tests\Laravel\Ban\Stubs\Models\CustomBan;
use Cog\Tests\Laravel\Ban\Stubs\Models\User;
use Cog\Tests\Laravel\Ban\Stubs\Providers\CustomBanServiceProvider;
use Illuminate\Support\Carbon;

final class CustomBanServiceTest extends AbstractTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            BanServiceProvider::class,
            CustomBanServiceProvider::class,
        ];
    }

    public function test_expiration_uses_the_bound_ban_model_and_its_observer(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-10-15 12:00:00'));

        try {
            $user = User::factory()->create(['banned_at' => null]);
            $ban = $user->ban(['expired_at' => Carbon::now()->subMinute()]);
            $this->assertInstanceOf(CustomBan::class, $ban);
            $this->assertTrue($user->fresh()->isBanned());

            $this->artisan('ban:delete-expired')->assertExitCode(0);

            $this->assertTrue($ban->fresh()->trashed());
            $this->assertTrue($user->fresh()->isNotBanned());
        } finally {
            Carbon::setTestNow();
        }
    }
}
