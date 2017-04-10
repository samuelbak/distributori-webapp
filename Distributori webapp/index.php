<!DOCTYPE html>
<html>
  <head>
    <style>
       #map {
        height: 100vh;
        width: 100vw;
       }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <script>
      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
        	center: new google.maps.LatLng(-33.863276, 151.207977),
          	zoom: 2
        });
        getData(map);
      }

      function getData(map){
    	  var requestURL = 'http://localhost/util/GetData.php';
    	  var request = new XMLHttpRequest();
    	  request.open('GET', requestURL);
    	  request.responseType = 'json';
    	  request.send();
    	  request.onload = function(){
				var data = request.response;
				CreateMarker(data, map);
       		}
      }

      function CreateMarker(jsonData, map){
			//var locations = jsonData['idImpianto'];
			//var locations = JSON.parse(jsonData);
          	//for(i = 0; i < Object.keys(jsonData).length; i++){
       		
          	for(x in jsonData){
		    	  var position = {lat: parseFloat(jsonData[x].Latitudine), lng: parseFloat(jsonData[x].Longitudine)};
		    	  var marker = new google.maps.Marker({
		              position: position,
		              map: map
		            });
          	}
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAI6npnOVX6Y1j2aUKN5Ajh0crVze5B7G8&callback=initMap">
    </script>
  </body>
</html>