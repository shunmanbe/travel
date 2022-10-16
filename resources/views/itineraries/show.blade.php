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
        <!--ヘッダー-->
        <link rel="stylesheet" href="{{ asset('/css/header.css')  }}" >
        <!--各ページcss-->
        <link rel="stylesheet" href="{{ asset('/css/show.css')  }}" >
       
    </head>
    <body>
        <header>
            <h1 class="header-title">旅のしおり</div>
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
                <h1>{{ $detail->title }}</h1>
                <a>　　期間:{{ $detail->departure_date->format('Y年m月d日') }}→{{ $detail->end_date->format('Y年m月d日') }}</a>
                <a href="/itineraries/{{$detail->id}}/new_entry/edit">　　<i class="fa-solid fa-pen-to-square icon"></i></a>
            </div>
            
            <div class="departure">
                <p class="name">
                    <a>出発地：{{ $detail->departure_place_name }}</a>
                    <a class="departure_supplement" href="/itineraries/{{$detail->id}}/departure/edit">
                    <!--編集アイコン-->
                    <i class="fa-solid fa-pen-to-square icon"></i></a>
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
                                @if(empty($place->departure_time))
                                    <form action="/itineraries/{{$detail->id}}/departure_time_store/{{$place->id}}" method="POST">
                                        @csrf
                                        <p>出発時刻：<input type="datetime-local" name="time[departure_time]"><input class ="btn" type="submit" value="保存"></p>
                                    </form>
                                @else
                                    <p>出発時刻：{{$place->departure_time}}</p>
                                @endif
                            </div>
                            <div class="route">
                                <form action="/itineraries/{{$detail->id}}/route/{{$place->id}}" method="POST">
                                    @csrf
                                    <select name="Mode">
                                        <option value="">移動手段を選択</option>
                                        <option value="DRIVING">自動車</option>
                                        <option value="TRANSIT">電車</option>
                                        <option value="WALKING">徒歩</option>
                                    </select>
                                    <p class="title__error" style="color:red">{{ $errors->first('Mode') }}</p>
                                    <a href="/itineraries/{{$detail->id}}/route"><input type="submit" name="route" value="経路詳細"></a>
                                    @if($n+1 == 1)
                                        <input type="hidden" name="start" value={{$detail->departure_place_name}}>
                                        <input type="hidden" name="end" value={{$places[$n]->destination_name}}>
                                    @else
                                        <input type="hidden" name="start" value={{$places[$n-1]->destination_name}}>
                                        <input type="hidden" name="end" value={{$places[$n]->destination_name}}>
                                    @endif
                                </form>
                            </div>
                        
                            <p>移動時間：</p>
                            <div class="arrival">
                                @if(empty($place->arrival_time))
                                    <form  action="/itineraries/{{$detail->id}}/arrival_time_store/{{$place->id}}" method="POST">
                                        @csrf
                                        <p>到着時刻：<input type="datetime-local" name="arrival_time"><input class ="btn" type="submit" value="保存"></p>
                                    </form>
                                @else
                                    <p>到着時刻：{{$place->arrival_time}}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                            <div class="destination">
                                <div class="name">目的地{{ $n + 1 }}:{{ $place->destination_name }}
                                    <!--目的地編集-->
                                    <a href="/itineraries/{{$detail->id}}/edit/{{ $place->id }}"><i class="fa-solid fa-pen-to-square icon"></i></a>
                                    <!--目的地メモ-->
                                    <a class="memo" href="/itineraries/{{ $detail->id }}/memo/{{ $place->id }}"><i class="fa-regular fa-comment icon"></i></a>
                                    <!--目的地削除-->
                                    <form action="/itineraries/{{ $detail->id }}/destinetion/{{ $place->id }}" method="post" style="display:inline">
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
                <a href ="/itineraries/{{$detail->id}}/destination_search">目的地を選択</a>
                <br>
                <a href ="/">しおり一覧に戻る</a>
            </div>
        </div>
        <script src="{{ asset('/js/alert.js') }}"></script>
    </body>
</html>
