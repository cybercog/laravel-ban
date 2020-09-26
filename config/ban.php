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

return [

    /*
    |--------------------------------------------------------------------------
    | Ban Database Migrations
    |--------------------------------------------------------------------------
    |
    | Determine if default package migrations should be registered.
    | Set value to `false` when using customized migrations.
    |
    */

    'load_default_migrations' => true,

    /*
    |---------------------------------------------------------------------------
    | URL to redirect banned user to
    |---------------------------------------------------------------------------
    |
    | Provide a url, this is where a banned user will be redirected to
    | by the middleware.
    |
    | For example:
    |
    | 'redirect_url' => route('banned.user'),
    |
    | or
    |
    | 'redirect_url' => '/user/banned',
    |
    | Leaving the value as null will result in a redirect "back".
    |
    */

    'redirect_url' => null,

];
