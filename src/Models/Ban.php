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
use Cog\Ban\Contracts\HasBans as HasBansContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Ban.
 *
 * @package Cog\Ban\Models
 */
class Ban extends Model implements BanContract
{
    use SoftDeletes;

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
     * Owner of the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function ownedBy()
    {
        return $this->morphTo('owned_by');
    }

    /**
     * Get the model owner. Alias for `ownedBy()` method.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function owner()
    {
        return $this->ownedBy();
    }

    /**
     * Get the model owner. Alias for `ownedBy()` method.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function bannable()
    {
        return $this->ownedBy();
    }

    /**
     * Get the model owner.
     *
     * @return \Cog\Ownership\Contracts\CanBeOwner
     */
    public function getOwner()
    {
        return $this->ownedBy;
    }

    /**
     * Scope a query to only include models by owner.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Cog\Ban\Contracts\HasBans $bannable
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereOwnedBy(Builder $query, HasBansContract $bannable)
    {
        return $query->where([
            'owned_by_id' => $bannable->getKey(),
            'owned_by_type' => $bannable->getMorphClass(),
        ]);
    }
}
