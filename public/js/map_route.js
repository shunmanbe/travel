// 地図初期化
var map = new google.maps.Map(document.getElementById("map"), {
    zoom : 10,
    center: new google.maps.LatLng(35.7, 139.7),
    mayTypeId: google.maps.MapTypeId.ROADMAP
});

var directionsService = new google.maps.DirectionsService;
var directionsRenderer = new google.maps.DirectionsRenderer;

// ルート検索を実行
directionsService.route({
    origin: "東京駅",
    destination: "新宿駅",
    travelMode: google.maps.TravelMode.DRIVING
}, function(response, status) {
    console.log(response);
    if (status === google.maps.DirectionsStatus.OK) {
        // ルート検索の結果を地図上に描画
        directionsRenderer.setMap(map);
        directionsRenderer.setDirections(response); 
    }
});