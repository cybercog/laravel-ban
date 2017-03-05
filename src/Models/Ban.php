<?php

/*
 * This file is part of Laravel Ban.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Ban\Models;

use Carbon\Carbon;
use Cog\Ban\Contracts\Ban as BanContract;
use Cog\Ownership\Traits\HasMorphOwner;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Ban.
 *
 * @package Cog\Ban\Models
 */
class Ban extends Model implements BanContract
{
    use HasMorphOwner,
        SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ban';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comment',
        'expired_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'expired_at' => 'datetime',
    ];

    /**
     * Entity responsible for ban.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function createdBy()
    {
        return $this->morphTo('created_by');
    }

    /**
     * Expired timestamp mutator.
     *
     * @param \Carbon\Carbon|string $value
     */
    public function setExpiredAtAttribute($value)
    {
        if (!$value instanceof Carbon) {
            $value = Carbon::parse($value);
        }

        $this->attributes['expired_at'] = $value;
    }
}
