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

Route::get('/dashboard', 'UsersController@index');
Route::post('/updateavatar', 'UsersController@updateavatar')->name('update-avatar');
Route::post('/addcontact', 'UsersController@addcontact')->name('add-contact');

Route::get('/city/find/{id}', 'HomeController@city_list');
Route::get('/subdistrict/find/{id}', 'HomeController@subdistrict_list');
