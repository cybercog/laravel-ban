<?php

/*
 * This file is part of Laravel Ban.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Tests\Laravel\Ban\Unit\Services;

use Carbon\Carbon;
use Cog\Laravel\Ban\Models\Ban;
use Cog\Laravel\Ban\Services\BanService;
use Cog\Tests\Laravel\Ban\TestCase;

/**
 * Class BanServiceTest.
 *
 * @package Cog\Tests\Laravel\Ban\Unit\Services
 */
class BanServiceTest extends TestCase
{
    /** @test */
    public function it_can_delete_all_expired_bans()
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
