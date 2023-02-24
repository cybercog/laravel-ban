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
use Cog\Tests\Laravel\Ban\AbstractTestCase;
use Cog\Tests\Laravel\Ban\Stubs\Models\User;
use Illuminate\Support\Facades\Event;

final class ModelWasBannedTest extends AbstractTestCase
{
    /** @test */
    public function it_can_fire_event_on_helper_call(): void
    {
        Event::fake([
            ModelWasBanned::class,
        ]);
        $entity = factory(User::class)->create();

        $entity->ban();

        Event::assertDispatched(ModelWasBanned::class);
    }

    /** @test */
    public function it_can_fire_event_on_relation_create(): void
    {
        Event::fake([
            ModelWasBanned::class,
        ]);
        $entity = factory(User::class)->create();

        $entity->bans()->create([]);

        Event::assertDispatched(ModelWasBanned::class);
    }
}
