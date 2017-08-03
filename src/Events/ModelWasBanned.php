<?php

/*
 * This file is part of Laravel Ban.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Laravel\Ban\Events;

use Cog\Laravel\Ban\Contracts\Ban as BanContract;
use Cog\Laravel\Ban\Contracts\Bannable as BannableContract;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class ModelWasBanned.
 *
 * @package Cog\Laravel\Ban\Events
 */
class ModelWasBanned implements ShouldQueue
{
    /**
     * @var \Cog\Laravel\Ban\Contracts\Bannable
     */
    public $model;

    /**
     * @var \Cog\Laravel\Ban\Contracts\Ban
     */
    public $ban;

    /**
     * @param \Cog\Laravel\Ban\Contracts\Bannable $bannable
     * @param \Cog\Laravel\Ban\Contracts\Ban $ban
     */
    public function __construct(BannableContract $bannable, BanContract $ban)
    {
        $this->model = $bannable;
        $this->ban = $ban;
    }
}
