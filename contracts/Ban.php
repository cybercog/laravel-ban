<?php

/*
 * This file is part of Laravel Ban.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Contracts\Ban;

use Cog\Contracts\Ban\Bannable as BannableContract;
use Illuminate\Database\Eloquent\Builder;

/**
 * Interface Ban.
 *
 * @package Cog\Contracts\Ban
 */
interface Ban
{
    /**
     * Entity responsible for ban.
     *
     * @return mixed
     */
    public function createdBy();

    /**
     * Bannable model.
     *
     * @return \Cog\Contracts\Ban\Bannable
     */
    public function bannable();

    /**
     * Scope a query to only include bans by bannable model.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Cog\Contracts\Ban\Bannable $bannable
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereBannable(Builder $query, BannableContract $bannable);
}
