<?php

namespace App\Model\DB;

use App\Lib\User as LibUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Users extends Model
{

    protected $fillable = ['user', 'name', 'password', 'permission'];

    #region public method
    public function AddUser($post)
    {
        $user = [];
        $permissions = array_key_exists('permissions', $post) ? $post['permissions'] : [];
        $user['permission'] = LibUser::GenPermissionString($permissions);

        foreach (['user', 'name'] as $key) {
            $user[$key] = $post[$key];
        }

        $user['password'] = Hash::make($post['password']);

        $this->create($user);
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

    public function ResetAdmin()
    {
        $password = config('app.admin.password');
        $user = config('app.admin.user');

        $admin = self::firstOrNew(array('user' => $user));
        $admin->password = Hash::make($password);
        $admin->name = config('app.admin.name');
        $admin->permission = LibUser::GenPermissionString([
            'UserMgr',
            'ArticleCreate',
            'ArticleLock']);

        $admin->save();
    }
    #endregion

    #region private method
    #endregion
}
