<?php

namespace App\Model\DB;

use App\Lib\User as LibUser;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{

    public function GetAllUsersInfo()
    {
        return $this->select(['id', 'user', 'name', 'permission', 'created_at', 'updated_at'])
            ->get();
    }

    public function GetInfoByFieldUser($user)
    {
        return $this->where('user', $user)->first();
    }

    public function ResetAdmin()
    {
        $password = config('app.admin.password');
        $user = config('app.admin.user');

        $salt = config('app.key');

        $admin = self::firstOrNew(array('user' => $user));
        $admin->password = LibUser::HashPassword($password, $salt);
        $admin->name = config('app.admin.name');
        $admin->permission = LibUser::GenPermissionString([
            'UserMgr',
            'ArticleCreate',
            'ArticleLock']);

        $admin->save();
    }
}
