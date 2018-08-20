<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Lib\UI as LibUI;
use App\Lib\Utils;
use App\Model\DB\Users as DBUsers;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginCtrl extends Controller
{
    private $captchaKey = 'loginVerifyCode';

    public function Logout()
    {
        Utils::Log('退出登录');
        session(['user' => null]);
        return redirect('admin/login');
    }

    public function VerifyLogin(Request $request)
    {
        $ip = $request->ip();
        $view = 'admin.user.login';
        $post = $request->post();

        if (!config('app.debug') &&
            !Utils::StrEqual($post['captcha'], $this->GetCaptchaCode())) {
            return LibUI::errors($view, '验证码错误');
        }

        $user = (new DBUsers)->GetInfoByFieldUser($post['user']);
        if ($user === null) {
            Utils::Log('登录.用户不存在' . $post['user'], $ip);
            return LibUI::errors($view, '用户不存在');
        }

        if (!(Hash::check($post['password'], $user->password))) {
            Utils::Log('登录.密码错误' . $post['user'], $ip);
            return LibUI::errors($view, '密码错误');
        }

        session([
            'user' => $user->user,
            'name' => $user->name,
            'perm' => $user->permission,
        ]);

        Utils::Log('登录', $ip);
        return redirect('admin\info');
    }

    public function GetCaptchaImg()
    {
        $builder = new CaptchaBuilder();
        $builder->build($width = 84, $height = 26); //自定义图片宽高
        session([$this->captchaKey => $builder->getPhrase()]); //将验证码存入session，方便登陆验证
        header("Cache-Control: no-cache, must-revalidate");
        header('Content-Type: image/jpeg');
        $builder->output();
    }

    public function GetCaptchaCode()
    {
        return session($this->captchaKey);
    }
}
