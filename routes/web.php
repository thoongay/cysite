<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('welcome');
});

Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'middleware' => ['throttle:20'],
], function () {
    Route::get('captcha', 'LoginCtrl@GetCaptchaImg');
    Route::post('login', 'LoginCtrl@VerifyLogin');
    Route::get('login', function () {
        return view('admin.user.login');
    });
});

Route::group([
    'middleware' => ['admin.login'],
    'prefix' => 'admin',
    'namespace' => 'Admin',
], function () {

    Route::get('info', function () {
        return view('admin.user.info');
    });

    Route::get('logout', 'LoginCtrl@Logout');

    // 修改自己的密码
    Route::get('user/modify', 'UserCtrl@ShowViewModifyUserInfo');
    Route::post('user/modify', 'UserCtrl@ModifyUserInfo');

    // Route::get('changepassword', function () {
    //     return view('admin.changePassword');
    // });

    // Route::post('upload', 'Upload@upload');

    // Route::post('changepassword', 'Login@ChangePassword');

    // Route::resource('category', 'Category');

    // Route::resource('article', 'Article');
    // Route::resource('links', 'Links');

    // Route::post('cat/changeorder', 'Category@changeOrder');
    // Route::post('links/changeorder', 'Links@changeOrder');
});

Route::group([
    'middleware' => ['admin.login', 'admin.usermgr'],
    'prefix' => 'admin',
    'namespace' => 'Admin',
], function () {

    // 添加/删除/修改用户信息
    Route::resource('user', 'UserCtrl');
});
