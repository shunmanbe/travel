<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Itinerary</title>

        <!-- Fonts -->
        <link href="https:fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

      
    </head>
    <body>
        @extends('layouts.app')
        @section('content')
        <!--出発地を選択-->
        <p>出発する地域を選択</p> 
         <div id="map" style="height: 600px; width: 100%;"></div>
   <script>
        function getMapScript() {
            var defer = $.Deferred();
            $.ajax({
                type: 'GET',
                url: 'https://navitime-maps.p.rapidapi.com/map_script?host=localhost',
                dataType: 'text script',
                cache: true,
                headers: {
                    'x-rapidapi-key': '0444b05fb0msh9a9450ced6cf9d2p18a306jsnadbaa28f76d4'
                },
                success: function(response) {
                    console.log("success");
                    defer.resolve();
                },
                error: function(response) {
                    console.log("error");
                    defer.reject();
                }
            });
            return defer.promise();
        }

        // Must be done after getMapScript() is completed.
        function init() {
            console.log("init");
            var displayMap = getMapScript();
            displayMap.done(function() {
                console.log("display map");
                var map = new navitime.geo.Map('map', new navitime.geo.LatLng('35.681298', '139.766247'), 15, {
                    // Fit to the map display area
                    bounds: new navitime.geo.BoundsInfo(0, $('#map').width(), 0, $('#map').height())
                });
            });
        }
        window.onload = init
   </script>
        @endsection
        
    </body>
</html>
