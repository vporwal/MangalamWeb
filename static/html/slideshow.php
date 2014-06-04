<?php
/*
 * Created on 09-Aug-2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<html>
<body>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB3ZWrOTYOKyIhHktV0hEAWG_iJW3dQcBE&amp;sensor=false">
<div id="map-canvas">
</div>

<script>

var geocoder;
  var map;
  var infowindow = new google.maps.InfoWindow();
  var marker;
  geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(40.730885,-73.997383);
    var mapOptions = {
      zoom: 8,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
    
  function codeLatLng() {
    var input = "40.730885,-73.997383";
    var latlngStr = input.split(",",2);
    var lat = parseFloat(latlngStr[0]);
    var lng = parseFloat(latlngStr[1]);
    var latlng = new google.maps.LatLng(lat, lng);
    geocoder.geocode({'latLng': latlng}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        if (results[1]) {
         // map.setZoom(11);
          marker = new google.maps.Marker({
              position: latlng,
              map: map
          });
          infowindow.setContent(results[1].formatted_address);
          infowindow.open(map, marker);
        }
      } else {
        alert("Geocoder failed due to: " + status);
      }
    });
  }

	function showMap() {
		codeLatLng();
	}
</script>


</body>
</html>