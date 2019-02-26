<?php

/*
 * This file is part of Laravel Ban.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cog\Tests\Laravel\Ban\Unit\Traits;

use Cog\Tests\Laravel\Ban\Stubs\Models\User;
use Cog\Tests\Laravel\Ban\TestCase;
use Illuminate\Support\Carbon;

class HasBannedAtHelpersTest extends TestCase
{
    /** @test */
    public function it_can_set_banned_flag(): void
    {
        $user = factory(User::class)->create([
            'banned_at' => null,
        ]);

        $user->setBannedFlag();

        $this->assertNotNull($user->banned_at);
    }

    /** @test */
    public function it_can_unset_banned_flag(): void
    {
        $user = factory(User::class)->create([
            'banned_at' => Carbon::now(),
        ]);

        $user->unsetBannedFlag();

        $this->assertNull($user->banned_at);
    }

    /** @test */
    public function it_can_check_if_entity_banned(): void
    {
        $user = factory(User::class)->create([
            'banned_at' => Carbon::now(),
        ]);

        $this->assertTrue($user->isBanned());
    }

    /** @test */
    public function it_can_check_if_entity_not_banned(): void
    {
        $user = factory(User::class)->create([
            'banned_at' => null,
        ]);

        $this->assertTrue($user->isNotBanned());
    }
}
