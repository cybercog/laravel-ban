<?php

/*
 * This file is part of Laravel Ban.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Cog\Ban\Tests\Stubs\Models\User;

$factory->define(\Cog\Ban\Models\Ban::class, function (\Faker\Generator $faker) {
    $bannable = factory(User::class)->create();

    return [
        'owned_by_id' => $bannable->getKey(),
        'owned_by_type' => $bannable->getMorphClass(),
    ];
});
