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

    Route::resource('user', 'UserCtrl');

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
