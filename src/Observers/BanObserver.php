<?php

/*
 * This file is part of Laravel Ban.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Ban\Observers;

use Cog\Ban\Contracts\Ban as BanContract;
use Cog\Ban\Events\ModelWasBanned;
use Cog\Ban\Events\ModelWasUnbanned;

/**
 * Class BanObserver.
 *
 * @package Cog\Ban\Observers
 */
class BanObserver
{
    /**
     * Handle the creating event for the Ban model.
     *
     * @param \Cog\Ban\Contracts\Ban $ban
     * @return void
     */
    public function creating(BanContract $ban)
    {
        $bannedBy = auth()->user();
        if ($bannedBy) {
            $ban->forceFill([
                'created_by_id' => $bannedBy->getKey(),
                'created_by_type' => $bannedBy->getMorphClass(),
            ]);
        }
    }

    /**
     * Handle the created event for the Ban model.
     *
     * @param \Cog\Ban\Contracts\Ban $ban
     * @return void
     */
    public function created(BanContract $ban)
    {
        $banOwner = $ban->owner;
        $banOwner->setBannedFlag($ban->created_at)->save();

        event(new ModelWasBanned($banOwner, $ban));
    }

    /**
     * Handle the deleted event for the Ban model.
     *
     * @param \Cog\Ban\Contracts\Ban $ban
     * @return void
     */
    public function deleted(BanContract $ban)
    {
        $banOwner = $ban->owner;
        if ($banOwner->bans->count() === 0) {
            $banOwner->unsetBannedFlag()->save();

            event(new ModelWasUnbanned($banOwner));
        }
    }
}
