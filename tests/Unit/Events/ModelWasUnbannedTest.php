<?php

/*
 * This file is part of Laravel Ban.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cog\Tests\Laravel\Ban\Unit\Events;

use Cog\Laravel\Ban\Events\ModelWasUnbanned;
use Cog\Laravel\Ban\Models\Ban;
use Cog\Tests\Laravel\Ban\TestCase;

class ModelWasUnbannedTest extends TestCase
{
    /** @test */
    public function it_can_fire_event_on_helper_call(): void
    {
        $this->expectsEvents(ModelWasUnbanned::class);

        $ban = factory(Ban::class)->create();
        $ban->bannable->unban();
    }

    /** @test */
    public function it_can_fire_event_on_relation_delete(): void
    {
        $this->expectsEvents(ModelWasUnbanned::class);

        $ban = factory(Ban::class)->create();
        $ban->delete();
    }
}
