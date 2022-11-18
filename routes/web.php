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

// Googleアカウントでのログイン
Route::get('/login/google', 'Auth\LoginController@redirectToGoogle');
Route::get('/login/google/callback', 'Auth\LoginController@handleGoogleCallback');

#ログイン中のユーザーのみアクセス可能
Route::group(['middleware'=>['auth']], function(){ 
    Route::get('/home', 'HomeController@index')->name('home');
    #しおり一覧画面へ
    Route::get('/', 'ItineraryController@index')->name('index'); 
    Route::post('ajaxlike', 'ItineraryController@ajaxlike');
    #しおりの説明編集画面へ
    Route::get('/itineraries/{itinerary}/explanation', 'ItineraryController@explanation')->name('explanation');
    #しおりの説明を保存
    Route::post('/itineraries/{itinerary}/explanation/store', 'ItineraryController@explanation_store')->name('explanation_store');
    #新規作成（日程選択画面）へ
    Route::get('/itineraries/new_entry/date', 'ItineraryController@date_select')->name('new_entry');
    #日程を保存
    Route::post('/itineraries/new_entry/date_store', 'ItineraryController@date_store')->name('date_store');
    #完成した詳細ページへ
    Route::get('/itineraries/{itinerary}/completed/show', 'ItineraryController@completed_show')->name('completed_show');
    #詳細編集ページへ
    Route::get('/itineraries/{itinerary}/edit/show', 'ItineraryController@edit_show')->name('edit_show');
    
    // 出発地を決める
    #出発地を検索
    Route::get('/itineraries/{itinerary}/departure_place_search', 'ItineraryController@departure_place_search')->name('departure_place_search');
    #検索ワードからgoogle-placesマップを表示
    Route::post('/itineraries/{itinerary}/departure_place_map', 'ItineraryController@departure_place_map')->name('departure_place_map');
    #地図から選択した出発地をデータベースに保存
    Route::post('/itineraries/{itinerary}/departure_place_store', 'ItineraryController@departure_place_store')->name('departure_place_store');
    
    // 目的地を追加する
    #目的地検索
    Route::get('/itineraries/{itinerary}/destination_search', 'PlaceController@destination_search')->name('destination_search');
    #検索ワードからgoogle-placesマップを表示
    Route::post('/itineraries/{itinerary}/destination_map', 'PlaceController@destination_map')->name('destination_map');
    #地図から選択した目的地をデータベースに保存
    Route::post('/itineraries/{itinerary}/destination_store', 'PlaceController@destination_store')->name('destination_store');
    
    // 編集
    #しおり名と旅行期間を編集
    Route::get('/itineraries/{itinerary}/new_entry/edit', 'ItineraryController@edit_new_entry')->name('edit_new_entry');
    #しおり名と旅行期間をアップデート
    Route::put('/itineraries/{itinerary}/new_entry/update', 'ItineraryController@update_new_entry')->name('update_new_entry');
    #出発地を編集
    Route::get('/itineraries/{itinerary}/departure/edit', 'ItineraryController@edit_departure')->name('edit_departure');
    #目的地を編集
    Route::get('/itineraries/{itinerary}/edit/{place}', 'PlaceController@edit_destination')->name('edit_destination');
    #目的地を選択
    Route::post('/itineraries/{itinerary}/destination_map/edit/{place}', 'PlaceController@edit_destination_map')->name('edit_destination_map');
    #目的地をアップデート
    Route::put('/itineraries/{itinerary}/destination_update/{place}', 'PlaceController@destination_update')->name('destination_update');
    
    // 削除
    #しおり一覧からしおりを削除
    Route::delete('/itineraries/{itinerary}', 'ItineraryController@itinerary_delete')->name('itinerary_delete');
    #しおり詳細の目的地を削除
    Route::delete('/itineraries/{itinerary}/destinetion/{place}','PlaceController@destination_delete')->name('destination_delete');
    
    // 経路詳細表示(二つの詳細ページから進んだ時に、戻るボタンを押してそれぞれに別れるように2つ作った)
    #詳細編集画面から経路詳細ページへ
    Route::post('/itineraries/{itinerary}/route/{place}', 'ItineraryController@route')->name('route'); 
    #詳細完成ページから経路詳細ページへ
    Route::post('/itineraries/{itinerary}/completed_route/{place}', 'ItineraryController@completed_route')->name('completed_route'); 
    
    // ログアウト
    Route::get('/itineraries/logout', 'ItineraryController@logout')->name('logout');
    
    // メモ
    #メモページへ
    Route::get('/itineraries/{itinerary}/memo/{place}', 'PlaceController@memo')->name('memo');
    #メモを保存
    Route::post('/itineraries/{itinerary}/memo/{place}/store', 'PlaceController@memo_store')->name('memo_store');
    
    // 各地点の出発時刻
    #出発時刻を保存
    Route::post('/itineraries/{itinerary}/departure_time_store/{place}', 'PlaceController@departure_time_store')->name('departure_time_store'); 
    #出発時刻を編集(削除)
    Route::get('/itineraries/{itinerary}/departure_time/{place}/edit', 'PlaceController@edit_departure_time')->name('edit_departure_time'); 
    
    // 各地点の到着時刻
    #到着時刻を保存
    Route::post('/itineraries/{itinerary}/arrival_time_store/{place}', 'PlaceController@arrival_time_store')->name('arrival_time_store'); 
    #到着時刻を編集(削除)
    Route::get('/itineraries/{itinerary}/arrival_time/{place}/edit', 'PlaceController@edit_arrival_time')->name('edit_arrival_time'); 
   
    // お問い合わせ
    #入力フォームページ
    Route::get('/itineraries/contact/form', 'ContactsController@form')->name('form');
    #入力確認ページ
    Route::post('/itineraries/contact/confirm', 'ContactsController@confirm')->name('confirm');
    #「送信しました」画面
    Route::post('/itineraries/contact/thanks', 'ContactsController@send')->name('send');
    
    // いいね機能
    Route::post('/like', 'ItineraryController@like')->name('like');
    
    // 他の人のしおりを見る
    #他人のしおり一覧
    Route::get('/itineraries/others/index', 'ItineraryController@others_index')->name('others_index');
    #他人のしおり詳細
    Route::get('/itineraries/{itinerary}/completed/others/show', 'ItineraryController@completed_others_show')->name('completed_others_show');
    #他人のしおりルート詳細ページへ
    Route::post('/itineraries/{itinerary}/completed_others_route/{place}', 'ItineraryController@completed_others_route')->name('completed_others_route'); 
    
    // ジオコーディング
    Route::get('/itineraries/{place}/geocoding', 'ItineraryController@geocoding')->name('geocoding');
    
    
    /*
    *ここからグループ関連
    */
    
    // グループ作成
    #グループ一覧を表示
    Route::get('itineraries/group/index', 'GroupController@index_group')->name('group.index_group');
    #グループを作成
    Route::get('/itineraries/create/group', 'GroupController@create_group')->name('group.create_group');
    #グループを保存
    Route::post('itineraries/store/group', 'GroupController@store_group')->name('group.store_group');
    #グループを検索する
    Route::get('/itineraries/search/group', 'GroupController@search_group')->name('group.search_group');
    #グループに入るときのチェック画面へ
    Route::post('/itineraries/registration/check', 'GroupController@registration_check')->name('group.registration_check');
    #グループに登録する
    Route::post('/itineraries/register/group', 'GroupController@register_group')->name('group.register_group');
    #グループの情報を表示
    Route::get('/itineraries/{group}/group/information', 'GroupController@group_information')->name('group.group_information');
    #グループの情報を保存
    Route::post('/itineraries/{group}/group/information_store', 'GroupController@information_store')->name('group.information_store');
    #グループを抜ける
    Route::post('/itineraries/{group}/group/escape', 'GroupController@escape')->name('group.escape');
    
    // しおり作成
    #グループのしおり一覧へ
    Route::get('/itineraries/{group}/group/itinerary_index', 'ShareItineraryController@itinerary_index')->name('group.itinerary_index');
    #しおりの説明編集画面へ
    Route::get('/itineraries/{group}/group/{shareItinerary}/explanation', 'ShareItineraryController@explanation')->name('group.explanation');
    #しおりの説明を保存
    Route::post('/itineraries/{group}/group/{shareItinerary}/explanation/store', 'ShareItineraryController@explanation_store')->name('group.explanation_store');
    #新規登録画面（日程選択画面）へ
    Route::get('/itineraries/{group}/group/new_entry/date', 'ShareItineraryController@date_select')->name('group.new_entry');
    #日程を保存
    Route::post('/itineraries/{group}/group/new_entry/date_store', 'ShareItineraryController@date_store')->name('group.date_store');
    #しおり一覧からしおりを削除
    Route::delete('/itineraries/{group}/group/{shareItinerary}', 'ShareItineraryController@itinerary_delete')->name('group.itinerary_delete');
    #完成した詳細ページへ
    Route::get('/itineraries/{group}/group/{shareItinerary}/completed/show', 'ShareItineraryController@completed_show')->name('group.completed_show');
    #詳細編集ページへ
    Route::get('/itineraries/{group}/group/{shareItinerary}/edit/show', 'ShareItineraryController@edit_show')->name('group.edit_show');
    
    // 出発地を決める
    #出発地を検索
    Route::get('/itineraries/{group}/group/{shareItinerary}/departure_place_search', 'ShareItineraryController@departure_place_search')->name('group.departure_place_search');
    #検索ワードからgoogle-placesマップを表示
    Route::post('/itineraries/{group}/group/{shareItinerary}/departure_place_map', 'ShareItineraryController@departure_place_map')->name('group.departure_place_map');
    #地図から選択した出発地をデータベースに保存
    Route::post('/itineraries/{group}/group/{shareItinerary}/departure_place_store', 'ShareItineraryController@departure_place_store')->name('group.departure_place_store');
    
    // 目的地を決める
    #目的地検索
    Route::get('/itineraries/{group}/group/{shareItinerary}/destination_search', 'GroupPlaceController@destination_search')->name('group.destination_search');
    #検索ワードからgoogle-placesマップを表示
    Route::post('/itineraries/{group}/group/{shareItinerary}/destination_map', 'GroupPlaceController@destination_map')->name('group.destination_map');
    #地図から選択した目的地をデータベースに保存
    Route::post('/itineraries/{group}/group/{shareItinerary}/destination_store', 'GroupPlaceController@destination_store')->name('group.destination_store');
    
    // 編集
    #しおり名と旅行期間を編集
    Route::get('/itineraries/{group}/group/{shareItinerary}/new_entry/edit', 'ShareItineraryController@edit_new_entry')->name('group.edit_new_entry');
    #しおり名と旅行期間をアップデート
    Route::put('/itineraries/{group}/group/{shareItinerary}/new_entry/update', 'ShareItineraryController@update_new_entry')->name('group.update_new_entry');
    #出発地を編集
    Route::get('/itineraries/{group}/group/{shareItinerary}/departure/edit', 'ShareItineraryController@edit_departure')->name('group.edit_departure');
    #目的地を編集
    Route::get('/itineraries/{group}/group/{shareItinerary}/edit/shareItinerary/{groupPlace}', 'GroupPlaceController@edit_destination')->name('group.edit_destination');
    #目的地を選択
    Route::post('/itineraries/{group}/group/{shareItinerary}/destination_map/edit/shareItinerary/{groupPlace}', 'GroupPlaceController@edit_destination_map')->name('group.edit_destination_map');
    #目的地をアップデート
    Route::put('/itineraries/{group}/group/{shareItinerary}/destination_update/shareItinerary/{groupPlace}', 'GroupPlaceController@destination_update')->name('group.destination_update');
    #しおり詳細の目的地を削除
    Route::delete('/itineraries/{group}/group/{shareItinerary}/destinetion/shareItinerary/{groupPlace}','GroupPlaceController@destination_delete')->name('group.destination_delete');
   
   
    // 経路詳細表示(二つの詳細ページから進んだ時に、戻るボタンを押してそれぞれに別れるように2つ作った)
    #詳細編集画面から経路詳細ページへ
    Route::post('/itineraries/{group}/group/{shareItinerary}/route/shareItinerary/{groupPlace}', 'ShareItineraryController@route')->name('group.route'); 
    #詳細完成ページから経路詳細ページへ
    Route::post('/itineraries/{group}/group/{shareItinerary}/completed_route/shareItinerary/{groupPlace}', 'ShareItineraryController@completed_route')->name('group.completed_route'); 
    
    // メモ
    #メモページへ
    Route::get('/itineraries/{group}/group/{shareItinerary}/memo/shareItinerary/{groupPlace}', 'GroupPlaceController@memo')->name('group.memo');
    #メモを保存
    Route::post('/itineraries/{group}/group/{shareItinerary}/memo/shareItinerary/{groupPlace}/store', 'GroupPlaceController@memo_store')->name('group.memo_store');
    
    // 各地点の出発時刻
    #出発時刻を保存
    Route::post('/itineraries/{group}/group/{shareItinerary}/departure_time_store/shareItinerary/{groupPlace}', 'GroupPlaceController@departure_time_store')->name('group.departure_time_store'); 
    #出発時刻を編集(削除)
    Route::get('/itineraries/{group}/group/{shareItinerary}/departure_time/shareItinerary/{groupPlace}/edit', 'GroupPlaceController@edit_departure_time')->name('group.edit_departure_time'); 
    
    // 各地点の到着時刻
    #到着時刻を保存
    Route::post('/itineraries/{group}/group/{shareItinerary}/arrival_time_store/shareItinerary/{groupPlace}', 'GroupPlaceController@arrival_time_store')->name('group.arrival_time_store'); 
    #到着時刻を編集(削除)
    Route::get('/itineraries/{group}/group/{shareItinerary}/arrival_time/shareItinerary/{groupPlace}/edit', 'GroupPlaceController@edit_arrival_time')->name('group.edit_arrival_time'); 
    
    
    
    
});
