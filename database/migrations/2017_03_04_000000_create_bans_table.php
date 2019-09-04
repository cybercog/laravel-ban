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

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('bans', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('bannable');
            $table->nullableMorphs('created_by');
            $table->text('comment')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index('expired_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('bans');
    }
}
