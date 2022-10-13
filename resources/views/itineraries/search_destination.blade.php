<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>旅のしおり</title>

        <!-- Fonts -->
        <link href="https:fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('/css/search_departure_place.css')  }}" >
        <!--アイコン表示-->
        <script src="https://kit.fontawesome.com/af4a7db726.js" crossorigin="anonymous"></script>
        <!--ヘッダー-->
        <link rel="stylesheet" href="{{ asset('/css/header.css')  }}" >
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
        <!--目的地を選択-->
        <div class="container">
            <h1>目的地を検索</h1> 
            <form action="/itineraries/{{$detail->id}}/destination_map" method="POST">
                @csrf
                <input type="text" name="search_name" placeholder="例：東京スカイツリー"　value="{{ old('search_name') }}">
                <p class="serch_name__error" style="color:red">{{ $errors->first('search_name') }}</p>
                <input type="submit" value="検索">
            </form>
        </div>
    </body>
</html>
