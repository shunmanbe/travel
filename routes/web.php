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


Route::group(['middleware'=>['auth']], function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/', 'ItineraryController@index');
    Route::get('/itineraries', 'ItineraryController@index');
    Route::get('/itineraries/{itinerary}', 'DetailController@show');
    Route::get('/itineraries/new_entry', 'DetailController@new_entry');
    Route::get('/itineraries/new_entry/area', 'AreaController@select');
    
    
    
    
    
});
