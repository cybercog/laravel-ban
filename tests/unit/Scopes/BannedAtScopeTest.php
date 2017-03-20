<?php

/*
 * This file is part of Laravel Ban.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Ban\Tests\Unit\Scopes;

use Carbon\Carbon;
use Cog\Ban\Tests\Stubs\Models\User;
use Cog\Ban\Tests\Stubs\Models\UserWithBannedAtScopeApplied;
use Cog\Ban\Tests\TestCase;

/**
 * Class BannedAtScopeTest.
 *
 * @package Cog\Ban\Tests\Unit\Scopes
 */
class BannedAtScopeTest extends TestCase
{
    /** @test */
    public function it_can_get_all_models_by_default()
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
    public function it_can_get_models_without_banned()
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
    public function it_can_get_models_with_banned()
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
    public function it_can_get_only_banned_models()
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
    public function it_can_auto_apply_banned_at_default_scope()
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
