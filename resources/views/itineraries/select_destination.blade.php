@extends('layouts.app')
@section('content')
<!--出発地を選択-->
<h1>以下から目的地を選択してください</h1> 
@foreach ($place_details as $place_detail)
<form action="/itineraries/{{ $detail->id }}/destination_store/{{ $place->id }}" method="POST">
    @csrf
    <h2>{{$place_detail[1]}}</h2>
    <input type="hidden" name="destination[destination_address]" value={{$place_detail[0]}}>
    <input type="hidden" name="destination[destination_name]" value={{$place_detail[1]}}>
    <input type="hidden" name="destination[detail_id]" value={{$detail->id}}>
    <p><input type="submit" value="ここを目的地として保存する"></p>
    <iframe id='map' src='https://www.google.com/maps/embed/v1/place?key={{ config("services.google-map.apikey") }}&q={{ $place_detail[1] }}'
    width='50%' height='300' frameborder='0'></iframe>
</form>
@endforeach
@endsection