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
    return view('index/index');
});

Route::get('/article/{id}', 'Admin\ArticleCtrl@show');
Route::get('/category/{name}', 'Admin\CategoryCtrl@show');
Route::get('/test', 'Admin\IndexCtrl@ShowTestPage');

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
});

Route::group([
    'middleware' => ['admin.login', 'admin.usermgr'],
    'prefix' => 'admin',
    'namespace' => 'Admin',
], function () {

    // 添加/删除/修改用户信息
    Route::resource('user', 'UserCtrl', ['except' => ['show']]);

});

Route::group([
    'middleware' => ['admin.login', 'admin.sitemgr'],
    'prefix' => 'admin',
    'namespace' => 'Admin',
], function () {
    //发布修改
    Route::post('setting/publish', 'SettingCtrl@Publish');

    //显示当前网站配置
    Route::get('setting/modify', 'SettingCtrl@ShowModifySettingPage');

    // 修改当前网站配置
    Route::post('setting/modify', 'SettingCtrl@ModifySetting');

    // 添加/删除/修改站点配置
    Route::resource('setting', 'SettingCtrl', ['except' => ['show']]);

});

Route::group([
    'middleware' => ['admin.login', 'admin.articlemgr'],
    'prefix' => 'admin',
    'namespace' => 'Admin',
], function () {

    // 添加/删除文章分类
    Route::resource('category', 'CategoryCtrl', ['except' => ['show']]);
});

Route::group([
    'middleware' => ['admin.login', 'admin.articlecreate'],
    'prefix' => 'admin',
    'namespace' => 'Admin',
], function () {

    // 添加/删除文章分类
    Route::resource('article', 'ArticleCtrl', ['except' => 'show']);
});
