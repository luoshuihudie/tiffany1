<?php

use Illuminate\Support\Facades\Route;

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

#Route::get('/', function () {
 #   return view('welcome');
#});
Route::get('/', "Admin\IndexController@index")->name('admin');

Route::group(['namespace' => 'Admin', 'prefix' => 'website'], function(){
    //栏目管理
    Route::get('menu/index',"MenuController@index")->name('website.menu.index');
    //添加菜单-界面
    Route::get('menu/add',"MenuController@add")->name('website.menu.add');
    //添加菜单操作
    Route::post('menu/create',"MenuController@create")->name('website.menu.create');
    //修改菜单-界面
    Route::get('menu/edit/{id}',"MenuController@edit")->name('website.menu.edit');
    //修改菜单
    Route::post('menu/update',"MenuController@update")->name('website.menu.update');
    //删除菜单
    Route::post('menu/del',"MenuController@del")->name('website.menu.del');
});
