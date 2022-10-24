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


Route::group(['middleware'=>['auth']], function(){ //ログイン中のユーザーのみアクセス可能
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/', 'ItineraryController@index'); //しおり一覧画面へ
    Route::post('ajaxlike', 'ItineraryController@ajaxlike');
    Route::get('/itineraries/new_entry/date', 'ItineraryController@date_select');//日程選択画面へ
    Route::post('/itineraries/new_entry/date_store', 'ItineraryController@date_store');//日程を保存
    Route::get('/itineraries/{itinerary}/completed_show', 'ItineraryController@completed_show');//完成した詳細ページへ
    Route::get('itineraries/{itinerary}/show/edit', 'ItineraryController@show_edit');//詳細編集ページへ
    
    //出発地を決める
    Route::get('/itineraries/{itinerary}/departure_place_search', 'ItineraryController@departure_place_serach');//出発地を検索
    Route::post('/itineraries/{itinerary}/departure_place_map', 'ItineraryController@departure_place_map');//検索ワードからgoogle-placesマップを表示
    Route::post('/itineraries/{itinerary}/departure_place_store', 'ItineraryController@departure_place_store');//地図から選択した出発地をデータベースに保存
    
    //目的地を決める
    Route::get('/itineraries/{itinerary}/destination_search', 'PlaceController@destination_search');//目的地検索
    Route::post('/itineraries/{itinerary}/destination_map', 'PlaceController@destination_map');//検索ワードからgoogle-placesマップを表示
    Route::post('/itineraries/{itinerary}/destination_store', 'PlaceController@destination_store');//地図から選択した目的地をデータベースに保存
    
    //編集
    Route::get('/itineraries/{itinerary}/new_entry/edit', 'ItineraryController@edit_new_entry');//しおり名と旅行期間を編集
    Route::put('/itineraries/{itinerary}/new_entry/update', 'ItineraryController@update_new_entry');//しおり名と旅行期間をアップデート
    Route::get('/itineraries/{itinerary}/departure/edit', 'ItineraryController@edit_departure');//出発地を編集
    Route::get('/itineraries/{itinerary}/edit/{place}', 'PlaceController@edit_destination');//目的地を編集
    Route::post('/itineraries/{itinerary}/destination_map/edit/{place}', 'PlaceController@edit_destination_map');//目的地を選択
    Route::put('/itineraries/{itinerary}/destination_update/{place}', 'PlaceController@destination_update');//目的地をアップデート
    
    //削除
    Route::delete('/itineraries/{itinerary}', 'ItineraryController@itinerary_delete');//しおり一覧からしおりを削除
    Route::delete('/itineraries/{itinerary}/destinetion/{place}','PlaceController@destination_delete');//しおり詳細の目的地を削除
    
    //経路詳細表示
    Route::post('/itineraries/{itinerary}/route/{place}', 'ItineraryController@route');
    
    //ログアウト
    Route::get('/itineraries/logout', 'ItineraryController@logout');
    
    //メモ
    Route::get('/itineraries/{itinerary}/memo/{place}', 'PlaceController@memo');//メモページへ
    Route::post('/itineraries/{itinerary}/memo/{place}/store', 'PlaceController@memo_store');//メモを保存
    
    //各地点の出発時刻
    Route::post('/itineraries/{itinerary}/departure_time_store/{place}', 'PlaceController@departure_time_store'); //出発時刻を保存
    Route::get('/itineraries/{itinerary}/departure_time/{place}/edit', 'PlaceController@edit_departure_time'); //出発時刻を編集(削除)
    
    //各地点の到着時刻
    Route::post('/itineraries/{itinerary}/arrival_time_store/{place}', 'PlaceController@arrival_time_store'); //到着時刻を保存
    Route::get('/itineraries/{itinerary}/arrival_time/{place}/edit', 'PlaceController@edit_arrival_time'); //到着時刻を編集(削除)
   
    //お問い合わせ
    Route::get('/itineraries/contact/form', 'ContactsController@form');//入力フォームページ
    Route::post('/itineraries/contact/confirm', 'ContactsController@confirm');//入力確認ページ
    Route::post('/itineraries/contact/send', 'ContactsController@send');//「送信しました」画面
    
    
});
