<?php

/*
 * This file is part of Laravel Ban.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Laravel\Ban\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

/**
 * Class ForbidBannedUser.
 *
 * @package Cog\Laravel\Ban\Http\Middleware
 */
class ForbidBannedUser
{
    /**
     * The Guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $auth;

    /**
     * @param \Illuminate\Contracts\Auth\Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        $user = $this->auth->user();

        if ($user && $user->isBanned()) {
            return redirect()->back()->withInput()->withErrors([
                'login' => 'This account is blocked.',
            ]);
        }

        return $next($request);
    }
}
