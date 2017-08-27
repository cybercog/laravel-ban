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
 * Interface Bannable.
 *
 * @package Cog\Contracts\Ban
 */
interface Bannable
{
    /**
     * Get the value of the model's primary key.
     *
     * @return mixed
     */
    public function getKey();

    /**
     * Get the class name for polymorphic relations.
     *
     * @return string
     */
    public function getMorphClass();

    /**
     * Entity Bans.
     *
     * @return mixed
     */
    public function bans();

    /**
     * Set banned flag.
     *
     * @return $this
     */
    public function setBannedFlag();

    /**
     * Unset banned flag.
     *
     * @return $this
     */
    public function unsetBannedFlag();

    /**
     * Ban model.
     *
     * @param null|array $attributes
     * @return \Cog\Contracts\Ban\Ban
     */
    public function ban(array $attributes = []);

    /**
     * Remove ban from model.
     *
     * @return void
     */
    public function unban();

    /**
     * If model is banned.
     *
     * @return bool
     */
    public function isBanned();

    /**
     * If model is not banned.
     *
     * @return bool
     */
    public function isNotBanned();
}
