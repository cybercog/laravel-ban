<?php

/*
 * This file is part of Laravel Ban.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Laravel\Ban\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Class BannedAtScope.
 *
 * @package Cog\Laravel\Ban\Scopes
 */
class BannedAtScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = [
        'WithBanned',
        'WithoutBanned',
        'OnlyBanned',
    ];

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Builder $builder, Model $model)
    {
        if (method_exists($model, 'shouldApplyBannedAtScope') && $model->shouldApplyBannedAtScope()) {
            return $builder->whereNull('banned_at');
        }

        return $builder;
    }

    /**
     * Extend the query builder with the needed functions.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    public function extend(Builder $builder)
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }
    }

    /**
     * Add the `withBanned` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithBanned(Builder $builder)
    {
        $builder->macro('withBanned', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the `withoutBanned` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithoutBanned(Builder $builder)
    {
        $builder->macro('withoutBanned', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->whereNull('banned_at');
        });
    }

    /**
     * Add the `onlyBanned` extension to the builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addOnlyBanned(Builder $builder)
    {
        $builder->macro('onlyBanned', function (Builder $builder) {
            return $builder->withoutGlobalScope($this)->whereNotNull('banned_at');
        });
    }
}
