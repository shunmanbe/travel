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
        <link rel="stylesheet" href="{{ asset('/css/show.css')  }}" >
        <!--header-->
        <link rel="stylesheet" href="{{ asset('/css/header.css')  }}" >
        <!--footer-->
        <link rel="stylesheet" href="{{ asset('/css/footer.css')  }}" >
    </head>
    <body>
        <header>
            <div class="header-title"><h1><a href="/">旅のしおり</a></h1></div>
            <div class="header-right">
                <ul>
                    <li><i class="fa-solid fa-user"></i> {{ $auth->name }}</li>
                    <li><a href="/itineraries/logout">ログアウト</a></li>
                </ul>
            </div>
        </header>
        <div class="containers">
            <!--しおり名-->
            <div class="theme">
                <h1>{{ $itinerary->title }}</h1>
                <span>　　期間:{{ $itinerary->departure_date->format('Y年m月d日') }}→{{ $itinerary->arrival_date->format('Y年m月d日') }}</span>
                <a href="/itineraries/{{$itinerary->id}}/new_entry/edit">　　<i class="fa-solid fa-pen-to-square icon"></i></a>
            </div>
            
            <div class="departure">
                <p class="name">
                    <span>出発地：{{ $itinerary->departure_place_name }}</span>
                    <a class="departure_supplement" href="/itineraries/{{$itinerary->id}}/departure/edit">
                        <!--編集アイコン-->
                        <i class="fa-solid fa-pen-to-square icon"></i>
                    </a>
                </p>
            </div>
            
            <div class="destinations">
                @if(empty($places))
                @else
                    @foreach($places as $n => $place)
                        <div class="to_destination">
                            <div class="triangles">
                                @for ($i=0; $i<3; $i++)
                                    <br>
                                    <div class="triangle"></div>
                                    <br>
                                @endfor
                            </div>
                            <div class="supplement">
                                <div class="departure_time">
                                    <!--出発時刻が入力されていない時-->
                                    @if(empty($place->departure_time))
                                        <form action="/itineraries/{{$itinerary->id}}/departure_time_store/{{$place->id}}" method="POST">
                                            @csrf
                                            <p>出発時刻：
                                            <input type="datetime-local" name="time_d[departure_time]"><input class ="btn" type="submit" value="保存"></p>
                                            <p class="error-message">{{ $errors->first('time.departure_time') }}</p>
                                        </form>
                                    <!--出発時刻が入力されている時 -->
                                    @else
                                        <p>出発時刻：{{$place->departure_time}}
                                            <!--出発時刻を削除-->
                                            <a class="departure_time" href="/itineraries/{{$itinerary->id}}/departure_time/{{$place->id}}/edit">
                                                <!--編集アイコン-->
                                                <i class="fa-solid fa-pen-to-square icon"></i>
                                            </a>
                                        </p>
                                    @endif
                                </div>
                                <div class="route">
                                    <form action="/itineraries/{{$itinerary->id}}/route/{{$place->id}}" method="POST">
                                        @csrf
                                        <select name="Mode">
                                            <option value="">移動手段を選択</option>
                                            <option value="DRIVING">自動車</option>
                                            <option value="TRANSIT">電車</option>
                                            <option value="WALKING">徒歩</option>
                                        </select>
                                        <p class="error-message">{{ $errors->first('Mode') }}</p>
                                        <input class="btn" type="submit" name="route" value="経路詳細">
                                        @if($n+1 == 1)
                                            <input type="hidden" name="start" value={{$itinerary->departure_place_name}}>
                                            <input type="hidden" name="end" value={{$places[$n]->destination_name}}>
                                        @else
                                            <input type="hidden" name="start" value={{$places[$n-1]->destination_name}}>
                                            <input type="hidden" name="end" value={{$places[$n]->destination_name}}>
                                        @endif
                                    </form>
                                </div>
                                <div class="arrival_time">
                                    <!--到着時刻が入力されていない時-->
                                    @if(empty($place->arrival_time))
                                        <form  action="/itineraries/{{$itinerary->id}}/arrival_time_store/{{$place->id}}" method="POST">
                                            @csrf
                                            <p>到着時刻：<input type="datetime-local" name="time_a[arrival_time]"><input class ="btn" type="submit" value="保存"></p>
                                        </form>
                                    <!--到着時刻が入力されている時-->
                                    @else
                                        <p>到着時刻：{{$place->arrival_time}}
                                             <a class="arrival_time" href="/itineraries/{{$itinerary->id}}/arrival_time/{{$place->id}}/edit">
                                                <!--編集アイコン-->
                                                <i class="fa-solid fa-pen-to-square icon"></i>
                                            </a>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="destination">
                            <div class="name">目的地{{ $n + 1 }}:{{ $place->destination_name }}
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
                    <li><a href="/itineraries/contact/form">お問い合わせ</a></li>
                </ul>
            </div>
        </footer>
        <script src="{{ asset('/js/alert.js') }}"></script>
    </body>
</html>
