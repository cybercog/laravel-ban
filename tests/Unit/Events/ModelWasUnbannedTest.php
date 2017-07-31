<?php

/*
 * This file is part of Laravel Ban.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Ban\Tests\Unit\Events;

use Cog\Ban\Events\ModelWasUnbanned;
use Cog\Ban\Models\Ban;
use Cog\Ban\Tests\TestCase;

/**
 * Class ModelWasUnbannedTest.
 *
 * @package Cog\Ban\Tests\Unit\Events
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
