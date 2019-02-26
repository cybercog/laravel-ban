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

use Cog\Laravel\Ban\Models\Ban;
use Cog\Tests\Laravel\Ban\Stubs\Models\User;
use Faker\Generator as Faker;

/* @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Ban::class, function (Faker $faker) {
    $bannable = factory(User::class)->create();

    return [
        'bannable_id' => $bannable->getKey(),
        'bannable_type' => $bannable->getMorphClass(),
    ];
});
