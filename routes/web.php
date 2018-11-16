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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//上传图片
$this->resource('photos','PhotoController')->only('store');

//后台路由
Route::prefix('admin')->namespace('Admin')->group(function (){
    $this->get('login', 'LoginController@showLoginForm')->name('admin.login');//后台登录
    $this->post('login', 'LoginController@login');
    $this->post('logout', 'LoginController@logout')->name('admin.logout');//后台退出
    Route::middleware('auth.admin:admin')->name('admin.')->group(function () {
        //后台首页
        $this->get('/', 'DashboardController@index');
        //酷站分类
        Route::prefix('site_nodes')->group(function () {
            $this->patch('change_sort', 'SiteNodeController@change_sort');//排序
            $this->post('destroy_checked', 'SiteNodeController@destroy_checked');//多选删除
        });
        $this->resource('site_nodes','SiteNodeController')->except('show', 'create');

        //酷站列表
        Route::prefix('site')->group(function () {
            $this->patch('change_attr', 'SiteController@change_attr');//改变属性
        });
        $this->resource('sites','SiteController')->except('show', 'create');

        //广告分类
        Route::prefix('advert_nodes')->group(function () {
            $this->patch('change_sort', 'AdvertNodeController@change_sort');//排序
            $this->post('destroy_checked', 'AdvertNodeController@destroy_checked');//多选删除
        });
        $this->resource('advert_nodes','AdvertNodeController')->except('show', 'create');

        //广告列表
        Route::prefix('advert')->group(function () {
            $this->patch('change_sort', 'AdvertController@change_sort');//排序
        });
        $this->resource('adverts','AdvertController')->except('show', 'create');
    });
});
