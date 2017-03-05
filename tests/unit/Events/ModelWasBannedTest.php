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

use Cog\Ban\Events\ModelWasBanned;
use Cog\Ban\Tests\Stubs\Models\User;
use Cog\Ban\Tests\TestCase;

/**
 * Class ModelWasBannedTest.
 *
 * @package Cog\Ban\Tests\Unit\Models
 */
class ModelWasBannedTest extends TestCase
{
    /** @test */
    public function it_can_fire_event_on_helper_call()
    {
        $this->expectsEvents(ModelWasBanned::class);

        $entity = factory(User::class)->create();
        $entity->ban();
    }

    /** @test */
    public function it_can_fire_event_on_relation_create()
    {
        $this->expectsEvents(ModelWasBanned::class);

        $entity = factory(User::class)->create();
        $entity->bans()->create([]);
    }
}
