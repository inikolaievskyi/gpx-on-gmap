<?php
require_once('../lib/Activity.php');
$firstAct = new Activity('activity_600703191.gpx');
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="../css/style.css">

  <script type="text/javascript"
          src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCMdiOluGYwLD5NhjmIMXXOBqR7fBUvcCA">
  </script>
  <script type="text/javascript">
    var coords = <?php echo $firstAct->getJson();?>;
  </script>
  <script type="text/javascript"
          src="../script/script.js">
  </script>
</head>
<body>
<div id="map-canvas"></div>
</body>
</html>