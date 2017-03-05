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

use Cog\Ban\Contracts\CanBeBanned as CanBeBannedContract;

/**
 * Interface BanService.
 *
 * @package Cog\Ban\Contracts
 */
interface BanService
{
    /**
     * Ban entity.
     *
     * @param \Cog\Ban\Contracts\CanBeBanned $bannable
     * @param array $attributes
     * @return \Cog\Ban\Contracts\Ban
     */
    public function ban(CanBeBannedContract $bannable, array $attributes = []);

    /**
     * Unban entity.
     *
     * @param \Cog\Ban\Contracts\CanBeBanned $bannable
     * @return void
     */
    public function unban(CanBeBannedContract $bannable);

    /**
     * Delete all expired Ban models.
     *
     * @return void
     */
    public function deleteExpiredBans();
}
