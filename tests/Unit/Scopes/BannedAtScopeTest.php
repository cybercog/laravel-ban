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

namespace Cog\Tests\Laravel\Ban\Unit\Scopes;

use Cog\Tests\Laravel\Ban\AbstractTestCase;
use Cog\Tests\Laravel\Ban\Stubs\Models\User;
use Cog\Tests\Laravel\Ban\Stubs\Models\UserWithBannedAtScopeApplied;
use Illuminate\Support\Carbon;

final class BannedAtScopeTest extends AbstractTestCase
{
    /** @test */
    public function it_can_get_all_models_by_default(): void
    {
        factory(User::class, 2)->create([
            'banned_at' => Carbon::now()->subDay(),
        ]);

        factory(User::class, 3)->create([
            'banned_at' => null,
        ]);

        $entities = User::all();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_models_without_banned(): void
    {
        factory(User::class, 2)->create([
            'banned_at' => Carbon::now()->subDay(),
        ]);
        factory(User::class, 3)->create([
            'banned_at' => null,
        ]);

        $entities = User::withoutBanned()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_models_with_banned(): void
    {
        factory(User::class, 2)->create([
            'banned_at' => Carbon::now()->subDay(),
        ]);
        factory(User::class, 3)->create([
            'banned_at' => null,
        ]);

        $entities = User::withBanned()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_banned_models(): void
    {
        factory(User::class, 2)->create([
            'banned_at' => Carbon::now()->subDay(),
        ]);
        factory(User::class, 3)->create([
            'banned_at' => null,
        ]);

        $entities = User::onlyBanned()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_auto_apply_banned_at_default_scope(): void
    {
        factory(User::class, 3)->create([
            'banned_at' => Carbon::now()->subDay(),
        ]);
        factory(User::class, 2)->create([
            'banned_at' => null,
        ]);

        $entities = UserWithBannedAtScopeApplied::all();

        $this->assertCount(2, $entities);
    }
}
