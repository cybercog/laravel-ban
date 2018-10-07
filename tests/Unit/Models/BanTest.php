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

        $this->assertSame('Enjoy your ban!', $ban->comment);
    }

    /** @test */
    public function it_can_fill_expired_at()
    {
        $expiredAt = Carbon::now()->toDateTimeString();

        $ban = new Ban([
            'expired_at' => $expiredAt,
        ]);

        $this->assertEquals($expiredAt, $ban->expired_at);
    }

    /** @test */
    public function it_can_fill_created_by_type()
    {
        $ban = new Ban([
            'created_by_type' => 'TestType',
        ]);

        $this->assertSame('TestType', $ban->created_by_type);
    }

    /** @test */
    public function it_can_fill_created_by_id()
    {
        $ban = new Ban([
            'created_by_id' => '4',
        ]);

        $this->assertSame('4', $ban->created_by_id);
    }

    /** @test */
    public function it_casts_expired_at()
    {
        $ban = new Ban([
            'expired_at' => '2018-03-28 00:00:00',
        ]);

        $this->assertInstanceOf(Carbon::class, $ban->expired_at);
    }

    /** @test */
    public function it_casts_deleted_at()
    {
        $ban = factory(Ban::class)->create([
            'deleted_at' => '2018-03-28 00:00:00',
        ]);

        $this->assertInstanceOf(Carbon::class, $ban->deleted_at);
    }

    /** @test */
    public function it_not_modify_null_expired_at()
    {
        $ban = new Ban([
            'expired_at' => null,
        ]);

        $this->assertNull($ban->expired_at);
    }

    /** @test */
    public function it_can_has_ban_creator()
    {
        $bannedBy = factory(User::class)->create();

        $ban = factory(Ban::class)->create([
            'created_by_type' => $bannedBy->getMorphClass(),
            'created_by_id' => $bannedBy->getKey(),
        ]);

        $this->assertInstanceOf(User::class, $ban->createdBy);
    }

    /** @test */
    public function it_can_set_custom_ban_creator()
    {
        $bannable = factory(User::class)->create();
        $bannedBy = factory(User::class)->create();

        $ban = $bannable->bans()->create([
            'created_by_type' => $bannedBy->getMorphClass(),
            'created_by_id' => $bannedBy->getKey(),
        ]);

        $this->assertTrue($ban->createdBy->is($bannedBy));
    }

    /** @test */
    public function it_not_overwrite_ban_creator_with_auth_user_if_custom_value_is_provided()
    {
        $bannable = factory(User::class)->create();
        $bannedBy = factory(User::class)->create();
        $currentUser = factory(User::class)->create();

        $this->actingAs($currentUser);

        $ban = $bannable->bans()->create([
            'created_by_type' => $bannedBy->getMorphClass(),
            'created_by_id' => $bannedBy->getKey(),
        ]);

        $this->assertTrue($ban->createdBy->is($bannedBy));
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

    /** @test */
    public function it_can_check_if_ban_is_permanent()
    {
        $permanentBan = new Ban();
        $temporaryBan = new Ban([
            'expired_at' => '2086-03-28 00:00:00',
        ]);

        $this->assertTrue($permanentBan->isPermanent());
        $this->assertFalse($temporaryBan->isPermanent());
    }

    /** @test */
    public function it_can_check_if_ban_is_temporary()
    {
        $permanentBan = new Ban();
        $temporaryBan = new Ban([
            'expired_at' => '2086-03-28 00:00:00',
        ]);

        $this->assertFalse($permanentBan->isTemporary());
        $this->assertTrue($temporaryBan->isTemporary());
    }

    /** @test */
    public function it_can_check_if_ban_with_null_expired_at_is_permanent()
    {
        $permanentBan = new Ban([
            'expired_at' => null,
        ]);

        $this->assertTrue($permanentBan->isPermanent());
        $this->assertFalse($permanentBan->isTemporary());
    }
}
