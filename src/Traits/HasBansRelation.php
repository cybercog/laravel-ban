<?php

/*
 * This file is part of Laravel Ban.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Ban\Traits;

use Cog\Ban\Contracts\Ban as BanContract;

/**
 * Class HasBansRelation.
 *
 * @package Cog\Ban\Traits
 */
trait HasBansRelation
{
    /**
     * Entity Bans.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function bans()
    {
        return $this->morphMany(app(BanContract::class), 'owned_by');
    }
}
