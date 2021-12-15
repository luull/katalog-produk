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
Route::post('/proseslogin', 'Auth\LoginController@login')->name('proseslogin');
Route::get('auth/google', 'Auth\GoogleController@redirectToGoogle');
Route::get('auth/google/callback', 'Auth\GoogleController@handleGoogleCallback');
Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/search', 'SearchController@index')->name('findproduk');
Route::get('defaultProduk/{id}', 'SearchController@defaultproduk');
Route::get('produk/{id}', 'SearchController@produk');
Route::get('/cart', 'CartController@index');
Route::post('/add-cart', 'CartController@create')->name('add-cart');
Route::get('/deletecart/{id}', 'CartController@delete');

