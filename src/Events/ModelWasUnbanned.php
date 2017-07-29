<?php

/*
 * This file is part of Laravel Ban.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Ban\Events;

use Cog\Ban\Contracts\Bannable as BannableContract;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class ModelWasUnbanned.
 *
 * @package Cog\Ban\Events
 */
class ModelWasUnbanned implements ShouldQueue
{
    /**
     * @var \Cog\Ban\Contracts\Bannable
     */
    public $model;

    /**
     * @param \Cog\Ban\Contracts\Bannable $model
     */
    public function __construct(BannableContract $model)
    {
        $this->model = $model;
    }
}
