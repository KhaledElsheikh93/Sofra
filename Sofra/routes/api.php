<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1'], function(){

    Route::group(['prefix' => 'client', 'namespace' => 'Api\Client'], function(){
        Route::group(['middleware' => 'auth:api'], function(){
            Route::get('profile', 'MainController@profile');
            Route::post('edit-profile', 'MainController@editProfile');
            Route::post('contacts', 'MainController@contacts');
            Route::post('review', 'MainController@addComment');
            Route::post('new-order', 'MainController@newOrder');
            Route::post('accepted-order', 'MainController@acceptedOrder');
            Route::post('delivered-order', 'MainController@deliveredOrder');
            Route::get('order-details', 'MainController@orderDetails');
            Route::post('declined-order', 'MainController@declineOrder');
            Route::get('current-order', 'MainController@currentOrder');
            Route::get('previous-orders', 'MainController@previousOrders'); 
            Route::get('restaurant-data', 'MainController@restaurantData');
            Route::post('register-token', 'AuthController@registerToken'); 
            Route::post('remove-token', 'AuthController@removeToken');
    });
        Route::get('cities', 'MainController@cities');
        Route::get('districts', 'MainController@districts');
        Route::post('register','AuthController@register');
        Route::post('login', 'AuthController@login');
        Route::post('reset-password', 'AuthController@sendPinCode');
        Route::post('new-password', 'AuthController@newPassword');
        Route::get('settings', 'MainController@settings');
      
       
    });


    Route::group(['prefix' => 'restaurant', 'namespace'=> 'Api\Restaurant'], function(){
        Route::group(['middleware' => 'auth:restaurant'], function(){
            
            Route::post('register-token', 'AuthController@registerToken');
            Route::post('remove-token', 'AuthController@removeToken'); 
            Route::get('profile', 'MainController@profile')->middleware('commissionBlock');
            Route::post('edit-profile', 'MainController@editProfile')->middleware('commissionBlock');
            Route::post('create-products', 'MainController@createProducts')->middleware('commissionBlock');
            Route::get('products', 'MainController@products');
            Route::post('edit-products', 'MainController@editProducts')->middleware('commissionBlock');
            Route::post('delete-products', 'MainController@deleteProducts')->middleware('commissionBlock');
            Route::get('show-products', 'MainController@showProducts');
            Route::get('restaurant-state', 'MainController@restaurantState');
            Route::post('change-restaurant-state', 'MainController@changeRestaurantState');
            Route::post('create-offer', 'MainController@createOffer');
            Route::post('update-offer', 'MainController@updateOffers');
            Route::post('delete-offer', 'MainController@deleteOffers');
            Route::get('reviews', 'MainController@restaurantReviews');
            Route::get('order-details', 'MainController@orderDetails');
            Route::get('restaurant-new-order', 'MainController@restaurantNewOrder');
            Route::post('restaurant-accepted-orders', 'MainController@restaurantAcceptedOrders')->middleware('commissionBlock');
            Route::get('restaurant-current-orders', 'MainController@restaurantCurrentOrders')->middleware('commissionBlock');
            Route::post('restaurant-declined-order', 'MainController@restaurantDeclinedOrder');
            Route::get('rejected-orders', 'MainController@rejectedOrders')->middleware('commissionBlock');
            Route::get('delivered-orders', 'MainController@deliveredOrders');
            Route::get('commission', 'MainController@commission');
            Route::post('add-categories', 'MainController@addCategory');
              

        });

        
        Route::get('cities', 'MainController@cities');
        Route::get('districts', 'MainController@districts');
        Route::post('register','AuthController@register');
        Route::post('login', 'AuthController@login');
        Route::post('reset-password', 'AuthController@sendPinCode');
        Route::post('new-password', 'AuthController@newPassword');
        Route::get('settings', 'MainController@settings');
        Route::get('categories', 'MainController@categories');
        
    });

});