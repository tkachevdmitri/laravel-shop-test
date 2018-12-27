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

Route::get('/', 'HomeController@index');

// роуты для админки
//Route::get('/admin','Admin\AdminController@index');
//Route::any('/admin/product/create', 'Admin\ProductController@create');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function(){
	Route::get('/','AdminController@index');
	Route::any('/products/create', 'ProductController@create')->name('products.create');
	Route::any('/products', 'ProductController@index');
	//Route::resource('/products', 'ProductController'); // контроллер для CRUD товаров
});


// роуты для фронта
//Route::any('/catalog', 'ProductController@index');