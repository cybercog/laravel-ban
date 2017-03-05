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

use Cog\Ownership\Contracts\HasOwner as HasOwnerContract;

/**
 * Interface Ban.
 *
 * @package Cog\Ban\Contracts
 */
interface Ban extends HasOwnerContract
{
    /**
     * Entity responsible for ban.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function createdBy();
}
