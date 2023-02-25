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

use Cog\Laravel\Ban\Events\ModelWasUnbanned;
use Cog\Laravel\Ban\Models\Ban;
use Cog\Tests\Laravel\Ban\AbstractTestCase;
use Illuminate\Support\Facades\Event;

final class ModelWasUnbannedTest extends AbstractTestCase
{
    /** @test */
    public function it_can_fire_event_on_helper_call(): void
    {
        Event::fake([
            ModelWasUnbanned::class,
        ]);
        $ban = Ban::factory()->create();

        $ban->bannable->unban();

        Event::assertDispatched(ModelWasUnbanned::class);
    }

    /** @test */
    public function it_can_fire_event_on_relation_delete(): void
    {
        Event::fake([
            ModelWasUnbanned::class,
        ]);
        $ban = Ban::factory()->create();

        $ban->delete();

        Event::assertDispatched(ModelWasUnbanned::class);
    }
}
