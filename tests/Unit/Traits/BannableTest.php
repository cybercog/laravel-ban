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

namespace Cog\Tests\Laravel\Ban\Unit\Traits;

use Cog\Laravel\Ban\Models\Ban;
use Cog\Tests\Laravel\Ban\AbstractTestCase;
use Cog\Tests\Laravel\Ban\Stubs\Models\User;
use Cog\Tests\Laravel\Ban\Stubs\Models\UserWithBannedAtScopeApplied;
use Illuminate\Support\Carbon;

final class BannableTest extends AbstractTestCase
{
    /** @test */
    public function it_can_has_related_ban(): void
    {
        $user = User::factory()->create();

        $ban = factory(Ban::class)->create([
            'bannable_id' => $user->getKey(),
            'bannable_type' => $user->getMorphClass(),
        ]);

        $assertBan = $user->bans->first();
        $this->assertTrue($ban->is($assertBan));
    }

    /** @test */
    public function it_can_has_many_related_bans(): void
    {
        $user = User::factory()->create();

        factory(Ban::class, 2)->create([
            'bannable_id' => $user->getKey(),
            'bannable_type' => $user->getMorphClass(),
        ]);

        $this->assertCount(2, $user->bans);
    }

    /** @test */
    public function it_can_ban(): void
    {
        $user = factory(User::class)->create([
            'banned_at' => null,
        ]);

        $user->ban();

        $user->refresh();
        $this->assertNotNull($user->banned_at);
    }

    /** @test */
    public function it_can_unban(): void
    {
        $user = factory(User::class)->create([
            'banned_at' => Carbon::now(),
        ]);
        factory(Ban::class)->create([
            'bannable_id' => $user->getKey(),
            'bannable_type' => $user->getMorphClass(),
        ]);

        $user->unban();

        $user->refresh();
        $this->assertNull($user->banned_at);
    }

    /** @test */
    public function it_can_ban_user_with_banned_at_scope_applied(): void
    {
        $user = factory(UserWithBannedAtScopeApplied::class)->create([
            'banned_at' => Carbon::now(),
        ]);

        $user->ban();

        // TODO: Replace with `$user->refresh()` after throwing Laravel 5.4 support
        $user = UserWithBannedAtScopeApplied::query()->whereKey($user->getKey())->withBanned()->firstOrFail();
        $this->assertNotNull($user->banned_at);
    }

    /** @test */
    public function it_can_unban_user_with_banned_at_scope_applied(): void
    {
        $user = factory(UserWithBannedAtScopeApplied::class)->create([
            'banned_at' => Carbon::now(),
        ]);
        factory(Ban::class)->create([
            'bannable_id' => $user->getKey(),
            'bannable_type' => $user->getMorphClass(),
        ]);

        $user->unban();

        $user->refresh();
        $this->assertNull($user->banned_at);
    }

    /** @test */
    public function it_can_delete_ban_on_unban(): void
    {
        $user = factory(User::class)->create([
            'banned_at' => Carbon::now(),
        ]);
        factory(Ban::class)->create([
            'bannable_id' => $user->getKey(),
            'bannable_type' => $user->getMorphClass(),
        ]);

        $user->unban();

        $user->refresh();
        $this->assertCount(0, $user->bans);
    }

    /** @test */
    public function it_can_soft_delete_ban_on_unban(): void
    {
        $user = factory(User::class)->create([
            'banned_at' => Carbon::now(),
        ]);
        factory(Ban::class)->create([
            'bannable_id' => $user->getKey(),
            'bannable_type' => $user->getMorphClass(),
        ]);

        $user->unban();

        $user->refresh();
        $this->assertCount(1, $user->bans()->withTrashed()->get());
    }

    /** @test */
    public function it_can_return_ban_model(): void
    {
        $user = factory(User::class)->create([
            'banned_at' => null,
        ]);

        $ban = $user->ban();

        $this->assertInstanceOf(Ban::class, $ban);
    }

    /** @test */
    public function it_can_has_empty_banned_by(): void
    {
        $user = factory(User::class)->create([
            'banned_at' => null,
        ]);

        $ban = $user->ban();

        $this->assertNull($ban->banned_by);
    }

    /** @test */
    public function it_can_has_current_user_as_banned_by(): void
    {
        $bannedBy = User::factory()->create();
        $user = factory(User::class)->create([
            'banned_at' => null,
        ]);
        $this->actingAs($bannedBy);

        $ban = $user->ban();

        $this->assertTrue($bannedBy->is($ban->createdBy));
    }

    /** @test */
    public function it_can_ban_via_ban_relation_create(): void
    {
        $user = factory(User::class)->create([
            'banned_at' => null,
        ]);

        $ban = $user->bans()->create([
            'comment' => 'Enjoy your ban',
            'expired_at' => '+1 month',
        ]);

        $user->refresh();
        $this->assertInstanceOf(Ban::class, $ban);
        $this->assertTrue($user->isBanned());
    }

    /** @test */
    public function it_can_ban_with_comment(): void
    {
        $user = factory(User::class)->create([
            'banned_at' => null,
        ]);

        $ban = $user->ban([
            'comment' => 'Enjoy your ban',
        ]);

        $this->assertSame('Enjoy your ban', $ban->comment);
    }

    /** @test */
    public function it_can_ban_with_expiration_date(): void
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
