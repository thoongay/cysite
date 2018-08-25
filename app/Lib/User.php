<?php

namespace App\Lib;

use App\Model\CustomException;
use Illuminate\Support\Facades\Hash;

class User
{
    #region property
    private static $_permissions = [
        'UserMgr' => 0,
        'ArticleCreate' => 1,
        'ArticleMgr' => 2,
        'SiteMgr' => 3,
    ];
    #endregion

    #region public method
    public static function IsTokenOutOfDate($tkupdate)
    {
        $seconds = abs((new \DateTime($tkupdate))->getTimestamp() - (new \DateTime)->getTimestamp());
        //  debug: Utils::Log('IsTokenOutOfDate seconds:' . $seconds);
        return $seconds / 60 > config('app.admin.tokenUpdateTime');
    }

    public static function GenTokenCookie($token)
    {
        return cookie('token', $token, config('app.admin.tokenLifeTime'));
    }

    public static function GetTokenFromCookie($request)
    {
        return $request->cookie('token');
    }

    public static function GenToken($len = null)
    {
        $defLen = config('app.admin.tokenLen');

        if ($len == null) {
            $len = $defLen;
        }

        $result = date('Ymdhis');
        $patch = $len - strlen($result);
        if ($patch <= 0 || $len > $defLen) {
            throw new CustomException\ArgumentException('Argument out of range!');
        }

        return $result . str_random($patch);
    }

    public static function GetReadablePermissions($permissionStr)
    {
        $perms = [];
        try {
            $perms = self::PermissionStr2Array($permissionStr);
        } catch (\Exception $e) {}

        return implode(' | ', $perms);
    }

    public static function GetAllPermissions()
    {
        return self::$_permissions;
    }

    public static function VerifyPermissions($permString, $perms)
    {
        try {
            if (is_string($perms)) {
                return self::VerifyPermission($permString, $perms);
            }

            if (is_array($perms)) {
                foreach ($perms as $perm) {
                    if (!(self::VerifyPermission($permString, $perm))) {
                        return false;
                    }
                }
                return true;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function PermissionStr2Array($permission)
    {

        self::VerifyPermissionLength($permission);

        $size = count(self::$_permissions);
        $result = [];
        for ($i = 0; $i < $size; $i++) {
            $v = intval($permission[$i]);
            if ($v == 1) {
                $result[] = array_search($i, self::$_permissions);
            }
        }

        return $result;
    }

    public static function AddPermissions(&$curPermission, $permissions)
    {
        if (is_string($permissions)) {
            self::AddPermission($curPermission, $permissions);
            return;
        }

        if (is_array($permissions)) {
            foreach ($permissions as $permission) {
                self::AddPermission($curPermission, $permission);
            }
            return;
        }

        throw new CustomException\ArgumentException('Argument error.');
    }

    public static function RemovePermissions(&$curPermission, $permissions)
    {
        if (is_string($permissions)) {
            self::RemovePermission($curPermission, $permissions);
            return;
        }

        if (is_array($permissions)) {
            foreach ($permissions as $permission) {
                self::RemovePermission($curPermission, $permission);
            }
            return;
        }

        throw new CustomException\ArgumentException('Argument error.');
    }

    public static function GenPermissionString($permissions)
    {
        $result = self::GenEmptyPermissionString();
        self::AddPermissions($result, $permissions);
        return $result;
    }

    public static function GetPermisionStrLen()
    {
        return config('app.admin.permissionLen');
    }

    #endregion

    #region private method
    private static function VerifyPermission($permString, $perm)
    {
        self::VerifyPermissionLength($permString);
        $index = self::GetPermissionIndex($perm);
        if ($permString[$index] == '1') {
            return true;
        }
        return false;
    }

    private static function VerifyPermissionLength($permission)
    {
        if (!is_string($permission)
            || strlen($permission) != self::GetPermisionStrLen()) {
            throw new CustomException\ArgumentException('Argument error.');
        }
    }

    private static function GenEmptyPermissionString()
    {
        return str_repeat("0", self::GetPermisionStrLen());
    }

    private static function AddPermission(&$curPermission, $newPermission)
    {
        self::VerifyPermissionLength($curPermission);
        $index = self::GetPermissionIndex($newPermission);
        $curPermission[$index] = '1';
    }

    private static function RemovePermission(&$curPermission, $newPermission)
    {
        self::VerifyPermissionLength($curPermission);
        $index = self::GetPermissionIndex($newPermission);
        $curPermission[$index] = '0';
    }

    private static function GetPermissionIndex($permission)
    {
        if (array_key_exists($permission, self::$_permissions)) {
            return self::$_permissions[$permission];

        }
        throw new CustomException\KeyNotFoundException('key not found!');
    }

    private static function GetSha512($text)
    {
        return hash('sha512', $text);
    }
    #endregion
}
