<?php

/*
 * This file is part of Laravel Ban.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Ban\Contracts;

use Cog\Ban\Contracts\HasBans as HasBansContract;
use Illuminate\Database\Eloquent\Builder;

/**
 * Interface Ban.
 *
 * @package Cog\Ban\Contracts
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
     * Owner of the model.
     *
     * @return mixed
     */
    public function ownedBy();

    /**
     * Get the model owner. Alias for `ownedBy()` method.
     *
     * @return \Cog\Ban\Contracts\HasBans
     */
    public function owner();

    /**
     * Get the model owner.
     *
     * @return \Cog\Ban\Contracts\HasBans
     */
    public function getOwner();

    /**
     * Scope a query to only include bans by bannable model.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Cog\Ban\Contracts\HasBans $bannable
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereOwnedBy(Builder $query, HasBansContract $bannable);
}
