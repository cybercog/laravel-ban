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

use Cog\Ban\Contracts\CanBeBanned as CanBeBannedContract;
use Cog\Ban\Traits\CanBeBanned;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User.
 *
 * @package Cog\Ban\Tests\Stubs\Models
 */
class User extends Authenticatable implements CanBeBannedContract
{
    use CanBeBanned;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
}
