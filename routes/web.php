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
// роуты для фронта
Route::get('/', 'HomeController@index');
Route::get('/product/{id}', 'HomeController@show')->name('product.show');
Route::get('/category/{id}', 'HomeController@category')->name('category.show');
Route::get('/catalog/', 'HomeController@catalog')->name('catalog');



// роуты для админки
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function(){
	Route::get('/','AdminController@index');
	//Route::any('/products/create', 'ProductController@create')->name('products.create');
	//Route::any('/products', 'ProductController@index');
	Route::resource('/products', 'ProductController'); // контроллер для CRUD товаров
	Route::resource('/categories', 'CategoryController'); // контроллер для CRUD категорий
});
