@extends('layouts.app')
@section('content')
<div id="map" style="height:500px">
</div>
<!--<script src="{{ asset('js/map.js') }}"></script>-->
<!--<script src="https://maps.googleapis.com/maps/api/js?key={{ config("services.google-map.apikey") }}&callback=initMap" async defer></script>-->


<script src="{{ asset('js/map_route.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ config("services.google-map.apikey") }}&callback=initMap" async defer></script>
@endsection