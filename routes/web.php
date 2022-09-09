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
    Route::get('/itineraries/new_entry_date', 'DetailController@new_entry_date');
    Route::get('/itineraries/new_entry/prefecture', 'PrefectureController@select');
    Route::post('/itineraries/new_entry/area', 'DetailController@store');
    Route::get('itineraries/new_entry/prefecture/{area}', 'PrefectureController@select');
    Route::get('/itineraries/{itinerary}', 'DetailController@show');
    //Route::get('/itineraries/new_entry/area', 'AreaController@select');
    
});
