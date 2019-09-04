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

namespace Cog\Tests\Laravel\Ban\Unit\Observers;

use Cog\Tests\Laravel\Ban\Stubs\Models\User;
use Cog\Tests\Laravel\Ban\TestCase;

class BanObserverTest extends TestCase
{
    /** @test */
    public function it_can_set_banned_flag_to_owner_model_on_create(): void
    {
        $user = factory(User::class)->create([
            'banned_at' => null,
        ]);

        $user->bans()->create([]);

        $user->refresh();
        $this->assertNotNull($user->banned_at);
    }
}
