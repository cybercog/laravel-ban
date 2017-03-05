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

use Cog\Ban\Contracts\CanBeBanned as CanBeBannedContract;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class ModelWasUnbanned.
 * 
 * @package Cog\Ban\Events
 */
class ModelWasUnbanned implements ShouldQueue
{
    /**
     * @var \Cog\Ban\Contracts\CanBeBanned
     */
    private $model;

    /**
     * @param \Cog\Ban\Contracts\CanBeBanned $model
     */
    public function __construct(CanBeBannedContract $model)
    {
        $this->model = $model;
    }
}
