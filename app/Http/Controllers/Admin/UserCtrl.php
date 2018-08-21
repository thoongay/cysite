<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Lib\UI as LibUI;
use App\Lib\User as LibUser;
use App\Lib\Utils;
use App\Model\DB\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserCtrl extends Controller
{
    // 显示用户修改自己的信息页面
    public function ShowViewModifyUserInfo()
    {
        return view('admin.user.modify');
    }

    public function ModifyUserInfo(Request $request, Users $users)
    {
        $post = $request->post();
        $ip = $request->ip();

        $rules = [
            'old_password' => 'required',
            'password' => 'required|between:6,100|confirmed',
        ];

        $errors = [
            'old_password.required' => '原密码不能为空',
            'password.required' => '新密码不能为空',
            'password.between' => '新密码应为6-100位之间',
            'password.confirmed' => '新密码和确认密码不符',
        ];

        $validator = Validator::make($post, $rules, $errors);

        if ($validator->passes()) {
            $user = $users->GetInfoByFieldUser(session('user'));

            if ($user == null) {
                Utils::Log('修改用户密码 - 用户不存在', $ip);
                return back()->withErrors('用户不存在');
            }

            if (!Hash::check($post['old_password'], $user->password)) {
                Utils::Log('修改用户密码 - 原密码错误', $ip);
                return back()->withErrors('原密码错误');
            }

            $token = LibUser::GenToken();
            $user->password = Hash::make($post['password']);
            $user->token = $token;
            $user->tkupdate = Utils::Now();

            $user->update();

            return back()->withErrors('修改成功')
                ->withCookie(LibUser::GenTokenCookie($token));
        }

        return back()->withErrors($validator);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Users $users)
    {
        $data = $users->GetAllUsersInfo();
        return view('admin.user.list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/user/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Users $users)
    {
        $view = 'admin/user/create';

        $post = $request->post();
        $ip = $request->ip();

        $rules = [
            'password' => 'required|between:6,100|confirmed',
            'user' => 'required|between:4,100',
            'name' => 'required|between:4,100',
        ];

        $errors = [
            'user.required' => '账号不能为空',
            'name.required' => '用户名不能为空',
            'password.required' => '密码不能为空',
            'password.between' => '密码应为6-100位之间',
            'password.confirmed' => '密码和确认密码不符',
        ];

        $validator = Validator::make($post, $rules, $errors);

        if ($validator->passes()) {
            if ($users->IsUserExisted($post['user'], $post['name'])) {
                return LibUI::errors($view, '已存在相同用户');
            }

            Utils::Log('添加用户' . $post['user'], $ip);
            $users->AddUser($post);
            return back()->withErrors('添加成功');
        }

        return back()->withErrors($validator);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\DB\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function show(Users $users)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\DB\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function edit(Users $users, $id)
    {
        $user = $users->where(['id' => $id])->first();
        $data = Utils::CopyArray($user, ['id', 'user', 'name', 'permission']);

        return view('admin.user.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\DB\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Users $users, $id)
    {
        $post = $request->post();
        $ip = $request->ip();

        $rules = [
            'user' => 'required',
            'name' => 'required',
        ];

        $errors = [
            'user.required' => '账号不能为空',
            'name.required' => '名字不能为空',
        ];

        $validator = Validator::make($post, $rules, $errors);

        if ($validator->passes()) {
            $user = $users->where(['id' => $id])->first();

            if ($user == null) {
                Utils::Log('修改用户信息 - 用户不存在', $ip);
                return back()->withErrors('用户不存在');
            }

            if ($post['password'] != null) {
                $user->password = Hash::make($post['password']);
            }

            $permissions = array_key_exists('permissions', $post) ? $post['permissions'] : [];
            $user['permission'] = LibUser::GenPermissionString($permissions);

            $user['user'] = $post['user'];
            $user['name'] = $post['name'];
            $user->update();

            Utils::Log('修改用户信息' . $user['id'] . '.' . $user['user'], $ip);
            return back()->withErrors('修改成功');
        }

        return back()->withErrors($validator);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\DB\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function destroy(Users $users, Request $request, $id)
    {
        $ip = $request->ip();
        $result = $users->where('id', $id);
        $info = $result->first();
        $user = $info->user;
        $result->delete();

        if ($result) {
            $msg = ['status' => true, 'msg' => '删除成功'];
            Utils::Log("删除用户$id $user 成功", $ip);
        } else {
            $msg = ['status' => false, 'msg' => '删除失败'];
            Utils::Log("删除用户$id $user 失败", $ip);
        }
        return $msg;
    }
}
