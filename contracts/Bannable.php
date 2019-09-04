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

interface Bannable
{
    /**
     * Ban model.
     *
     * @param null|array $attributes
     * @return \Cog\Contracts\Ban\Ban
     */
    public function ban(array $attributes = []): Ban;

    /**
     * Remove ban from model.
     *
     * @return void
     */
    public function unban(): void;

    /**
     * If model is banned.
     *
     * @return bool
     */
    public function isBanned(): bool;

    /**
     * If model is not banned.
     *
     * @return bool
     */
    public function isNotBanned(): bool;
}
