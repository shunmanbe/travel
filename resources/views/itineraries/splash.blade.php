<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Itinerary</title>

        <!-- Fonts -->
        <link href="https:fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('/css/search_departure.css')  }}" >

    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
<!--==============レイアウトを制御する独自のCSSを読み込み===============-->
  <link href="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/reset.css" rel="stylesheet">
  <link href="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/4-1-1/css/4-1-1.css" rel="stylesheet">
   <link rel="stylesheet" type="text/css" href="{{ asset('/css/top.css') }}" >
</head>

<body>

  <div id="splash">
    <div id="splash_text"></div>
  </div>

  <main>
        <div id="container">
        <!--   @extends('layouts.app')-->
        <!--  @section('content')-->
        <!--出発地を選択-->
        <!--<div class ="select">-->
        <!--    <h1>出発する地域を検索</h1> -->
        <!--    <form action="/itineraries/{{$detail->id}}/departure_place_map" method="POST">-->
        <!--        @csrf-->
        <!--        <input type="search_name" name="search_name" placeholder="例：東京 マック"　value="{{ old('search_name') }}">-->
        <!--        <p class="serch_name__error" style="color:red">{{ $errors->first('search_name') }}</p>-->
        <!--        <input type="submit" value="検索">-->
        <!--    </form>-->
        <!--</div>-->
        <!--@endsection-->
        </div>
  </main>
<!--==============JQuery読み込み===============-->
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://rawgit.com/kimmobrunfeldt/progressbar.js/master/dist/progressbar.min.js"></script>
<!--IE11用-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-standalone/6.26.0/babel.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/6.26.0/polyfill.min.js"></script>
<!--自作のJS-->
<script src="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/4-1-1/js/4-1-1.js"></script>
<script src="{{ asset('/js/4-1-1.js') }}"></script>
</body>
</html>