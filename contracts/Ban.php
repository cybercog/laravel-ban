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
     * Determine if Ban is permanent.
     *
     * @return bool
     */
    public function isPermanent();

    /**
     * Determine if Ban is temporary.
     *
     * @return bool
     */
    public function isTemporary();
}
