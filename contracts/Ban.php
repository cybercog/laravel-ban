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

interface Ban
{
    /**
     * Determine if Ban is permanent.
     *
     * @return bool
     */
    public function isPermanent(): bool;

    /**
     * Determine if Ban is temporary.
     *
     * @return bool
     */
    public function isTemporary(): bool;
}
