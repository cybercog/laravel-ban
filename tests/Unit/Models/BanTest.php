<?php

/*
 * This file is part of Laravel Ban.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Tests\Laravel\Ban\Unit\Models;

use Carbon\Carbon;
use Cog\Laravel\Ban\Models\Ban;
use Cog\Tests\Laravel\Ban\Stubs\Models\User;
use Cog\Tests\Laravel\Ban\TestCase;

/**
 * Class BanTest.
 *
 * @package Cog\Tests\Laravel\Ban\Unit\Models
 */
class BanTest extends TestCase
{
    /** @test */
    public function it_can_fill_comment()
    {
        $ban = new Ban([
            'comment' => 'Enjoy your ban!',
        ]);

        $this->assertEquals('Enjoy your ban!', $ban->comment);
    }

    /** @test */
    public function it_can_fill_expired_at()
    {
        $expiredAt = Carbon::now()->format('Y-m-d H:i:s');

        $ban = new Ban([
            'expired_at' => $expiredAt,
        ]);

        $this->assertEquals($expiredAt, $ban->expired_at);
    }

    /** @test */
    public function it_can_cast_expired_at()
    {
        $expiredAt = Carbon::now();

        $ban = new Ban([
            'expired_at' => $expiredAt,
        ]);

        $this->assertInstanceOf(Carbon::class, $ban->expired_at);
    }

    /** @test */
    public function it_can_has_ban_creator()
    {
        $bannedBy = factory(User::class)->create();

        $ban = factory(Ban::class)->create([
            'created_by_id' => $bannedBy->getKey(),
            'created_by_type' => $bannedBy->getMorphClass(),
        ]);

        $this->assertInstanceOf(User::class, $ban->createdBy);
    }

    /** @test */
    public function it_can_make_model_with_expire_carbon_date()
    {
        $expiredAt = Carbon::now();

        $ban = new Ban([
            'expired_at' => $expiredAt,
        ]);

        $this->assertEquals($expiredAt, $ban->expired_at);
    }

    /** @test */
    public function it_can_make_model_with_expire_string_date()
    {
        $ban = new Ban([
            'expired_at' => '2086-03-28 00:00:00',
        ]);

        $this->assertEquals('2086-03-28 00:00:00', $ban->expired_at);
    }

    /** @test */
    public function it_can_make_model_with_expire_relative_date()
    {
        $ban = new Ban([
            'expired_at' => '+1 year',
        ]);

        // TODO: Mock and check that \Carbon\Carbon::parse() method is called
        $this->assertEquals(Carbon::parse('+1 year')->format('Y'), $ban->expired_at->format('Y'));
    }

    /** @test */
    public function it_can_has_bannable_model()
    {
        $user = factory(User::class)->create();

        $ban = factory(Ban::class)->create([
            'bannable_id' => $user->getKey(),
            'bannable_type' => $user->getMorphClass(),
        ]);

        $this->assertInstanceOf(User::class, $ban->bannable);
    }

    /** @test */
    public function it_can_scope_bannable_models()
    {
        $user1 = factory(User::class)->create();
        factory(Ban::class, 4)->create([
            'bannable_id' => $user1->getKey(),
            'bannable_type' => $user1->getMorphClass(),
        ]);
        $user2 = factory(User::class)->create();
        factory(Ban::class, 3)->create([
            'bannable_id' => $user2->getKey(),
            'bannable_type' => $user2->getMorphClass(),
        ]);

        $bannableModels = Ban::whereBannable($user1)->get();

        $this->assertCount(4, $bannableModels);
    }
}
