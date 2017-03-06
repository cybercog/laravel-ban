<?php

/*
 * This file is part of Laravel Ban.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Ban\Services;

use Carbon\Carbon;
use Cog\Ban\Contracts\BanService as BanServiceContract;
use Cog\Ban\Contracts\HasBans;
use Cog\Ban\Models\Ban;

/**
 * Class BanService.
 *
 * @package Cog\Ban\Services
 */
class BanService implements BanServiceContract
{
    /**
     * Ban entity.
     *
     * @param \Cog\Ban\Contracts\HasBans $bannable
     * @param array $attributes
     * @return \Cog\Ban\Contracts\Ban
     */
    public function ban(HasBans $bannable, array $attributes = [])
    {
        return $bannable->bans()->create($attributes);
    }

    /**
     * Unban entity.
     *
     * @param \Cog\Ban\Contracts\HasBans $bannable
     * @return void
     */
    public function unban(HasBans $bannable)
    {
        $bannable->bans->each(function ($ban) {
            $ban->delete();
        });
    }

    /**
     * Delete all expired Ban models.
     *
     * @return void
     */
    public function deleteExpiredBans()
    {
        $bans = Ban::where('expired_at', '<=', Carbon::now()->format('Y-m-d H:i:s'))->get();

        $bans->each(function ($ban) {
            $ban->delete();
        });
    }
}
