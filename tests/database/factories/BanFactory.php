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

use Cog\Laravel\Ban\Models\Ban;
use Cog\Tests\Laravel\Ban\Stubs\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

final class BanFactory extends Factory
{
    protected $model = Ban::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'bannable_type' => (new User())->getMorphClass(),
            'bannable_id' => User::factory(),
        ];
    }
}
