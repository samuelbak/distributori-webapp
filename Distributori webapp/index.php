<!DOCTYPE html>
<html>
  <head>
  	<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
  	<meta charset="utf-8">
    <meta charset="utf-8">
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
          	zoom: 15
        });
        getData(map);
		//traffic
		var trafficLayer = new google.maps.TrafficLayer();
  		trafficLayer.setMap(map);        
        // Geolocation
       	if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var image = 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png';
            var beachMarker = new google.maps.Marker({
              position: pos,
              map: map,
              icon: image
            });
            var cityCircle = new google.maps.Circle({
                strokeColor: 'red',
                strokeOpacity: 0.35,
                strokeWeight: 1,
                fillColor: 'green',
                fillOpacity: 0.35,
                map: map,
                center: pos,
                radius: 100000
              });
            map.setCenter(pos);
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }
      }

      function getData(map){
    	  var requestURL = './util/GetData.php';
    	  var request = new XMLHttpRequest();
    	  request.open('GET', requestURL);
    	  request.responseType = 'json';
    	  request.send();
    	  request.onload = function(){
				var data = request.response;
				CreateMarkers(data, map);
       		}
      }

      function CreateMarkers(jsonData, map){
          	var markers = new Array();
          	
          	for(x in jsonData){
		    	  var position = {lat: parseFloat(jsonData[x].Latitudine), lng: parseFloat(jsonData[x].Longitudine)};
		    	  var marker = new google.maps.Marker({
		              position: position,
		              map: map
		            });
		          marker.content = jsonData[x].Bandiera;
		          markers.push(marker);
		          var infoWindow = new google.maps.InfoWindow();
		          google.maps.event.addListener(marker, 'click', function() {
			          infoWindow.setContent(this.content);
			          infoWindow.open(this.map, this);
		          });
          	}
          	var markerCluster = new MarkerClusterer(map, markers,
                    {imagePath: 'https://localhost/util/m'});
      }
    </script>
    <script src="./util/markerclusterer.js" type="text/javascript">
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAI6npnOVX6Y1j2aUKN5Ajh0crVze5B7G8&callback=initMap">
    </script>
  </body>
</html>