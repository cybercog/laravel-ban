<?php

/*
 * This file is part of Laravel Ban.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Tests\Laravel\Ban\Unit\Events;

use Cog\Laravel\Ban\Events\ModelWasUnbanned;
use Cog\Laravel\Ban\Models\Ban;
use Cog\Tests\Laravel\Ban\TestCase;

/**
 * Class ModelWasUnbannedTest.
 *
 * @package Cog\Tests\Laravel\Ban\Unit\Events
 */
class ModelWasUnbannedTest extends TestCase
{
    /** @test */
    public function it_can_fire_event_on_helper_call()
    {
        $this->expectsEvents(ModelWasUnbanned::class);

        $ban = factory(Ban::class)->create();
        $ban->bannable->unban();
    }

    /** @test */
    public function it_can_fire_event_on_relation_delete()
    {
        $this->expectsEvents(ModelWasUnbanned::class);

        $ban = factory(Ban::class)->create();
        $ban->delete();
    }
}
