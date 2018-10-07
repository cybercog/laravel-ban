<?php

/*
 * This file is part of Laravel Ban.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Laravel\Ban\Models;

use Carbon\Carbon;
use Cog\Contracts\Ban\Ban as BanContract;
use Cog\Contracts\Ban\Bannable as BannableContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Ban.
 *
 * @package Cog\Laravel\Ban\Models
 */
class Ban extends Model implements BanContract
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bans';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comment',
        'expired_at',
        'created_by_type',
        'created_by_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'expired_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Expired timestamp mutator.
     *
     * @param \Carbon\Carbon|string $value
     * @return void
     */
    public function setExpiredAtAttribute($value)
    {
        if (!is_null($value) && !$value instanceof Carbon) {
            $value = Carbon::parse($value);
        }

        $this->attributes['expired_at'] = $value;
    }

    /**
     * Determine if Ban is permanent.
     *
     * @return bool
     */
    public function isPermanent()
    {
        return !isset($this->attributes['expired_at']) || is_null($this->attributes['expired_at']);
    }

    /**
     * Determine if Ban is temporary.
     *
     * @return bool
     */
    public function isTemporary()
    {
        return !$this->isPermanent();
    }

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
     * Bannable model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function bannable()
    {
        return $this->morphTo('bannable');
    }

    /**
     * Scope a query to only include models by owner.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Cog\Contracts\Ban\Bannable $bannable
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereBannable(Builder $query, BannableContract $bannable)
    {
        return $query->where([
            'bannable_type' => $bannable->getMorphClass(),
            'bannable_id' => $bannable->getKey(),
        ]);
    }
}
