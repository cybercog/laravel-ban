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

namespace Cog\Laravel\Ban\Console\Commands;

use Cog\Laravel\Ban\Services\BanService;
use Illuminate\Console\Command;

class DeleteExpiredBans extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ban:delete-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete expired ban models.';

    /**
     * Ban service.
     *
     * @var \Cog\Contracts\Ban\BanService
     */
    protected $service;

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->service = app(BanService::class);

        $this->service->deleteExpiredBans();
    }
}
