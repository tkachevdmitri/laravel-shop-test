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
Route::get('/', 'PageController@index');
Route::get('/product/{id}', 'PageController@show')->name('product.show');
Route::get('/category/{id}', 'PageController@category')->name('category.show');
Route::get('/catalog/', 'PageController@catalog')->name('catalog');



// роуты для админки
// , 'middleware' => 'auth'
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'auth' ], function(){
	Route::get('/','AdminController@index');
	
	//Route::any('/products/create', 'ProductController@create')->name('products.create');
	//Route::any('/products', 'ProductController@index');
	
	Route::resource('/products', 'ProductController'); // контроллер для CRUD товаров
	Route::resource('/categories', 'CategoryController'); // контроллер для CRUD категорий
});

// роуты для авторизации (сгенерировались сами)
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
