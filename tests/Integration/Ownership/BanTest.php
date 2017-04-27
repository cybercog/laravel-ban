<?php

/*
 * This file is part of Laravel Ban.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Ban\Tests\Integration\Ownership;

use Cog\Ban\Tests\Stubs\Models\User;
use Cog\Ban\Tests\TestCase;

/**
 * Class BanTest.
 *
 * @package Cog\Ban\Tests\Integration\Ownership
 */
class BanTest extends TestCase
{
    /** @test */
    public function it_can_has_bannable_entity_as_ban_owner()
    {
        $user = factory(User::class)->create();

        $ban = $user->ban();

        $this->assertInstanceOf(User::class, $ban->owner);
    }
}
