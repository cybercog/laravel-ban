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

namespace Cog\Tests\Laravel\Ban\Unit\Models;

use Cog\Laravel\Ban\Models\Ban;
use Cog\Tests\Laravel\Ban\AbstractTestCase;
use Cog\Tests\Laravel\Ban\Stubs\Models\User;
use Illuminate\Support\Carbon;

final class BanTest extends AbstractTestCase
{
    /** @test */
    public function it_can_fill_comment(): void
    {
        $ban = new Ban([
            'comment' => 'Enjoy your ban!',
        ]);

        $this->assertSame('Enjoy your ban!', $ban->comment);
    }

    /** @test */
    public function it_can_fill_expired_at(): void
    {
        $expiredAt = Carbon::now()->toDateTimeString();

        $ban = new Ban([
            'expired_at' => $expiredAt,
        ]);

        $this->assertEquals($expiredAt, $ban->getAttribute('expired_at'));
    }

    /** @test */
    public function it_can_fill_created_by_type(): void
    {
        $ban = new Ban([
            'created_by_type' => 'TestType',
        ]);

        $this->assertSame('TestType', $ban->getAttribute('created_by_type'));
    }

    /** @test */
    public function it_can_fill_created_by_id(): void
    {
        $ban = new Ban([
            'created_by_id' => '4',
        ]);

        $this->assertSame('4', $ban->getAttribute('created_by_id'));
    }

    /** @test */
    public function it_casts_expired_at(): void
    {
        $ban = new Ban([
            'expired_at' => '2018-03-28 00:00:00',
        ]);

        $this->assertInstanceOf(Carbon::class, $ban->getAttribute('expired_at'));
    }

    /** @test */
    public function it_casts_deleted_at(): void
    {
        $ban = Ban::factory()->create([
            'deleted_at' => '2018-03-28 00:00:00',
        ]);

        $this->assertInstanceOf(Carbon::class, $ban->deleted_at);
    }

    /** @test */
    public function it_not_modify_null_expired_at(): void
    {
        $ban = new Ban([
            'expired_at' => null,
        ]);

        $this->assertNull($ban->getAttribute('expired_at'));
    }

    /** @test */
    public function it_can_has_ban_creator(): void
    {
        $bannedBy = User::factory()->create();

        $ban = Ban::factory()->create([
            'created_by_type' => $bannedBy->getMorphClass(),
            'created_by_id' => $bannedBy->getKey(),
        ]);

        $this->assertInstanceOf(User::class, $ban->createdBy);
    }

    /** @test */
    public function it_can_set_custom_ban_creator(): void
    {
        $bannable = User::factory()->create();;
        $bannedBy = User::factory()->create();;

        $ban = $bannable->bans()->create([
            'created_by_type' => $bannedBy->getMorphClass(),
            'created_by_id' => $bannedBy->getKey(),
        ]);

        $this->assertTrue($ban->createdBy->is($bannedBy));
    }

    /** @test */
    public function it_not_overwrite_ban_creator_with_auth_user_if_custom_value_is_provided(): void
    {
        $bannable = User::factory()->create();
        $bannedBy = User::factory()->create();
        $currentUser = User::factory()->create();

        $this->actingAs($currentUser);

        $ban = $bannable->bans()->create([
            'created_by_type' => $bannedBy->getMorphClass(),
            'created_by_id' => $bannedBy->getKey(),
        ]);

        $this->assertTrue($ban->createdBy->is($bannedBy));
    }

    /** @test */
    public function it_can_make_model_with_expire_carbon_date(): void
    {
        $expiredAt = Carbon::now();

        $ban = new Ban([
            'expired_at' => $expiredAt,
        ]);

        $this->assertEquals($expiredAt, $ban->getAttribute('expired_at'));
    }

    /** @test */
    public function it_can_make_model_with_expire_string_date(): void
    {
        $ban = new Ban([
            'expired_at' => '2086-03-28 00:00:00',
        ]);

        $this->assertEquals('2086-03-28 00:00:00', $ban->getAttribute('expired_at'));
    }

    /** @test */
    public function it_can_make_model_with_expire_relative_date(): void
    {
        $ban = new Ban([
            'expired_at' => '+1 year',
        ]);

        // TODO: Mock and check that \Illuminate\Support\Carbon::parse() method is called
        $this->assertSame(
            Carbon::parse('+1 year')->format('Y'),
            $ban->getAttribute('expired_at')->format('Y')
        );
    }

    /** @test */
    public function it_can_has_bannable_model(): void
    {
        $user = User::factory()->create();

        $ban = Ban::factory()->create([
            'bannable_id' => $user->getKey(),
            'bannable_type' => $user->getMorphClass(),
        ]);

        $this->assertInstanceOf(User::class, $ban->bannable);
    }

    /** @test */
    public function it_can_scope_bannable_models(): void
    {
        $user1 = User::factory()->create();
        Ban::factory()->count(4)->create([
            'bannable_id' => $user1->getKey(),
            'bannable_type' => $user1->getMorphClass(),
        ]);
        $user2 = User::factory()->create();
        Ban::factory()->count(3)->create([
            'bannable_id' => $user2->getKey(),
            'bannable_type' => $user2->getMorphClass(),
        ]);

        $bannableModels = Ban::whereBannable($user1)->get();

        $this->assertCount(4, $bannableModels);
    }

    /** @test */
    public function it_can_check_if_ban_is_permanent(): void
    {
        $permanentBan = new Ban();
        $temporaryBan = new Ban([
            'expired_at' => '2086-03-28 00:00:00',
        ]);

        $this->assertTrue($permanentBan->isPermanent());
        $this->assertFalse($temporaryBan->isPermanent());
    }

    /** @test */
    public function it_can_check_if_ban_is_temporary(): void
    {
        $permanentBan = new Ban();
        $temporaryBan = new Ban([
            'expired_at' => '2086-03-28 00:00:00',
        ]);

        $this->assertFalse($permanentBan->isTemporary());
        $this->assertTrue($temporaryBan->isTemporary());
    }

    /** @test */
    public function it_can_check_if_ban_with_null_expired_at_is_permanent(): void
    {
        $permanentBan = new Ban([
            'expired_at' => null,
        ]);

        $this->assertTrue($permanentBan->isPermanent());
        $this->assertFalse($permanentBan->isTemporary());
    }
}
