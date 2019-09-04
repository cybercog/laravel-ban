<?php

/*
 * This file is part of PHP Contracts: Ban.
 *
 * (c) Anton Komarev <anton@komarev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cog\Contracts\Ban;

interface BanService
{
    /**
     * Ban entity.
     *
     * @param \Cog\Contracts\Ban\Bannable $bannable
     * @param array $attributes
     * @return \Cog\Contracts\Ban\Ban
     */
    public function ban(Bannable $bannable, array $attributes = []): Ban;

    /**
     * Unban entity.
     *
     * @param \Cog\Contracts\Ban\Bannable $bannable
     * @return void
     */
    public function unban(Bannable $bannable): void;

    /**
     * Delete all expired Ban models.
     *
     * @return void
     */
    public function deleteExpiredBans(): void;
}
