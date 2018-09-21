<?php

/*
 * This file is part of Laravel Ban.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Cog\Tests\Laravel\Ban\Stubs\Models\User;
use Cog\Tests\Laravel\Ban\Stubs\Models\UserWithBannedAtScopeApplied;
use Faker\Generator as Faker;

/* @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});

/* @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(UserWithBannedAtScopeApplied::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
