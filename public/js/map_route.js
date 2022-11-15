function initMap() { 
  // 地図を生成して表示
  const map = new google.maps.Map(document.getElementById("gmap"), {
    zoom: 13,
    mapTypeId: "roadmap"
  });
  //DirectionsService のオブジェクトを生成
  const directionsService = new google.maps.DirectionsService();
  
  //DirectionsRenderer のオブジェクトを生成
  const directionsRenderer = new google.maps.DirectionsRenderer();
  
  //directionsRenderer と地図を紐付け
  directionsRenderer.setMap(map); 
  
  // ルートを取得するリクエスト
  const request = {
    origin: start_name, // 出発地点
    destination: goal_name, // 到着地点
    travelMode: travel //トラベルモード
  };
  
  function timeRequired(response, status) {
	    if(status == "OK") 
	    {
        for (var i = 0; i < origins.length; i++)
        {
          var results = response.rows[i].elements;
          for (var j = 0; j < results.length; j++) 
          {
            var element = results[j];
            var distance = element.distance.text;
            var duration = element.duration.text;
            var from = origins[i];
            var to = destinations[j];
            var routeTime = document.getElementById("route-time");
            routeTime.innerHTML = "およそ" + duration + "で着きます"
	         }
        }
	    }  
   }
  
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