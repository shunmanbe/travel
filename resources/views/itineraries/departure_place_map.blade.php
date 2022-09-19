<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>Placeサーチ</title>
    <style>
      #header {
    	  background-color: darkblue;
    	  padding: 3px;
    	  width: 1195px;
          font-family: Meriyo UI;
          font-size: 14px;
    	  color: white;
      }
      #target {
        width: 1200px;
        height: 700px;
      }
    </style>
  </head>

  <body>
   <div id="map" style="width: 600px; height: 500px;"></div>
   <script>
function initMap() {
 
  var target = document.getElementById('map'); //マップを表示する要素を指定
  var address = '東京都新宿区西新宿2-8-1'; //住所を指定
  var geocoder = new google.maps.Geocoder();  

  geocoder.geocode({ address: address }, function(results, status){
    if (status === 'OK' && results[0]){

      console.log(results[0].geometry.location);

       var map = new google.maps.Map(target, {  
         center: results[0].geometry.location,
         zoom: 18
       });

       var marker = new google.maps.Marker({
         position: results[0].geometry.location,
         map: map,
         animation: google.maps.Animation.DROP
       });

    }else{ 
      //住所が存在しない場合の処理
      alert('住所が正しくないか存在しません。');
      target.style.display='none';
    }
  });
}
</script>
<script src="//maps.google.com/maps/api/js?key=AIzaSyCcEeP3VafNyir1xC4fcIxtDlqGMo3xn34&callback=initMap"></script>
  </body>
</html>