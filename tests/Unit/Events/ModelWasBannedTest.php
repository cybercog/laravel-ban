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

namespace Cog\Tests\Laravel\Ban\Unit\Events;

use Cog\Laravel\Ban\Events\ModelWasBanned;
use Cog\Tests\Laravel\Ban\Stubs\Models\User;
use Cog\Tests\Laravel\Ban\TestCase;
use Illuminate\Foundation\Testing\Concerns\MocksApplicationServices;

class ModelWasBannedTest extends TestCase
{
    use MocksApplicationServices;

    /** @test */
    public function it_can_fire_event_on_helper_call(): void
    {
        $this->expectsEvents(ModelWasBanned::class);

        $entity = factory(User::class)->create();

        $entity->ban();
    }

    /** @test */
    public function it_can_fire_event_on_relation_create(): void
    {
        $this->expectsEvents(ModelWasBanned::class);

        $entity = factory(User::class)->create();

        $entity->bans()->create([]);
    }
}
