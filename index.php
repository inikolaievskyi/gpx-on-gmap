<?php
$gpxFile = "woltersdorf.gpx";

if (!empty($gpxFile)) {
  $path = 'gpxFiles/'.$gpxFile;

  if (file_exists($path)) {
    $xml = simplexml_load_file($path);
    $title = $xml->trk->name;

    $coords = '';
    $i = 0;
    foreach ($xml->trk->trkseg->trkpt as $point) {
      $i++;

      $attr = $point->attributes();
      $lat = (array)$attr->lat;
      $lon = (array)$attr->lon;

      $coords .= '{"lat":' . $lat[0] . ', "lng":' . $lon[0] . '},';
//      if($i > 5) {
//        break;
//      }
    }
  } else {
    exit('Cannot load gpx file!');
  }

}
?>

<!DOCTYPE html>
<html>
<head>
  <style type="text/css">
    html, body, #map-canvas { height: 100%; margin: 0; padding: 0;}
  </style>
  <script type="text/javascript"
          src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCMdiOluGYwLD5NhjmIMXXOBqR7fBUvcCA">
  </script>
  <script type="text/javascript">
    var flightPath;
    var map;
    var coords = [<?php echo $coords;?>];
    function initialize() {

      var start = { lat: 50.38488797843456, lng: 30.467951400205493};
      var mapOptions = {
        center: start,
        zoom: 14,
        mapTypeId: google.maps.MapTypeId.TERRAIN
      };
      map = new google.maps.Map(document.getElementById('map-canvas'),
        mapOptions);

      var marker = new google.maps.Marker({
        position: start,
        map: map,
        title: 'This is a start'
      });
      var flightPlanCoordinates = coords;

      setInterval(function(){
        marker.setPosition(coords[0]);
        coords.shift();
      }, 10);


      flightPath = new google.maps.Polyline({
        path: flightPlanCoordinates,
        strokeColor: '#FF0000',
        strokeOpacity: 1.0,
        strokeWeight: 2
      });

      addLine();
    }

    function addLine() {
      flightPath.setMap(map);
    }

    function removeLine() {
      flightPath.setMap(null);
    }
    google.maps.event.addDomListener(window, 'load', initialize);
  </script>
</head>
<body>
<div id="map-canvas"></div>
</body>
</html>