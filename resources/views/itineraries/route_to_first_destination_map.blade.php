
@extends('layouts.app')
@section('content')
<div id="map" style="height:500px">
</div>
<script src="{{ asset('js/map.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD91s6aXkYPulQ6o1jAlvpuZPmlL51rWq8&callback=initMap" async defer></script>
@endsection