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

use Cog\Laravel\Ban\Models\Ban;
use Cog\Laravel\Ban\Services\BanService;
use Cog\Tests\Laravel\Ban\AbstractTestCase;
use Illuminate\Support\Carbon;

final class BanServiceTest extends AbstractTestCase
{
    /** @test */
    public function it_can_delete_all_expired_bans(): void
    {
        factory(Ban::class, 3)->create([
            'expired_at' => Carbon::now()->subMonth(),
        ]);
        factory(Ban::class, 4)->create([
            'expired_at' => Carbon::now()->addMonth(),
        ]);
        $banService = new BanService();

        $banService->deleteExpiredBans();

        $this->assertCount(4, Ban::all());
    }
}
