<?php

/*
 * This file is part of Laravel Ban.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Ban\Tests\Stubs\Models;

use Cog\Ban\Contracts\HasBans as HasBansContract;
use Cog\Ban\Traits\HasBans;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class UserWithBannedAtScopeApplied.
 *
 * @package Cog\Ban\Tests\Stubs\Models
 */
class UserWithBannedAtScopeApplied extends User
{
    /**
     * Determine which BannedAtScope should be applied by default.
     *
     * @return bool
     */
    public function shouldApplyBannedAtScope()
    {
        return true;
    }
}
