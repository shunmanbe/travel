
        @extends('layouts.app')
        @section('content')
        <form action="/itineraries/new_entry/date_store" method="POST">
            @csrf
            <!--//出発日を入力-->
            <a>出発日</a>
            <input type="date" name="date[departure_date]">
            <br>
            <a>到着日</a>
            <input type="date" name="date[end_date]">
            
            <input type="submit" value="次へ">
        </form>
       
        @endsection
    