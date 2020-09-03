<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Admin', 'prefix' => 'v1'], function(){
    //获取某一个菜单
    Route::get('menu/info',"MenuController@info")->name('api.menu.info');

    //菜单树状结构
    Route::get('menu/lists',"MenuController@lists")->name('api.menu.lists');

    Route::get('config/lists',"BaseController@lists")->name('api.config.lists');

    //友情链接列表
    Route::get('links/lists',"LinksController@lists")->name('admin.links.lists');

    Route::get('setting/lists',"SettingController@lists")->name('admin.setting.lists');
});
