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

#ログイン中のユーザーのみアクセス可能
Route::group(['middleware'=>['auth']], function(){ 
    Route::get('/home', 'HomeController@index')->name('home');
    #しおり一覧画面へ
    Route::get('/', 'ItineraryController@index'); 
    Route::post('ajaxlike', 'ItineraryController@ajaxlike');
    #日程選択画面へ
    Route::get('/itineraries/new_entry/date', 'ItineraryController@date_select');
    #日程を保存
    Route::post('/itineraries/new_entry/date_store', 'ItineraryController@date_store');
    #完成した詳細ページへ
    Route::get('/itineraries/{itinerary}/completed/show', 'ItineraryController@completed_show');
    #詳細編集ページへ
    Route::get('itineraries/{itinerary}/edit/show', 'ItineraryController@edit_show');
    
    //出発地を決める
    #出発地を検索
    Route::get('/itineraries/{itinerary}/departure_place_search', 'ItineraryController@departure_place_search');
    #検索ワードからgoogle-placesマップを表示
    Route::post('/itineraries/{itinerary}/departure_place_map', 'ItineraryController@departure_place_map');
    #地図から選択した出発地をデータベースに保存
    Route::post('/itineraries/{itinerary}/departure_place_store', 'ItineraryController@departure_place_store');
    
    //目的地を決める
    #目的地検索
    Route::get('/itineraries/{itinerary}/destination_search', 'PlaceController@destination_search');
    #検索ワードからgoogle-placesマップを表示
    Route::post('/itineraries/{itinerary}/destination_map', 'PlaceController@destination_map');
    #地図から選択した目的地をデータベースに保存
    Route::post('/itineraries/{itinerary}/destination_store', 'PlaceController@destination_store');
    
    //編集
    #しおり名と旅行期間を編集
    Route::get('/itineraries/{itinerary}/new_entry/edit', 'ItineraryController@edit_new_entry');
    #しおり名と旅行期間をアップデート
    Route::put('/itineraries/{itinerary}/new_entry/update', 'ItineraryController@update_new_entry');
    #出発地を編集
    Route::get('/itineraries/{itinerary}/departure/edit', 'ItineraryController@edit_departure');
    #目的地を編集
    Route::get('/itineraries/{itinerary}/edit/{place}', 'PlaceController@edit_destination');
    #目的地を選択
    Route::post('/itineraries/{itinerary}/destination_map/edit/{place}', 'PlaceController@edit_destination_map');
    #目的地をアップデート
    Route::put('/itineraries/{itinerary}/destination_update/{place}', 'PlaceController@destination_update');
    
    //削除
    #しおり一覧からしおりを削除
    Route::delete('/itineraries/{itinerary}', 'ItineraryController@itinerary_delete');
    #しおり詳細の目的地を削除
    Route::delete('/itineraries/{itinerary}/destinetion/{place}','PlaceController@destination_delete');
    
    //経路詳細表示(二つの詳細ページから進んだ時に、戻るボタンを押してそれぞれに別れるように2つ作った)
    #詳細編集画面から経路詳細ページへ
    Route::post('/itineraries/{itinerary}/route/{place}', 'ItineraryController@route'); 
    #詳細完成ページから経路詳細ページへ
    Route::post('/itineraries/{itinerary}/completed_route/{place}', 'ItineraryController@completed_route'); 
    
    //ログアウト
    Route::get('/itineraries/logout', 'ItineraryController@logout');
    
    //メモ
    #メモページへ
    Route::get('/itineraries/{itinerary}/memo/{place}', 'PlaceController@memo');
    #メモを保存
    Route::post('/itineraries/{itinerary}/memo/{place}/store', 'PlaceController@memo_store');
    
    //各地点の出発時刻
    #出発時刻を保存
    Route::post('/itineraries/{itinerary}/departure_time_store/{place}', 'PlaceController@departure_time_store'); 
    #出発時刻を編集(削除)
    Route::get('/itineraries/{itinerary}/departure_time/{place}/edit', 'PlaceController@edit_departure_time'); 
    
    //各地点の到着時刻
    #到着時刻を保存
    Route::post('/itineraries/{itinerary}/arrival_time_store/{place}', 'PlaceController@arrival_time_store'); 
    #到着時刻を編集(削除)
    Route::get('/itineraries/{itinerary}/arrival_time/{place}/edit', 'PlaceController@edit_arrival_time'); 
   
    //お問い合わせ
    #入力フォームページ
    Route::get('/itineraries/contact/form', 'ContactsController@form');
    #入力確認ページ
    Route::post('/itineraries/contact/confirm', 'ContactsController@confirm');
    #「送信しました」画面
    Route::post('/itineraries/contact/thanks', 'ContactsController@send');
    
    //いいね機能
    Route::post('/like', 'ItineraryController@like');
    
    //他の人のしおりを見る
    Route::get('/itineraries/others/index', 'ItineraryController@others_index');
    Route::get('/itineraries/{itinerary}/completed/others/show', 'ItineraryController@completed_others_show');
    
    //ジオコーディング
    Route::get('/itineraries/{place}/geocoding', 'ItineraryController@geocoding');
    
});
