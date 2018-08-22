<?php

namespace App\Http\Middleware\Admin;

use App\Lib\User as LibUser;
use Closure;

class UploadGuard
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
        $upload = config('ueditor.upload');
        $storage = app('ueditor.storage');

        switch ($request->get('action')) {
            case 'config':
            case $upload['imageManagerActionName']:
            case $upload['fileManagerActionName']:
                return $next($request);
        }

        if ((LibUser::VerifyPermissions(session('perm'), 'ArticleCreate'))) {
            return $next($request);
        }

        return response()->json(['state' => '无权上传']);
    }
}
