<?php

/*
 * This file is part of Laravel Ban.
 *
 * (c) Anton Komarev <anton@komarev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cog\Laravel\Ban\Services;

use Cog\Contracts\Ban\Ban as BanContract;
use Cog\Contracts\Ban\Bannable as BannableContract;
use Cog\Contracts\Ban\BanService as BanServiceContract;
use Cog\Laravel\Ban\Models\Ban;
use Illuminate\Support\Carbon;

class BanService implements BanServiceContract
{
    /**
     * Ban entity.
     *
     * @param \Cog\Contracts\Ban\Bannable $bannable
     * @param array $attributes
     * @return \Cog\Contracts\Ban\Ban
     */
    public function ban(BannableContract $bannable, array $attributes = []): BanContract
    {
        return $bannable->bans()->create($attributes);
    }

    /**
     * Unban entity.
     *
     * @param \Cog\Contracts\Ban\Bannable $bannable
     * @return void
     */
    public function unban(BannableContract $bannable): void
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
    public function deleteExpiredBans(): void
    {
        $bans = Ban::query()
            ->where('expired_at', '<=', Carbon::now()->format('Y-m-d H:i:s'))
            ->get();

        $bans->each(function ($ban) {
            $ban->delete();
        });
    }
}
