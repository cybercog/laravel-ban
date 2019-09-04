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

namespace Cog\Laravel\Ban\Events;

use Cog\Contracts\Ban\Ban as BanContract;
use Cog\Contracts\Ban\Bannable as BannableContract;
use Illuminate\Contracts\Queue\ShouldQueue;

class ModelWasBanned implements ShouldQueue
{
    /**
     * @var \Cog\Contracts\Ban\Bannable
     */
    public $model;

    /**
     * @var \Cog\Contracts\Ban\Ban
     */
    public $ban;

    /**
     * @param \Cog\Contracts\Ban\Bannable $bannable
     * @param \Cog\Contracts\Ban\Ban $ban
     */
    public function __construct(BannableContract $bannable, BanContract $ban)
    {
        $this->model = $bannable;
        $this->ban = $ban;
    }
}
