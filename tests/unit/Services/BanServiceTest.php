<?php

/*
 * This file is part of Laravel Ban.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Ban\Tests\Unit\Traits;

use Carbon\Carbon;
use Cog\Ban\Models\Ban;
use Cog\Ban\Services\BanService;
use Cog\Ban\Tests\Stubs\Models\User;
use Cog\Ban\Tests\TestCase;

/**
 * Class BanServiceTest.
 *
 * @package Cog\Ban\Tests\Unit\Services
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
