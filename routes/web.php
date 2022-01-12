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
Route::get('/', 'HomeController@dashboard');
Route::get('/login', 'Auth\LoginController@index');
Route::get('/logout', 'Auth\LoginController@logout');
Route::post('/proseslogin', 'Auth\LoginController@login')->name('proseslogin');

Route::get('auth/google', 'Auth\GoogleController@redirectToGoogle');
Route::get('auth/google/callback', 'Auth\GoogleController@handleGoogleCallback');

Route::get('/search', 'SearchController@index')->name('findproduk');
Route::get('defaultProduk/{id}', 'SearchController@defaultproduk');
Route::get('produk/{id}', 'SearchController@produk');

Route::get('/cart', 'CartController@index');
Route::post('/add-cart', 'CartController@create')->name('add-cart');
Route::get('/deletecart/{id}', 'CartController@delete');
Route::post('/add-dummy', 'CartController@dummy')->name('add-dummy');
Route::post('/delete-dummy', 'CartController@deletedummy')->name('delete-dummy');

Route::get('/checkout', 'CheckoutController@index');
Route::get('/kota/{id}','CheckoutController@get_city');
Route::get('/origin={city_origin}&destination={city_destination}&weight={weight}&courier={courier}','CheckoutController@get_ongkir');
Route::post('/changepick', 'CheckoutController@changepick')->name('change-pick');

Route::get('/dashboard', 'UsersController@index');
Route::post('/updateavatar', 'UsersController@updateavatar')->name('update-avatar');
Route::post('/addcontact', 'UsersController@addcontact')->name('add-contact');
Route::get('/deletecontact/{id}', 'UsersController@delete');
Route::post('/updatestatus', 'UsersController@updatestatus')->name('update-status');
Route::get('/contact/find/{id}', 'UsersController@find');

Route::get('/city/find/{id}', 'HomeController@city_list');
Route::get('/subdistrict/find/{id}', 'HomeController@subdistrict_list');



Route::get('/login/backend', 'Backend\LoginController@index');
Route::post('/prosesloginbackend', 'Backend\LoginController@login')->name('prosesloginbackend');
Route::get('/logoutbackend', 'Backend\LoginController@logout');
Route::get('/backend/dashboard', 'Backend\DashboardController@index');

Route::get('/banner/backend', 'Backend\BannerController@index');
Route::post('/backend/createbanner', 'Backend\BannerController@create')->name('create-banner');
Route::get('/backend/banner/delete/{id}', 'Backend\BannerController@delete')->name('delete-banner');
Route::get('/backend/banner/find/{id}', 'Backend\BannerController@find');
Route::post('/backend/updatebanner', 'Backend\BannerController@update')->name('update-banner');

Route::get('/product/backend', 'Backend\ProductController@index');
Route::post('/backend/createproduct', 'Backend\ProductController@create')->name('create-product');
Route::get('/backend/product/delete/{id}', 'Backend\ProductController@delete')->name('delete-product');
Route::get('/backend/product/find/{id}', 'Backend\ProductController@find');
Route::post('/backend/updateproduct', 'Backend\ProductController@update')->name('update-product');

Route::get('/category/backend', 'Backend\CategoryController@index');
Route::post('/backend/createcategory', 'Backend\CategoryController@create')->name('create-category');
Route::get('/backend/category/delete/{id}', 'Backend\CategoryController@delete')->name('delete-category');
Route::get('/backend/category/find/{id}', 'Backend\CategoryController@find');
Route::post('/backend/updatecategory', 'Backend\CategoryController@update')->name('update-category');

Route::get('/display/backend', 'Backend\DisplayController@index');
Route::post('/backend/createdisplay', 'Backend\DisplayController@create')->name('create-display');
Route::get('/backend/display/delete/{id}', 'Backend\DisplayController@delete')->name('delete-display');
Route::get('/backend/display/find/{id}', 'Backend\DisplayController@find');
Route::post('/backend/updatedisplay', 'Backend\DisplayController@update')->name('update-display');


