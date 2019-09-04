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

namespace Cog\Laravel\Ban\Traits;

use Cog\Contracts\Ban\Ban as BanContract;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasBansRelation
{
    /**
     * Entity Bans.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function bans(): MorphMany
    {
        return $this->morphMany(app(BanContract::class), 'bannable');
    }
}
