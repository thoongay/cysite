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
        'ArticleLock' => 2,
    ];
    #endregion

    #region public method
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
        return $_permissions;
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

    public static function HashPassword($password, $salt)
    {
        $salted = self::AddSalt($password, $salt);
        $hash = self::GetSha512($salted);
        return Hash::make($hash);
    }

    public static function VerifyPassword($password, $salt, $hash)
    {
        $salted = self::AddSalt($password, $salt);
        $hashed = self::GetSha512($salted);
        return Hash::check($hashed, $hash);
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
            || strlen($permission) != config('app.admin.permissionLen')) {
            throw new CustomException\ArgumentException('Argument error.');
        }
    }

    private static function GenEmptyPermissionString()
    {
        return str_repeat("0", config('app.admin.permissionLen'));
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

    private static function AddSalt($password, $salt)
    {
        return $password . $salt;
    }

    private static function GetSha512($text)
    {
        return hash('sha512', $text);
    }
    #endregion
}
