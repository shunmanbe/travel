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
    Route::get('/itineraries/new_entry/date', 'DetailController@date_select');//日程選択画面へ
    Route::post('/itineraries/new_entry/date_store', 'DetailController@date_store');//日程を保存
    Route::get('/itineraries/{detail}/show', 'DetailController@show');//日付のみを表示させた詳細ページを表示させるControllerへ
    Route::get('/itineraries/{detail}/departure_place_search', 'PlaceController@departure_place_serach');//出発地を検索
    Route::post('/itineraries/departure_place_map', 'PlaceController@departure_place_map');//検索ワードからマップを表示
    
    
    
    //Route::get('/itineraries/new_entry/{detail}/departure_area', 'PlaceController@departure_point');
    //Route::get('/itineraries/new_entry/{detail}/area', 'DetailController@area_select');//出発エリア選択画面へ
    //Route::post('/itineraries/new_entry/{detail}/area_store', 'DetailController@area_store');//出発エリアを保存
    //Route::get('/itineraries/new_entry/{detail}/prefecture', 'DetailController@prefecture_select');//出発都道府県選択画面へ
    //Route::post('/itineraries/new_entry/{detail}/prefecture_store', 'DetailController@prefecture_store');//出発都道府県を保存
    
    //Route::get('itineraries/new_entry/{detail}/railroute', 'DetailController@railroute_select');//路線選択画面へ
    
    //Route::post('itineraries/new_entry/{detail}/railroute', 'RailrouteController@index');
    
    //Route::get('/itineraries/{itinerary}', 'DetailController@show');
   
   

    
    
});
