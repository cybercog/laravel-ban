<?php

/*
 * This file is part of Laravel Ban.
 *
 * (c) Anton Komarev <anton@komarev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cog\Tests\Laravel\Ban\Stubs\Models;

class UserWithBannedAtScopeApplied extends User
{
    /**
     * Determine which BannedAtScope should be applied by default.
     *
     * @return bool
     */
    public function shouldApplyBannedAtScope(): bool
    {
        return true;
    }
}
