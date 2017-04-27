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

use Cog\Ban\Models\Ban;
use Cog\Ban\Tests\Stubs\Models\User;
use Cog\Ban\Tests\TestCase;

/**
 * Class BanObserverTest.
 *
 * @package Cog\Ban\Tests\Unit\Observers
 */
class BanObserverTest extends TestCase
{
    /** @test */
    public function it_can_set_banned_flag_to_owner_model_on_create()
    {
        $user = factory(User::class)->create([
            'banned_at' => null,
        ]);

        $user->bans()->create([]);

        $user = $user->fresh();
        $this->assertNotNull($user->banned_at);
    }
}
