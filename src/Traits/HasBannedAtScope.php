<?php

/*
 * This file is part of Laravel Ban.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Laravel\Ban\Traits;

use Cog\Laravel\Ban\Scopes\BannedAtScope;

/**
 * Trait HasBannedAtScope.
 *
 * @package Cog\Laravel\Ban\Traits
 */
trait HasBannedAtScope
{
    /**
     * Boot the HasBannedAtScope trait for a model.
     *
     * @return void
     */
    public static function bootHasBannedAtScope()
    {
        static::addGlobalScope(new BannedAtScope);
    }
}
