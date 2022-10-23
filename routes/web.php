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
    Route::get('/', 'DetailController@index'); //しおり一覧画面へ
    Route::post('ajaxlike', 'DetailController@ajaxlike');
    Route::get('/itineraries/new_entry/date', 'DetailController@date_select');//日程選択画面へ
    Route::post('/itineraries/new_entry/date_store', 'DetailController@date_store');//日程を保存
    Route::get('/itineraries/{detail}/completed_show', 'DetailController@completed_show');//完成した詳細ページへ
    Route::get('itineraries/{detail}/show/edit', 'DetailController@show_edit');//詳細編集ページへ
    
    //出発地を決める
    Route::get('/itineraries/{detail}/departure_place_search', 'DetailController@departure_place_serach');//出発地を検索
    Route::post('/itineraries/{detail}/departure_place_map', 'DetailController@departure_place_map');//検索ワードからgoogle-placesマップを表示
    Route::post('/itineraries/{detail}/departure_place_store', 'DetailController@departure_place_store');//地図から選択した出発地をデータベースに保存
    
    //目的地を決める
    Route::get('/itineraries/{detail}/destination_search', 'PlaceController@destination_search');//目的地検索
    Route::post('/itineraries/{detail}/destination_map', 'PlaceController@destination_map');//検索ワードからgoogle-placesマップを表示
    Route::post('/itineraries/{detail}/destination_store', 'PlaceController@destination_store');//地図から選択した目的地をデータベースに保存
    
    //編集
    Route::get('/itineraries/{detail}/new_entry/edit', 'DetailController@edit_new_entry');//しおり名と旅行期間を編集
    Route::put('/itineraries/{detail}/new_entry/update', 'DetailController@update_new_entry');//しおり名と旅行期間をアップデート
    Route::get('/itineraries/{detail}/departure/edit', 'DetailController@edit_departure');//出発地を編集
    Route::get('/itineraries/{detail}/edit/{place}', 'PlaceController@edit_destination');//目的地を編集
    Route::post('/itineraries/{detail}/destination_map/edit/{place}', 'PlaceController@edit_destination_map');//目的地を選択
    Route::put('/itineraries/{detail}/destination_update/{place}', 'PlaceController@destination_update');//目的地をアップデート
    
    //削除
    Route::delete('/itineraries/{detail}', 'DetailController@itinerary_delete');//しおり一覧からしおりを削除
    Route::delete('/itineraries/{detail}/destinetion/{place}','PlaceController@destination_delete');//しおり詳細の目的地を削除
    
    //経路詳細表示
    Route::post('/itineraries/{detail}/route/{place}', 'DetailController@route');
    
    //ログアウト
    Route::get('/itineraries/logout', 'DetailController@logout');
    
    //メモ
    Route::get('/itineraries/{detail}/memo/{place}', 'PlaceController@memo');//メモページへ
    Route::post('/itineraries/{detail}/memo/{place}/store', 'PlaceController@memo_store');//メモを保存
    
    //各地点の出発時刻
    Route::post('/itineraries/{detail}/departure_time_store/{place}', 'PlaceController@departure_time_store'); //出発時刻を保存
    Route::get('/itineraries/{detail}/departure_time/{place}/edit', 'PlaceController@edit_departure_time'); //出発時刻を編集(削除)
    
    //各地点の到着時刻
    Route::post('/itineraries/{detail}/arrival_time_store/{place}', 'PlaceController@arrival_time_store'); //到着時刻を保存
    Route::get('/itineraries/{detail}/arrival_time/{place}/edit', 'PlaceController@edit_arrival_time'); //到着時刻を編集(削除)
   
    //お問い合わせ
    Route::get('/itineraries/contact/form', 'ContactsController@form');//入力フォームページ
    Route::post('/itineraries/contact/confirm', 'ContactsController@confirm');//入力確認ページ
    Route::post('/itineraries/contact/send', 'ContactsController@send');//「送信しました」画面
    
    
});
