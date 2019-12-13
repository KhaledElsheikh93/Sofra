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

Auth::routes();


Route::get('/home', function () {
    return view('admin.home');
});

Route::group(['prefix' => 'admin' , 'namespace' => 'Admin'], function(){
Route::get('home', 'HomeController@index')->name('home');
Route::resource('cities', 'CityController');
Route::resource('districts', 'DistrictController');
Route::resource('clients', 'ClientController');
Route::resource('categories', 'CategoryController');
Route::resource('restaurants', 'RestaurantController');
});