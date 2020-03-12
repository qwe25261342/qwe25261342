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

Route::get('/', 'FrontController@index');

Route::get('/news', 'FrontController@news'); //List Page
Route::get('/news/{id}', 'FrontController@news_detail'); //Content Page
Route::get('/product', 'FrontController@product');
Route::get('/cart', 'FrontController@cart');

Auth::routes();

Route::group(['middleware' => ['auth'],'prefix' => 'home' ], function () {


    //首頁
    Route::get('/', 'HomeController@index');

    //最新消息管理
    Route::get('news', 'NewsController@index');

    Route::get('news/create', 'NewsController@create');
    Route::post('news/store', 'NewsController@store');

    Route::get('news/edit/{id}', 'NewsController@edit');
    Route::post('news/update/{id}', 'NewsController@update');

    Route::post('news/delete/{id}', 'NewsController@delete');

    Route::post('ajax_delete_news_imgs', 'NewsController@ajax_delete_news_imgs');


    //產品管理
    Route::get('product', 'ProductController@index');

    Route::get('product/create', 'ProductController@create');
    Route::post('product/store', 'ProductController@store');

    Route::get('product/edit/{id}', 'ProductController@edit');
    Route::post('product/update/{id}', 'ProductController@update');

    Route::post('product/delete/{id}', 'ProductController@delete');

    //產品類型管理
    Route::get('product_type', 'ProductTypeController@index');

    Route::get('product_type/create', 'ProductTypeController@create');
    Route::post('product_type/store', 'ProductTypeController@store');

    Route::get('product_type/edit/{id}', 'ProductTypeController@edit');
    Route::post('product_type/update/{id}', 'ProductTypeController@update');

    Route::post('product_type/delete/{id}', 'ProductTypeController@delete');

    //聯絡我們
    Route::get('connection', 'ConnectionController@index');
});




