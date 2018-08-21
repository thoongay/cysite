<?php

namespace App\Http\Middleware\Admin;

use App\Lib\User as LibUser;
use Closure;

class ArticleMgr
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!(LibUser::VerifyPermission(session('perm'), 'ArticleMgr'))) {
            return redirect('errors/404');
        }

        return $next($request);
    }
}
