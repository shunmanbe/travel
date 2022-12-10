<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>旅のしおり</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <!--アイコン表示-->
        <script src="https://kit.fontawesome.com/af4a7db726.js" crossorigin="anonymous"></script>
        <!--ページCSS-->
        <link rel="stylesheet" href="{{ asset('/css/show.css') }}" >
        <link rel="stylesheet" href="{{ asset('/css/responsive/show.css') }}" >
        <!--header-->
        <link rel="stylesheet" href="{{ asset('/css/header.css') }}" >
        <link rel="stylesheet" href="{{ asset('/css/responsive/header.css') }}" >
        <!--footer-->
        <link rel="stylesheet" href="{{ asset('/css/footer.css') }}" >
        <link rel="stylesheet" href="{{ asset('/css/responsive/footer.css') }}" >
    </head>
    <body>
        <div class="wrapper">
            <header>
                <div class="header-left not-responsive"></div>
                <div class="header-title"><h1><a href="{{ route('index') }}">旅のしおり</a></h1></div>
                <div class="header-right">
                    <div class="setting-list-left"></div>
                    <div class="setting-icon open-setting"><i class="fa-solid fa-gear color-change"></i></div>
                    <div class="setting-list">
                        <ul>
                            <li class="setting-list-item"><span class="color-change"><i class="fa-solid fa-user"></i> {{ $auth->name }}</span></li>
                            <li class="setting-list-item"><a href="{{ route('logout') }}">ログアウト</a></li>
                            <li class="close-setting setting-list-item"><span class="color-change">閉じる</span></li>
                        </ul>
                    </div>
                </div>
                <div class="setting-background"></div>
            </header>
            <div class="containers">
                <!--しおり名-->
                <div class="theme">
                    <h1>{{ $shareItinerary->title }}</h1>
                    <span class="not-responsive">　　</span><span class="not-responsive">期間：</span><span id="departure_day">{{ $shareItinerary->departure_date->format('Y年m月d日') }}</span><span>→</span><span id="arrival_day">{{ $shareItinerary->arrival_date->format('Y年m月d日') }}</span>
                    <a href="{{ route('group.edit_new_entry', ['group' => $group->id, 'shareItinerary' => $shareItinerary->id]) }}">　　<i class="fa-solid fa-pen-to-square icon"></i></a>
                </div>
                <!--出発地-->
                <div class="departure">
                    <p class="name">
                        <span>出発地：{{ $shareItinerary->departure_place_name }}</span>
                        <!--編集アイコン-->
                        <a href="{{ route('group.edit_departure', ['group' => $group->id, 'shareItinerary' => $shareItinerary->id]) }}"><i class="fa-solid fa-pen-to-square icon"></i></a>
                        <!--目的地メモ-->
                        <a class="memo" href="{{ route('group.memo_departure', ['group' => $group->id, 'shareItinerary' => $shareItinerary->id]) }}"><i class="fa-regular fa-comment icon"></i></a>
                    </p>
                </div>
                <!--目的地一覧-->
                <div class="destinations">
                    <!--目的地が入力されていない時-->
                    @if(empty($groupPlaces))
                    <!--目的地が入力されている時-->
                    @else
                        @foreach($groupPlaces as $n => $groupPlace)
                            <div class="to-destination">
                                <!--三角形表示-->
                                <div class="triangles">
                                    <br>
                                    @for ($i=0; $i<3; $i++)
                                        <div class="triangle"></div>
                                        <br class="not-responsive">
                                    @endfor
                                </div>
                                <!--出発・到着時刻などの補足情報-->
                                <div class="supplement">
                                    <!--出発時刻表示-->
                                    <div class="departure-time">
                                        <!--出発時刻が入力されていない時-->
                                        @if(empty($groupPlace->departure_time))
                                            <form name="departure_time_store" action="{{ route('group.departure_time_store', ['group' => $group->id, 'shareItinerary' => $shareItinerary->id, 'groupPlace' => $groupPlace->id]) }}" method="POST">
                                                @csrf
                                                <p class="departure-time-empty"><span>出発時刻：</span>
                                                    <!--出発時刻入力欄-->
                                                    <input id="departure-empty-{{$n}}" class="input" type="datetime-local" name="time[departure_time]">
                                                    <!--保存ボタン-->
                                                    <input class ="btn-green" type="submit" value="保存" onclick="checkDepartureTime({{$n}});return false;">
                                                </p>
                                                <!--エラーメッセージ-->
                                                <p class="error-message">{{ $errors->first('time.departure_time') }}</p>
                                            </form>
                                        <!--出発時刻が入力されている時 -->
                                        @else
                                            <p class="departure-time-entered"><span>出発時刻：</span><span id="departure-entered-{{$n}}">{{$groupPlace->departure_time}}</span>
                                                <!--出発時刻編集アイコン-->
                                                <a href="{{ route('group.edit_departure_time', ['group' => $group->id, 'shareItinerary' => $shareItinerary->id, 'groupPlace' => $groupPlace->id]) }}"><i class="fa-solid fa-pen-to-square icon"></i></a>
                                            </p>
                                        @endif
                                    </div>
                                    <!--経路情報-->
                                    <div class="route">
                                        <!--経路情報をコントローラーに送る-->
                                        <form action="{{ route('group.route', ['group' => $group->id, 'shareItinerary' => $shareItinerary->id, 'groupPlace' => $groupPlace->id]) }}" method="POST">
                                            @csrf
                                            <!--移動手段が決定していない時-->
                                            @if(empty($groupPlace->transportation))
                                                <!--移動手段-->
                                                <p><span>移動手段：</span>
                                                    <select name="transportation[transportation]">
                                                        <option value="WALKING">徒歩</option>
                                                        <!--<option value="TRAIN">電車</option>-->
                                                        <option value="DRIVING">自動車</option>
                                                        <option value="BICYCLING">自転車</option>
                                                    </select>
                                                    <!--移動手段保存ボタン-->
                                                    <input class="btn-green" type="submit" value="保存" formaction="{{ route('group.store_transportation', ['group' => $group->id, 'shareItinerary' => $shareItinerary->id, 'groupPlace'=> $groupPlace->id]) }}">
                                                    <!--経路詳細表示ボタン-->
                                                    <input class="btn-green" type="submit" value="経路詳細" formaction="{{ route('group.route', ['group' => $group->id, 'shareItinerary' => $shareItinerary->id, 'groupPlace'=> $groupPlace->id]) }}">
                                                </p>
                                            <!--移動手段が決定している時-->
                                            @else
                                                <!--移動手段が"WALKING"で保存されているとき-->
                                                @if($groupPlace->transportation == "WALKING")
                                                    <span>移動手段：徒歩</span>
                                                <!--移動手段が"TRAIN"で保存されているとき-->
                                                @elseif($groupPlace->transportation == "TRAIN")
                                                    <span>移動手段：電車</span>
                                                <!--移動手段が"DRIVING"で保存されているとき-->
                                                @elseif($groupPlace->transportation == "DRIVING")
                                                    <span>移動手段：自動車</span>
                                                <!--移動手段が"BICYCLING"で保存されているとき-->
                                                @else($groupPlace->transportation == "BICYCLING")
                                                    <span>移動手段：自転車</span>
                                                @endif
                                                <!--移動手段編集アイコン-->
                                                    <a href="{{ route('group.edit_transportation', ['group' => $group->id, 'shareItinerary' => $shareItinerary->id, 'groupPlace'=> $groupPlace->id]) }}"><i class="fa-solid fa-pen-to-square icon"></i></a>
                                                <!--経路詳細表示ボタン-->
                                                <input class="btn-green" type="submit" value="経路詳細" formaction="{{ route('group.route', ['group' => $group->id, 'shareItinerary' => $shareItinerary->id, 'groupPlace'=> $groupPlace->id]) }}">
                                            @endif
                                            <!--出発地からの出発か、目的地からの出発かで場合分け-->
                                            @if($n+1 == 1)
                                                <!--出発地から出発の場合は出発地→目的地-->
                                                <!--出発地の名前・緯度・経度-->
                                                <input type="hidden" name="start_name" value="{{$shareItinerary->departure_place_name}}">
                                                <input type="hidden" name="start_lat" value="{{$shareItinerary->departure_place_lat}}">
                                                <input type="hidden" name="start_lng" value="{{$shareItinerary->departure_place_lng}}">
                                                <!--目的地の名前・緯度・経度-->
                                                <input type="hidden" name="goal_name" value="{{$groupPlaces[$n]->name}}">
                                                <input type="hidden" name="goal_lat" value="{{$groupPlaces[$n]->lat}}">
                                                <input type="hidden" name="goal_lng" value="{{$groupPlaces[$n]->lng}}">
                                            @else
                                                <!--目的地からの出発の場合は目的地→目的地-->
                                                <!--出発地の名前・緯度・経度-->
                                                <input type="hidden" name="start_name" value="{{$groupPlaces[$n-1]->name}}">
                                                <input type="hidden" name="start_lat" value="{{$groupPlaces[$n-1]->lat}}">
                                                <input type="hidden" name="start_lng" value="{{$groupPlaces[$n-1]->lng}}">
                                                <!--目的地の名前・緯度・経度-->
                                                <input type="hidden" name="goal_name" value="{{$groupPlaces[$n]->name}}">
                                                <input type="hidden" name="goal_lat" value="{{$groupPlaces[$n]->lat}}">
                                                <input type="hidden" name="goal_lng" value="{{$groupPlaces[$n]->lng}}">
                                            @endif
                                        </form>
                                    </div>
                                    <!--到着時刻表示-->
                                    <div class="arrival-time">
                                        <!--到着時刻が入力されていない時-->
                                        @if(empty($groupPlace->arrival_time))
                                            <form name="arrival_time_store" action="{{ route('group.arrival_time_store', ['group' => $group->id, 'shareItinerary' => $shareItinerary->id, 'groupPlace' => $groupPlace->id]) }}" method="POST">
                                                @csrf
                                                <p class="arrival-time-empty"><span>到着時刻：</span>
                                                    <!--到着時刻入力欄-->
                                                    <input id="arrival-empty-{{$n}}" class="input" type="datetime-local" name="time[arrival_time]">
                                                    <!--保存ボタン-->
                                                    <input id="store-arrival-time" class ="btn-green" type="submit" value="保存" onclick="checkArrivalTime({{$n}});return false;">
                                                </p>
                                            </form>
                                        <!--到着時刻が入力されている時-->
                                        @else
                                            <p class="arrival-time-entered"><span>到着時刻：</span><span id='arrival-entered-{{$n}}'>{{$groupPlace->arrival_time}}</span>
                                                <!--到着時刻編集アイコン-->
                                                <a href="{{ route('group.edit_arrival_time', ['group' => $group->id, 'shareItinerary' => $shareItinerary->id, 'groupPlace' => $groupPlace->id]) }}"><i class="fa-solid fa-pen-to-square icon"></i></a>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="destination">
                                <div class="name">目的地{{ $n + 1 }}:{{ $groupPlace->name }}
                                    <!--目的地編集-->
                                    <a href="{{ route('group.edit_destination', ['group' => $group->id, 'shareItinerary' => $shareItinerary->id, 'groupPlace' => $groupPlace->id]) }}"><i class="fa-solid fa-pen-to-square icon"></i></a>
                                    <!--目的地メモ-->
                                    <a class="memo" href="{{ route('group.memo', ['group' => $group->id, 'shareItinerary' => $shareItinerary->id, 'groupPlace' => $groupPlace->id]) }}"><i class="fa-regular fa-comment icon"></i></a>
                                    <!--目的地削除-->
                                    <form action="{{ route('group.destination_delete', ['group' => $group->id, 'shareItinerary' => $shareItinerary->id, 'groupPlace' => $groupPlace->id])}}" method="post" style="display:inline">
                                        @csrf
                                        @method('DELETE') 
                                        <input class="trash icon" type="submit" onclick="delete_alert(event);return false;" value="&#xf2ed;"> 
                                    </form>
                                </div>
                            </div>
                            <br>
                        @endforeach
                    @endif
                </div>
                <div class="center">
                    <a class="btn-click" href ="{{ route('group.destination_search', ['group' => $group->id, 'shareItinerary' => $shareItinerary->id]) }}">目的地を追加</a>
                    <br>
                    <br>
                    <a class="btn-click" href="{{ route('group.completed_show', ['group' => $group->id, 'shareItinerary' => $shareItinerary->id]) }}">しおりを確定する</a>
                    <br>
                    <br>
                    <a class="btn-click" href ="{{ route('group.index_group') }}">グループのしおり一覧に戻る</a>
                </div>
            </div>
            <footer>
                <div class="footer-left"></div>
                <div class="copyright"><span>©︎2022 Shun Nakanishi</span></div>
                <div class="contact"><a href="/itineraries/contact/form">お問い合わせ</a></div>
            </footer>
            <script>
                // バリデーションに使う変数
                let n = {{$n}};
            </script>
            <script src="{{ asset('/js/delete_alert.js') }}"></script>
            <script src="{{ asset('/js/validation.js') }}"></script>
            <script src="{{ asset('/js/setting.js') }}"></script>
        </div>
    </body>
</html>
