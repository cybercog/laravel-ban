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

/**
 * Interface BanService.
 *
 * @package Cog\Contracts\Ban
 */
interface BanService
{
    /**
     * Ban entity.
     *
     * @param \Cog\Contracts\Ban\Bannable $bannable
     * @param array $attributes
     * @return \Cog\Contracts\Ban\Ban
     */
    public function ban(BannableContract $bannable, array $attributes = []);

    /**
     * Unban entity.
     *
     * @param \Cog\Contracts\Ban\Bannable $bannable
     * @return void
     */
    public function unban(BannableContract $bannable);

    /**
     * Delete all expired Ban models.
     *
     * @return void
     */
    public function deleteExpiredBans();
}
