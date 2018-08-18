<?php

namespace Tests\Unit;

use App\Lib\User;
use App\Model\CustomException;
use Tests\TestCase;

class LibUser extends TestCase
{
    /*
    'UserMgr' => 0,
    'ArticleCreate' => 1,
    'ArticleLock' => 2,
     */

    public function testPermissionStr2Array()
    {
        $expect = ['UserMgr', 'ArticleCreate', 'ArticleLock'];
        $permission = User::GenPermissionString($expect);
        $permArr = User::PermissionStr2Array($permission);
        $this->assertEquals($expect, $permArr);
    }

    public function __construct()
    {
        parent::__construct();
    }

    public function setUp()
    {
        parent::setUp();
    }

    public function testAddRemovePermission()
    {
        $len = config('app.admin.permissionLen');

        $permission = User::GenPermissionString([]);
        $expect = str_repeat('0', $len);
        $this->assertEquals($expect, $permission);

        $permission = User::GenPermissionString([]);
        User::AddPermissions($permission, ['UserMgr']);
        $expect = User::GenPermissionString('UserMgr');
        $this->assertEquals($expect, $permission);

        $permission = User::GenPermissionString([]);
        User::AddPermissions($permission, ['UserMgr', 'ArticleCreate', 'ArticleLock']);
        User::RemovePermissions($permission, ['ArticleCreate']);
        $expect = User::GenPermissionString(['UserMgr', 'ArticleLock']);
        $this->assertEquals($expect, $permission);
    }

    public function testGenPermissionString_KeyNotExist()
    {
        $this->expectException(CustomException\KeyNotFoundException::class);
        User::GenPermissionString(['PermissionNotExist']);
    }

    public function testGenPermissionString_ArgumentError()
    {
        $this->expectException(CustomException\ArgumentException::class);
        User::GenPermissionString(123);
    }

    public function testGenPermissionStringy()
    {
        $len = config('app.admin.permissionLen');
        # array
        $expect = '11' . str_repeat('0', $len - 2);
        $permission = User::GenPermissionString(['UserMgr', 'ArticleCreate']);
        $this->assertEquals($expect, $permission);

        # string
        $expect = '010' . str_repeat('0', $len - 3);
        $permission = User::GenPermissionString('ArticleCreate');
        $this->assertEquals($expect, $permission);
    }

    public function testPassword()
    {
        $salt = "base64: Some random text for testing";
        $password = "the worst password";
        $hash = User::HashPassword($password, $salt);
        $verify = User::VerifyPassword($password, $salt, $hash);
        $this->assertEquals(true, $verify);
    }
}
