<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Itinerary</title>

        <!-- Fonts -->
        <link href="https:fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('/css/departure_date.css')  }}" >
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
                    <li><i class="fa-solid fa-user"></i> {{ $auth->name }}</li>
                    <li><a href="/itineraries/logout">ログアウト</a></li>
                </ul>
            </div>
        </header>
        <div class = "container">
            <form action="/itineraries/{{$detail->id}}/new_entry/update" method="POST">
                @csrf
                @method('PUT')
                <!--//出発日を入力-->
                <a>旅行タイトル</a>
                <br>
                <input type="text" name="initial_setting[title]" value="{{ old('initial_setting.title') }}">
                <br>
                <p class="title__error" style="color:red">{{ $errors->first('initial_setting.title') }}</p>
                <br>
                <a>出発日</a>
                <input type="date" name="initial_setting[departure_date]" value="{{ old('initial_setting.departure_date') }}">
                <br>
                <p class="departure_date__error" style="color:red">{{ $errors->first('initial_setting.departure_date') }}</p>
                <br>
                <a>到着日</a>
                <input type="date" name="initial_setting[end_date]" value="{{ old('initial_setting.end_date') }}">
                <br>
                <p class="end_date__error" style="color:red">{{ $errors->first('initial_setting.end_date') }}</p>
                <br>
                <br>
                <input class ="btn" type="submit" value="次へ">
            </form>
        </div>
        
       
        
    </body>
</html>
