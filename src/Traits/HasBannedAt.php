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

use Carbon\Carbon;

/**
 * Class HasBannedAt.
 *
 * @package Cog\Ban\Traits
 */
trait HasBannedAt
{
    /**
     * Set banned flag.
     *
     * @return $this
     */
    public function setBannedFlag()
    {
        $this->banned_at = Carbon::now();

        return $this;
    }

    /**
     * Unset accepted flag.
     *
     * @return $this
     */
    public function unsetBannedFlag()
    {
        $this->banned_at = null;

        return $this;
    }

    /**
     * If model is banned.
     *
     * @return bool
     */
    public function isBanned()
    {
        return $this->banned_at !== null;
    }

    /**
     * If model is not banned.
     *
     * @return bool
     */
    public function isNotBanned()
    {
        return !$this->isBanned();
    }
}
