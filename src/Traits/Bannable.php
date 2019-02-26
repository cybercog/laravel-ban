<?php

/*
 * This file is part of Laravel Ban.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cog\Laravel\Ban\Traits;

trait Bannable
{
    use HasBannedAtHelpers;
    use HasBannedAtScope;
    use HasBansRelation;
}
