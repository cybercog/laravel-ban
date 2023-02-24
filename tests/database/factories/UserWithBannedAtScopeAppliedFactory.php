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

namespace Cog\Tests\Laravel\Ban\Database\Factories;

use Cog\Tests\Laravel\Ban\Stubs\Models\UserWithBannedAtScopeApplied;
use Illuminate\Database\Eloquent\Factories\Factory;

final class UserWithBannedAtScopeAppliedFactory extends Factory
{
    protected $model = UserWithBannedAtScopeApplied::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, UserWithBannedAtScopeApplied>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
        ];
    }
}
