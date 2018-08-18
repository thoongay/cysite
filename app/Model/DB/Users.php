<?php

namespace App\Model\DB;

use App\Lib\Utils;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    public function ResetAdmin()
    {
        $password = config('app.admin.password');
        $user = config('app.admin.user');

        $salt = cofnig('app.key');

        $admin = self::firstOrNew(array('user' => $user));
        $admin->password = Utils::HashPassword($password, $salt);
        $admin->name = config('app.admin.name');
        $admin->permission =

        $adminr->save();
    }
}
