<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', [
    'as' => 'profile', 'uses' => 'Admin\LoginController@index'
]);
Route::get('login/index', [
    'as' => 'profile', 'uses' => 'Admin\LoginController@index'
]);
Route::get("index/index",'Admin\IndexController@index');

Route::post('admin/login','Admin\LoginController@login');

Route::group(['middleware' =>"AdminLogin"], function () {
    //系统管理中人员管理路由
Route::get('system/index', 'Admin\SystemController@index');
Route::get('system/add', 'Admin\SystemController@add');
Route::post('systems/system/add', 'Admin\SystemController@add');
Route::get('system/update/{id}', 'Admin\SystemController@update');
Route::post('systems/system/update', 'Admin\SystemController@update');
Route::get('system/delete/{id}','Admin\SystemController@delete');
Route::get('system/edit/{id}','Admin\SystemController@edit');    
    
//系统管理中权限路由
Route::get('auth/index', 'Admin\AuthController@index');
Route::get('auth/assign/{id}', 'Admin\AuthController@assign');
Route::post('auth/edit', 'Admin\AuthController@edit');

//系统管理中角色路由
Route::get('role/index', 'Admin\RoleController@index');
Route::get('role/add', 'Admin\RoleController@add');
Route::post('systems/role/add', 'Admin\RoleController@add');
Route::post('systems/role/update', 'Admin\RoleController@update');
Route::get('role/update/{id}', 'Admin\RoleController@update');
Route::get('role/delete/{id}', 'Admin\RoleController@delete');
Route::post('role/getRoleName/', 'Admin\RoleController@getRoleName');

    
//系统管理中的密码修改路由
Route::get('login/wordEdit','Admin\LoginController@wordEdit');
Route::post('login/wordUpdate','Admin\LoginController@wordUpdate');


//会员管理中的发布方管理路由
Route::any('publish/index', 'Admin\PublishController@index');
Route::get('publish/detail/{id}', 'Admin\PublishController@detail');
Route::get('publish/export', 'Admin\PublishController@export');
Route::post('publish/update', 'Admin\PublishController@update');


//会员管理中的服务方管理路由
Route::any('service/index', 'Admin\ServiceController@index');
Route::get('service/detail/{id}', 'Admin\ServiceController@detail');
Route::get('service/export', 'Admin\ServiceController@export');
Route::post('service/update', 'Admin\ServiceController@update');
Route::any('service/upload', 'Admin\ServiceController@upload');
Route::post('service/handle', 'Admin\ServiceController@handle');
Route::post('service/editHandle', 'Admin\ServiceController@editHandle');

//会员管理中的审核发布信息路由
Route::any('check/index', 'Admin\CheckController@index');
Route::get('check/detail/{id}/{TypeID}', 'Admin\CheckController@detail');
Route::get('check/export', 'Admin\CheckController@export');
Route::post('check/update', 'Admin\CheckController@update');
Route::any('check/upload', 'Admin\CheckController@upload');
Route::post('check/handle', 'Admin\CheckController@handle');
Route::post('check/editHandle', 'Admin\CheckController@editHandle');

//合作管理中的订单管理路由
Route::any('order/index', 'Admin\OrderController@index');
Route::get('order/detail/{id}', 'Admin\OrderController@detail');
Route::get('order/export', 'Admin\OrderController@export');


//合作管理中的退单管理路由
Route::any('refuse/index', 'Admin\RefuseController@index');
Route::get('refuse/detail/{id}', 'Admin\RefuseController@detail');
Route::get('refuse/export', 'Admin\RefuseController@export');
Route::post('refuse/update', 'Admin\RefuseController@update');

//新闻视频中的新闻管理路由
Route::any('news/index', 'Admin\NewsController@index');
Route::get('news/add', 'Admin\NewsController@add');
Route::post('news/add/{id}', 'Admin\NewsController@save');
Route::get('news/update/{id}', 'Admin\NewsController@update');
Route::post('news/saveupdate/{id}', 'Admin\NewsController@saveupdate');
Route::get('news/delete/{id}', 'Admin\NewsController@delete');
Route::any('news/upload', 'Admin\NewsController@upload');
Route::any("news/editorUpload",'Admin\NewsController@editorUpload');

//新闻视频中的视频管理路由
Route::any('video/index', 'Admin\VideoController@index');
Route::get('video/add', 'Admin\VideoController@add');
Route::post('video/add/{id}', 'Admin\VideoController@save');
Route::get('video/update/{id}', 'Admin\VideoController@update');
Route::post('video/saveupdate/{id}', 'Admin\VideoController@saveupdate');
Route::get('video/delete/{id}', 'Admin\VideoController@delete');
Route::any('video/upload', 'Admin\VideoController@upload');
Route::any('video/bigupload', 'Admin\VideoController@bigupload');
Route::any('video/smallupload', 'Admin\VideoController@smallupload');

//推送管理中的推送信息路由
Route::any('push/index/{id?}', 'Admin\PushController@index');
Route::get('push/detail', 'Admin\PushController@detail');
Route::any("push/receive",'Admin\PushController@receive');
Route::any("push/message",'Admin\PushController@message');
Route::post("push/save",'Admin\PushController@save');
Route::post("push/sent",'Admin\PushController@sent');
Route::post("push/contant",'Admin\PushController@contant');
Route::post("push/title",'Admin\PushController@title');
Route::get("push/listDetail/{id}",'Admin\PushController@listDetail');
Route::post("push/receives",'Admin\PushController@receives');
Route::get("push/clear",'Admin\PushController@clear');
    
    //运维管理中的轮播图处理
Route::get("operate/index",'Admin\OperateController@index');
Route::any("operate/upload",'Admin\OperateController@upload');
    Route::post("operate/save",'Admin\OperateController@save');


});


