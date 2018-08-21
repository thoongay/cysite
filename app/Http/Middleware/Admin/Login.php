<?php

namespace App\Http\Middleware\Admin;

use App\Lib\User as LibUser;
use App\Lib\Utils;
use App\Model\DB\Users;
use Closure;

class Login
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
        $ip = $request->ip();
        $users = new Users();
        $user = null;

        // 每次请求都查数据库,是否过于频繁
        $account = session('user');
        if ($account == null) {
            $token = LibUser::GetTokenFromCookie($request);
            $user = $users->GetInfoByFieldToken($token);
            if ($user != null) {
                Utils::Log('Verify by Token.', $ip);
            }
        } else {
            $user = $users->GetInfoByFieldUser($account);
        }

        if ($user == null) {
            return redirect('admin\login');
        }

        $newToken = $users->Login($user, false);
        if ($newToken == null) {
            return $next($request);
        } else {
            return $next($request)->withCookie(LibUser::GenTokenCookie($newToken));
        }
    }

}
