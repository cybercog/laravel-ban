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

namespace Cog\Laravel\Ban\Http\Middleware;

use Closure;
use Cog\Contracts\Ban\Bannable as BannableContract;
use Illuminate\Contracts\Auth\Guard;

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
     *
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        $user = $this->auth->user();

        if ($user && $user instanceof BannableContract && $user->isBanned()) {
            $redirectUrl = config('ban.redirect_url', null);
            $errors = [
                'login' => 'This account is blocked.',
            ];

            $responseCode = $request->header('X-Inertia') ? 303 : 302;
            if ($redirectUrl === null) {
                return redirect()->back($responseCode)->withInput()->withErrors($errors);
            } else {
                return redirect($redirectUrl, $responseCode)->withInput()->withErrors($errors);
            }
        }

        return $next($request);
    }
}
