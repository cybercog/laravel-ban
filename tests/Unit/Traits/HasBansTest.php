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
use Cog\Ban\Tests\Stubs\Models\User;
use Cog\Ban\Tests\TestCase;

/**
 * Class HasBansTest.
 *
 * @package Cog\Ban\Tests\Unit\Traits
 */
class HasBansTest extends TestCase
{
    /** @test */
    public function it_can_has_related_ban()
    {
        $user = factory(User::class)->create();
        factory(Ban::class)->create([
            'bannable_id' => $user->getKey(),
            'bannable_type' => $user->getMorphClass(),
        ]);

        $this->assertInstanceOf(Ban::class, $user->bans->first());
    }

    /** @test */
    public function it_can_has_many_related_bans()
    {
        $user = factory(User::class)->create();

        factory(Ban::class, 2)->create([
            'bannable_id' => $user->getKey(),
            'bannable_type' => $user->getMorphClass(),
        ]);

        $this->assertCount(2, $user->bans);
    }

    /** @test */
    public function it_can_ban()
    {
        $user = factory(User::class)->create([
            'banned_at' => null,
        ]);

        $user->ban();
        $user = $user->fresh();

        $this->assertNotNull($user->banned_at);
    }

    /** @test */
    public function it_can_unban()
    {
        $user = factory(User::class)->create([
            'banned_at' => Carbon::now(),
        ]);
        factory(Ban::class)->create([
            'bannable_id' => $user->getKey(),
            'bannable_type' => $user->getMorphClass(),
        ]);

        $user->unban();
        $user = $user->fresh();

        $this->assertNull($user->banned_at);
    }

    /** @test */
    public function it_can_delete_ban_on_unban()
    {
        $user = factory(User::class)->create([
            'banned_at' => Carbon::now(),
        ]);
        factory(Ban::class)->create([
            'bannable_id' => $user->getKey(),
            'bannable_type' => $user->getMorphClass(),
        ]);

        $user->unban();
        $user = $user->fresh();

        $this->assertCount(0, $user->bans);
    }

    /** @test */
    public function it_can_soft_delete_ban_on_unban()
    {
        $user = factory(User::class)->create([
            'banned_at' => Carbon::now(),
        ]);
        factory(Ban::class)->create([
            'bannable_id' => $user->getKey(),
            'bannable_type' => $user->getMorphClass(),
        ]);

        $user->unban();
        $user = $user->fresh();

        $this->assertCount(1, $user->bans()->withTrashed()->get());
    }

    /** @test */
    public function it_can_return_ban_model()
    {
        $user = factory(User::class)->create([
            'banned_at' => null,
        ]);

        $ban = $user->ban();

        $this->assertInstanceOf(Ban::class, $ban);
    }

    /** @test */
    public function it_can_has_empty_banned_by()
    {
        $user = factory(User::class)->create([
            'banned_at' => null,
        ]);

        $ban = $user->ban();

        $this->assertNull($ban->banned_by);
    }

    /** @test */
    public function it_can_has_current_user_as_banned_by()
    {
        $bannedBy = factory(User::class)->create();
        $user = factory(User::class)->create([
            'banned_at' => null,
        ]);

        $this->actingAs($bannedBy);
        $ban = $user->ban();

        $this->assertInstanceOf(User::class, $ban->createdBy);
        $this->assertEquals($bannedBy->getKey(), $ban->createdBy->getKey());
    }

    /** @test */
    public function it_can_ban_via_ban_relation_create()
    {
        $user = factory(User::class)->create([
            'banned_at' => null,
        ]);

        $ban = $user->bans()->create([
            'comment' => 'Enjoy your ban',
            'expired_at' => '+1 month',
        ]);
        $user = $user->fresh();

        $this->assertInstanceOf(Ban::class, $ban);
        $this->assertTrue($user->isBanned());
    }

    /** @test */
    public function it_can_ban_with_comment()
    {
        $user = factory(User::class)->create([
            'banned_at' => null,
        ]);

        $ban = $user->ban([
            'comment' => 'Enjoy your ban',
        ]);

        $this->assertEquals('Enjoy your ban', $ban->comment);
    }

    /** @test */
    public function it_can_ban_with_expiration_date()
    {
        $user = factory(User::class)->create([
            'banned_at' => null,
        ]);

        $ban = $user->ban([
            'expired_at' => '2086-03-28 00:00:00',
        ]);

        $this->assertEquals('2086-03-28 00:00:00', $ban->expired_at);
    }
}
