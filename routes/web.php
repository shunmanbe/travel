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
    Route::get('/itineraries/new_entry/date', 'DetailController@date_select');
    Route::post('/itineraries/new_entry/date_store', 'DetailController@date_store');
    Route::post('/itineraries/new_entry/area_store', 'DetailController@area_store');
    Route::get('/itineraries/new_entry/area', 'DetailController@area_select');
    
    Route::post('/itineraries/new_entry/prefecture_store', 'DetailController@store');
    Route::get('/itineraries/new_entry/prefecture', 'PrefectureController@select');
    
    
    Route::get('itineraries/new_entry/prefecture/{area}', 'PrefectureController@select');
    Route::get('/itineraries/{itinerary}', 'DetailController@show');
   
    Route::post('/itineraries/new_entry/prefecture_store', 'PrefectureController@prefecture_store');
    //Route::get('/itineraries/new_entry/area', 'AreaController@select');
    
});
