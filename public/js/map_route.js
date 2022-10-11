function initMap() { 
  // 地図を生成して表示
  var map = new google.maps.Map(document.getElementById("gmap"), {
    zoom: 13,
    //center: new google.maps.LatLng(40.750127,-73.981084),  //Madison Av/E 38 St
    mapTypeId: "roadmap"
  });
  //DirectionsService のオブジェクトを生成
  const directionsService = new google.maps.DirectionsService();
  
  //DirectionsRenderer のオブジェクトを生成
  const directionsRenderer = new google.maps.DirectionsRenderer();
  
  //directionsRenderer と地図を紐付け
  directionsRenderer.setMap(map); 
  
  //リクエストの出発点の位置（Empire State Building 出発地点の緯度経度）
  const start = new google.maps.LatLng(40.748541, -73.985758);  
  //リクエストの終着点の位置（Grand Central Station 到着地点の緯度経度）
  const end = new google.maps.LatLng( 40.752741,-73.9772);  
  
  // ルートを取得するリクエスト
  const request = {
    origin: starts,      // 出発地点の緯度経度
    destination: ends,   // 到着地点の緯度経度
    travelMode: travel //トラベルモード（歩き）
  };
  
  //DirectionsService のオブジェクトのメソッド route() にリクエストを渡し、
  //コールバック関数で結果を setDirections(result) で directionsRenderer にセットして表示
  directionsService.route(request, function(result, status) {
    //ステータスがOKの場合、
    if (status === 'OK') {
      directionsRenderer.setDirections(result); //取得したルート（結果：result）をセット
    }else{
      alert("取得できませんでした：" + status);
    }
  });
  
}