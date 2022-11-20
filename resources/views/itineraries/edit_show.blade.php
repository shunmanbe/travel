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
                    <ul>
                        <li><i class="fa-solid fa-user"></i> {{ $auth->name }}</li>
                        <li><a href="{{ route('logout') }}">ログアウト</a></li>
                    </ul>
                </div>
            </header>
            <div class="containers">
                <!--しおり名-->
                <div class="theme">
                    <h1>{{ $itinerary->title }}</h1>
                    <span class="not-responsive">　　</span><span><span class="not-responsive">期間：</span>{{ $itinerary->departure_date->format('Y年m月d日') }}→{{ $itinerary->arrival_date->format('Y年m月d日') }}</span>
                    <a href="{{ route('edit_new_entry', ['itinerary' => $itinerary->id]) }}">　　<i class="fa-solid fa-pen-to-square icon"></i></a>
                </div>
                <!--出発地-->
                <div class="departure">
                    <p class="name">
                        <span>出発地：{{ $itinerary->departure_place_name }}</span>
                        <!--編集アイコン-->
                        <a class="departure-supplement" href="{{ route('edit_departure', ['itinerary' => $itinerary->id]) }}"><i class="fa-solid fa-pen-to-square icon"></i></a>
                    </p>
                </div>
                <!--目的地一覧-->
                <div class="destinations">
                    <!--目的地が入力されていない時-->
                    @if(empty($places))
                    <!--目的地が入力されている時-->
                    @else
                        @foreach($places as $n => $place)
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
                                        @if(empty($place->departure_time))
                                            <form action="{{ route('departure_time_store', ['itinerary' => $itinerary->id, 'place' => $place->id]) }}" method="POST">
                                                @csrf
                                                <p class="departure-time-empty">出発時刻：
                                                    <!--出発時刻入力欄-->
                                                    <input id="departure-empty-{{$n}}" class="input" type="datetime-local" name="time[departure_time]">
                                                    <!--保存ボタン-->
                                                    <input class ="btn-green" type="submit" value="保存">
                                                </p>
                                                <!--エラーメッセージ-->
                                                <p class="error-message">{{ $errors->first('time.departure_time') }}</p>
                                            </form>
                                        <!--出発時刻が入力されている時 -->
                                        @else
                                            <p class="departure-time-entered">出発時刻：<span id="departure-entered-{{$n}}">{{$place->departure_time}}</span>
                                                <!--出発時刻編集アイコン-->
                                                <a href="{{ route('edit_departure_time', ['itinerary' => $itinerary->id, 'place' => $place->id]) }}"><i class="fa-solid fa-pen-to-square icon"></i></a>
                                            </p>
                                        @endif
                                    </div>
                                    <!--経路情報-->
                                    <div class="route">
                                        <form action="{{ route('route', ['itinerary' => $itinerary->id, 'place' => $place->id]) }}" method="POST">
                                            @csrf
                                            <!--移動手段-->
                                            <p>移動手段：
                                                <select name="Mode">
                                                    <option value="WALKING">徒歩</option>
                                                    <!--<option value="TRANSIT">電車</option>-->
                                                    <option value="DRIVING">自動車</option>
                                                    <option value="BICYCLING">自転車</option>
                                                </select>
                                                <!--経路詳細表示ボタン-->
                                                <input class="btn-green" type="submit" name="route" value="経路詳細">
                                            </p>
                                            <!--出発地からの出発か、目的地からの出発かで場合分け-->
                                            @if($n+1 == 1)
                                                <!--出発地から出発の場合は出発地→目的地-->
                                                <!--出発地の名前・緯度・経度-->
                                                <input type="hidden" name="start_name" value="{{$itinerary->departure_place_name}}">
                                                <input type="hidden" name="start_lat" value="{{$itinerary->departure_place_lat}}">
                                                <input type="hidden" name="start_lng" value="{{$itinerary->departure_place_lng}}">
                                                <!--目的地の名前・緯度・経度-->
                                                <input type="hidden" name="goal_name" value="{{$places[$n]->name}}">
                                                <input type="hidden" name="goal_lat" value="{{$places[$n]->lat}}">
                                                <input type="hidden" name="goal_lng" value="{{$places[$n]->lng}}">
                                            @else
                                                <!--目的地からの出発の場合は目的地→目的地-->
                                                <!--出発地の名前・緯度・経度-->
                                                <input type="hidden" name="start_name" value="{{$places[$n-1]->name}}">
                                                <input type="hidden" name="start_lat" value="{{$places[$n-1]->lat}}">
                                                <input type="hidden" name="start_lng" value="{{$places[$n-1]->lng}}">
                                                <!--目的地の名前・緯度・経度-->
                                                <input type="hidden" name="goal_name" value="{{$places[$n]->name}}">
                                                <input type="hidden" name="goal_lat" value="{{$places[$n]->lat}}">
                                                <input type="hidden" name="goal_lng" value="{{$places[$n]->lng}}">
                                            @endif
                                        </form>
                                    </div>
                                    <!--到着時刻表示-->
                                    <div class="arrival-time">
                                        <!--到着時刻が入力されていない時-->
                                        @if(empty($place->arrival_time))
                                            <form name="arrival_time_store" action="{{ route('arrival_time_store', ['itinerary' => $itinerary->id, 'place' => $place->id]) }}" method="POST">
                                                @csrf
                                                <p class="arrival-time-empty">到着時刻：
                                                    <!--到着時刻入力欄-->
                                                    <input id="arrival-empty-{{$n}}" class="input" type="datetime-local" name="time[arrival_time]">
                                                    <!--保存ボタン-->
                                                    <!--return falseをすることで、jsが起動後に親要素（ここではform）への伝播止める。trueにするとエラーを表示させた後に保存されてしまう。-->
                                                    <input id="store-arrival-time" class ="btn-green" type="submit" value="保存" onclick="checkArrivalTime({{$n}});return false;">
                                                </p>
                                            </form>
                                        <!--到着時刻が入力されている時-->
                                        @else
                                            <p class="arrival-time-entered">到着時刻：<span id='arrival-empty-{{$n}}'>{{$place->arrival_time}}</span>
                                                <!--到着時刻編集アイコン-->
                                                <a href="{{ route('edit_arrival_time', ['itinerary' => $itinerary->id, 'place' => $place->id]) }}"><i class="fa-solid fa-pen-to-square icon"></i></a>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="destination">
                                <div class="name">目的地{{ $n + 1 }}:{{ $place->name }}
                                    <!--目的地編集-->
                                    <a href="{{ route('edit_destination', ['itinerary' => $itinerary->id, 'place' => $place->id]) }}"><i class="fa-solid fa-pen-to-square icon"></i></a>
                                    <!--目的地メモ-->
                                    <a class="memo" href="{{ route('memo', ['itinerary' => $itinerary->id, 'place' => $place->id]) }}"><i class="fa-regular fa-comment icon"></i></a>
                                    <!--目的地削除-->
                                    <form action="{{ route('destination_delete', ['itinerary' => $itinerary->id, 'place' => $place->id]) }}" method="post" style="display:inline">
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
                    <a class="btn-click" href ="{{ route('destination_search', ['itinerary' => $itinerary->id]) }}">目的地を追加</a>
                    <br>
                    <br>
                    <a class="btn-click" href="{{ route('completed_show', ['itinerary' => $itinerary->id]) }}">しおりを確定する</a>
                    <br>
                    <br>
                    <a class="btn-click" href ="{{ route('index') }}">しおり一覧に戻る</a>
                </div>
            </div>
            <footer>
                <div class="footer-left"></div>
                <div class="copyright"><span>©︎2022 Shun Nakanishi</span></div>
                <div class="contact"><a href="{{ route('form') }}">お問い合わせ</a></div>
            </footer>
            <script>
                // バリデーションに使う変数
                let n = {{$n}};
            </script>
            <script src="{{ asset('/js/delete_alert.js') }}"></script>
            <script src="{{ asset('/js/validation.js') }}"></script>
        </div>
    </body>
</html>