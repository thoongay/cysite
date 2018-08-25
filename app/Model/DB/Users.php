<?php

namespace App\Model\DB;

use App\Lib\User as LibUser;
use App\Lib\Utils;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Users extends Model
{

    protected $fillable = ['user', 'name', 'password', 'permission', 'token', 'tkupdate'];

    #region public method
    public function GetIdByFieldUser($user)
    {
        $record = $this->where(['user' => $user])->first();
        if ($record == null) {
            return 0;
        } else {
            return $record->id;
        }
    }

    public function Login($user, $updateToken = false)
    {
        $token = null;

        // check token update
        if (LibUser::IsTokenOutOfDate($user->tkupdate)) {
            Utils::Log('Token need update.');
            $updateToken = true;
        }

        if ($updateToken == true) {
            $token = LibUser::GenToken();
            $user->token = $token;
            $user->tkupdate = Utils::Now();
            $user->update();
        }

        session([
            'user' => $user->user,
            'name' => $user->name,
            'perm' => $user->permission,
        ]);

        return $token;
    }

    public function Logout()
    {
        $user = $this->GetInfoByFieldUser(session('user'));
        if ($user == null) {
            return;
        }
        $user->token = LibUser::GenToken();
        $user->update();
        session(['user' => null]);
    }

    public function AddUser($post)
    {
        $user = [];
        $permissions = array_key_exists('permissions', $post) ? $post['permissions'] : [];
        $user['permission'] = LibUser::GenPermissionString($permissions);

        foreach (['user', 'name'] as $key) {
            $user[$key] = $post[$key];
        }

        $user['password'] = Hash::make($post['password']);

        $token = LibUser::GenToken();
        $user['token'] = $token;

        $user['tkupdate'] = Utils::Now();
        $this->create($user);
    }

    public function GetAllUsersName()
    {
        $users = $this->select(['id', 'name'])->get();

        $names = [];
        foreach ($users as $user) {
            $names[$user->id] = $user->name;
        }
        return $names;
    }

    public function GetAllUsersInfo()
    {
        return $this->select(['id', 'user', 'name', 'permission', 'created_at', 'updated_at'])
            ->get();
    }

    public function IsUserExisted($user, $name = '')
    {
        if ($this->where('user', $user)->exists()
            || $this->where('name', $name)->exists()) {
            return true;
        }

        return false;
    }

    public function GetInfoByFieldUser($user)
    {
        return $this->where('user', $user)->first();
    }

    public function GetInfoByFieldToken($token)
    {
        return $this->where('token', $token)->first();
    }

    public function ResetAdmin()
    {
        $password = config('app.admin.password');
        $user = config('app.admin.user');

        $admin = self::firstOrNew(array('user' => $user));
        $admin->password = Hash::make($password);
        $admin->name = config('app.admin.name');
        $admin->permission = LibUser::GenPermissionString([
            'UserMgr', 'SiteMgr', 'ArticleCreate', 'ArticleMgr']);

        $admin->token = LibUser::GenToken();
        $admin->tkupdate = Utils::Now();

        $admin->save();
    }
    #endregion

    #region private method
    #endregion
}
