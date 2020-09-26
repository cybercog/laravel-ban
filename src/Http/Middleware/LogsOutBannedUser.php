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
use Illuminate\Contracts\Auth\StatefulGuard as StatefulGuardContract;

class LogsOutBannedUser
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
        $redirect_url = config('ban.redirect_url', null);
        $errors = [
            'login' => 'This account is blocked.',
        ];

        if ($user && $user instanceof BannableContract && $user->isBanned()) {
            if ($this->auth instanceof StatefulGuardContract) {
                // TODO: Cover with tests
                $this->auth->logout();
            }
            
            f($redirect_url === null){
                return redirect()->back()->withInput()->withErrors($errors);
            }
            else{
                return redirect($redirect_url)->withInput()->withErrors($errors);
            }
        }

        return $next($request);
    }
}
