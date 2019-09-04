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

namespace Cog\Laravel\Ban\Traits;

use Cog\Contracts\Ban\Ban as BanContract;
use Cog\Contracts\Ban\BanService as BanServiceContract;
use Illuminate\Support\Carbon;

trait HasBannedAtHelpers
{
    /**
     * Set banned flag.
     *
     * @return $this
     */
    public function setBannedFlag()
    {
        $this->setAttribute('banned_at', Carbon::now());

        return $this;
    }

    /**
     * Unset banned flag.
     *
     * @return $this
     */
    public function unsetBannedFlag()
    {
        $this->setAttribute('banned_at', null);

        return $this;
    }

    /**
     * If model is banned.
     *
     * @return bool
     */
    public function isBanned(): bool
    {
        return $this->getAttributeValue('banned_at') !== null;
    }

    /**
     * If model is not banned.
     *
     * @return bool
     */
    public function isNotBanned(): bool
    {
        return !$this->isBanned();
    }

    /**
     * Ban model.
     *
     * @param null|array $attributes
     * @return \Cog\Contracts\Ban\Ban
     */
    public function ban(array $attributes = []): BanContract
    {
        return app(BanServiceContract::class)->ban($this, $attributes);
    }

    /**
     * Remove ban from model.
     *
     * @return void
     */
    public function unban(): void
    {
        app(BanServiceContract::class)->unban($this);
    }
}
