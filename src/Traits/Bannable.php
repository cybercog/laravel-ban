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

/**
 * Trait Bannable.
 *
 * @package Cog\Ban\Traits
 */
trait Bannable
{
    use HasBannedAtHelpers,
        HasBannedAtScope,
        HasBansRelation;
}
