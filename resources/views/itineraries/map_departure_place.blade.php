<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Itinerary</title>

        <!-- Fonts -->
        <link href="https:fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('/css/map_departure_place.css')  }}" >
         <!--ページトップリンク-->
        <link rel="stylesheet" type="text/css" href="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/reset.css">
        <!--アイコン表示-->
        <script src="https://kit.fontawesome.com/af4a7db726.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <header>
            <div class="header-title"><h1>旅のしおり</h1></div>
            <div class="header-right">
                <ul>
                    <li>{{ $auth->name }}</li>
                    <li><a href="/itineraries/logout">ログアウト</a></li>
                </ul>
            </div>
        </header>
        <!--出発地を選択-->
        <div class ="containers">
            <h1>以下から出発地を選択してください</h1> 
            @foreach ($place_details as $place_detail)
            <div class="container">
                <form action="/itineraries/{{ $detail->id }}/departure_place_store" method="POST">
                    @csrf
                    <h2>{{$place_detail[1]}}</h2>
                    <input type="hidden" name="departure[departure_place_address]" value={{$place_detail[0]}}>
                    <input type="hidden" name="departure[departure_place_name]" value={{$place_detail[1]}}>
                    <input type="hidden" name="departure[detail_id]" value={{$detail->id}}>
                    <input class="btn" type="submit" value="ここを出発地として保存する">
                    <br>
                    <br>
                    <iframe id='map' src='https://www.google.com/maps/embed/v1/place?key={{ config("services.google-map.apikey") }}&q={{ $place_detail[1] }}'
                    width='50%' height='300' frameborder='0'></iframe>
                </form>
            </div>
            @endforeach
        </div>
         <!--ページトップリンク-->
        <footer id="footer">
            <p id="page-top"><a href="#">Page Top</a></p> 
        </footer>
        <!--ページトップリンク-->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="{{ asset('/js/page_top_link.js') }}"></script>
    </body>
</html>