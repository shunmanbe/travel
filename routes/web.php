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
    Route::post('/itineraries/{detail}/departure_place_map', 'PlaceController@departure_place_map');//検索ワードからgoogle-placesマップを表示
    Route::post('/itineraries/{detail}/departure_place_store', 'DetailController@departure_place_store');//地図から選択した出発地をデータベースに保存
    Route::get('/itineraries/{detail}/decided_only_departure_place', 'DetailController@decide_first_destination');//出発地が決定しており、一つ目の目的地を決めるControllerへ
    
    Route::get('/itineraries/{detail}/first_destination_search', 'PlaceController@first_destination_search');//目的地1を検索
    Route::post('/itineraries/{detail}/first_destination_map', 'PlaceController@first_destination_map');//検索ワードからgoogle-placesマップを表示
    Route::post('/itineraries/{detail}/first_destination_store', 'DetailController@first_destination_store');//地図から選択した目的地1をデータベースに保存
    Route::get('/itineraries/{detail}/decided_first_destination', 'DetailController@decide_second_destination');//目的地1が決定しており、一つ目の目的地を決めるControllerへ
    
    Route::get('/itineraries/{detail}/second_destination_search', 'PlaceController@second_destination_search');//目的地2を検索
    Route::post('/itineraries/{detail}/second_destination_map', 'PlaceController@second_destination_map');//検索ワードからgoogle-placesマップを表示
    Route::post('/itineraries/{detail}/second_destination_store', 'DetailController@second_destination_store');//地図から選択した目的地2をデータベースに保存
    Route::get('/itineraries/{detail}/decided_second_destination', 'DetailController@decide_third_destination');//目的地2が決定しており、一つ目の目的地を決めるControllerへ
    
    Route::get('/itineraries/{detail}/third_destination_search', 'PlaceController@third_destination_search');//目的地3を検索
    Route::post('/itineraries/{detail}/third_destination_map', 'PlaceController@third_destination_map');//検索ワードからgoogle-placesマップを表示
    Route::post('/itineraries/{detail}/third_destination_store', 'DetailController@third_destination_store');//地図から選択した目的地3をデータベースに保存
    Route::get('/itineraries/{detail}/decided_third_destination', 'DetailController@decided_all');//目的地3まで決定している状態で詳細表示
    
    
    
    //Route::get('/itineraries/new_entry/{detail}/departure_area', 'PlaceController@departure_point');
    //Route::get('/itineraries/new_entry/{detail}/area', 'DetailController@area_select');//出発エリア選択画面へ
    //Route::post('/itineraries/new_entry/{detail}/area_store', 'DetailController@area_store');//出発エリアを保存
    //Route::get('/itineraries/new_entry/{detail}/prefecture', 'DetailController@prefecture_select');//出発都道府県選択画面へ
    //Route::post('/itineraries/new_entry/{detail}/prefecture_store', 'DetailController@prefecture_store');//出発都道府県を保存
    
    //Route::get('itineraries/new_entry/{detail}/railroute', 'DetailController@railroute_select');//路線選択画面へ
    
    //Route::post('itineraries/new_entry/{detail}/railroute', 'RailrouteController@index');
    
    //Route::get('/itineraries/{itinerary}', 'DetailController@show');
    
    //Route::post('/itineraries/departure_place_map', 'PlaceController@departure_place_map_embed');//検索ワードからgoogle-embedマップを表示
   
   

    
    
});
