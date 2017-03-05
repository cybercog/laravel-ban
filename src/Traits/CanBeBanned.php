<?php

/*
 * This file is part of Laravel Ban.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Ban\Traits;

use Carbon\Carbon;
use Cog\Ban\Contracts\Ban as BanContract;
use Cog\Ban\Contracts\BanService as BanServiceContract;

/**
 * Class CanBeBanned.
 *
 * @package Cog\Ban\Traits
 */
trait CanBeBanned
{
    use HasBannedAt;

    /**
     * Entity Bans.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function bans()
    {
        return $this->morphMany(app(BanContract::class), 'owned_by');
    }

    /**
     * Ban model.
     *
     * @param null|array $attributes
     * @return \Cog\Ban\Contracts\Ban
     */
    public function ban(array $attributes = [])
    {
        $ban = app(BanServiceContract::class)->ban($this, $attributes);

        return $ban;
    }

    /**
     * Remove ban from model.
     *
     * @return void
     */
    public function unban()
    {
        app(BanServiceContract::class)->unban($this);
    }
}
