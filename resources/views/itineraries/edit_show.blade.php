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
        <header>
            <div class="header-title"><h1><a href="/">旅のしおり</a></h1></div>
            <div class="header-right">
                <ul>
                    <li class="not-responsive"><i class="fa-solid fa-user"></i> {{ $auth->name }}</li>
                    <li class="not-responsive"><a href="/itineraries/logout">ログアウト</a></li>
                    <li class="responsive bars open-setting"><i class="fa-solid fa-bars"></i></li>
                </ul>
            </div>
            <div class="setting-modal responsive">
                <div class="setting-modal-contents">
                    <!--設定閉じるボタン-->
                    <div class="close-setting"><i class="fa fa-2x fa-times close-setting-icon"></i></div>
                    <li class="responsive"><i class="fa-solid fa-user"></i> {{ $auth->name }}</li>
                    <li class="responsive"><a href="/itineraries/logout">ログアウト</a></li>
                    <li class="responsive"><a href="/itineraries/contact/form">お問い合わせ</a></li>
                </div>
            </div>
        </header>
        <div class="containers">
            <!--しおり名-->
            <div class="theme">
                <h1>{{ $itinerary->title }}</h1>
                <span class="not-responsive">　　</span><span><span class="not-responsive">期間:</span>{{ $itinerary->departure_date->format('Y年m月d日') }}→{{ $itinerary->arrival_date->format('Y年m月d日') }}</span>
                <a href="/itineraries/{{$itinerary->id}}/new_entry/edit">　　<i class="fa-solid fa-pen-to-square icon"></i></a>
            </div>
            <!--出発地-->
            <div class="departure">
                <p class="name">
                    <span>出発地：{{ $itinerary->departure_place_name }}</span>
                    <!--編集アイコン-->
                    <a class="departure-supplement" href="/itineraries/{{$itinerary->id}}/departure/edit"><i class="fa-solid fa-pen-to-square icon"></i></a>
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
                                        <form action="/itineraries/{{$itinerary->id}}/departure_time_store/{{$place->id}}" method="POST">
                                            @csrf
                                            <p class="departure-time-empty">出発時刻：
                                                <!--出発時刻入力欄-->
                                                <input class="input" type="datetime-local" name="time_d[departure_time]">
                                                <!--保存ボタン-->
                                                <input class ="btn" type="submit" value="保存">
                                            </p>
                                            <!--エラーメッセージ-->
                                            <p class="error-message">{{ $errors->first('time.departure_time') }}</p>
                                        </form>
                                    <!--出発時刻が入力されている時 -->
                                    @else
                                        <p class="departure-time-entered">出発時刻：{{$place->departure_time}}
                                            <!--出発時刻編集アイコン-->
                                            <a href="/itineraries/{{$itinerary->id}}/departure_time/{{$place->id}}/edit"><i class="fa-solid fa-pen-to-square icon"></i></a>
                                        </p>
                                    @endif
                                </div>
                                <!--経路情報-->
                                <div class="route">
                                    <form action="/itineraries/{{$itinerary->id}}/route/{{$place->id}}" method="POST">
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
                                            <input class="btn" type="submit" name="route" value="経路詳細">
                                        </p>
                                        <!--出発地からの出発か、目的地からの出発かで場合分け-->
                                        @if($n+1 == 1)
                                            <!--出発地から出発の場合は出発地→目的地-->
                                            <input type="hidden" name="start_name" value="{{$itinerary->departure_place_name}}">
                                            <input type="hidden" name="start_address" value="{{$itinerary->departure_place_address}}">
                                            <input type="hidden" name="goal_name" value="{{$places[$n]->name}}">
                                            <input type="hidden" name="goal_address" value="{{$places[$n]->address}}">
                                        @else
                                            <!--目的地からの出発の場合は目的地→目的地-->
                                            <input type="hidden" name="start_name" value="{{$places[$n-1]->name}}">
                                            <input type="hidden" name="start_address" value="{{$places[$n-1]->address}}">
                                            <input type="hidden" name="goal_name" value="{{$places[$n]->name}}">
                                            <input type="hidden" name="goal_address" value="{{$places[$n]->address}}">
                                        @endif
                                    </form>
                                </div>
                                <!--到着時刻表示-->
                                <div class="arrival-time">
                                    <!--到着時刻が入力されていない時-->
                                    @if(empty($place->arrival_time))
                                        <form  action="/itineraries/{{$itinerary->id}}/arrival_time_store/{{$place->id}}" method="POST">
                                            @csrf
                                            <p class="arrival-time-empty">到着時刻：
                                                <!--到着時刻入力欄-->
                                                <input class="input" type="datetime-local" name="time_a[arrival_time]">
                                                <!--保存ボタン-->
                                                <input class ="btn" type="submit" value="保存">
                                            </p>
                                        </form>
                                    <!--到着時刻が入力されている時-->
                                    @else
                                        <p class="arrival-time-entered">到着時刻：{{$place->arrival_time}}
                                            <!--到着時刻編集アイコン-->
                                            <a href="/itineraries/{{$itinerary->id}}/arrival_time/{{$place->id}}/edit"><i class="fa-solid fa-pen-to-square icon"></i></a>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="destination">
                            <div class="name">目的地{{ $n + 1 }}:{{ $place->name }}
                                <!--目的地編集-->
                                <a href="/itineraries/{{$itinerary->id}}/edit/{{ $place->id }}"><i class="fa-solid fa-pen-to-square icon"></i></a>
                                <!--目的地メモ-->
                                <a class="memo" href="/itineraries/{{ $itinerary->id }}/memo/{{ $place->id }}"><i class="fa-regular fa-comment icon"></i></a>
                                <!--目的地削除-->
                                <form action="/itineraries/{{ $itinerary->id }}/destinetion/{{ $place->id }}" method="post" style="display:inline">
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
                <a href ="/itineraries/{{$itinerary->id}}/destination_search">目的地を選択</a>
                <br>
                <br>
                <br>
                <a href="/itineraries/{{$itinerary->id}}/completed/show">しおりを確定する</a>
                <br>
                <br>
                <a href ="/">しおり一覧に戻る</a>
            </div>
        </div>
        <footer>
            <div class="footer-wrapper">
                <div class="copyright"><span>©︎2022 Shun Nakanishi</span></div>
                <ul>
                    <li><a class="not-responsive" href="/itineraries/contact/form">お問い合わせ</a></li>
                </ul>
            </div>
        </footer>
        <script src="{{ asset('/js/alert.js') }}"></script>
        <script src="{{ asset('/js/header.js') }}"></script>
    </body>
</html>
