<?php
require_once('lib/Activity.php');

$firstAct = new Activity('activity_600703191.gpx');
$secondAct = new Activity('20150426_060230.gpx');

$firstHr = $firstAct->combineHr();
$secondHr = $secondAct->combineHr();

$data = [];
foreach ($firstHr as $key => $hr) {
    $data[] = "['" .$key. "', $hr, " . (array_key_exists($key,$secondHr) ? $secondHr[$key] : 0) . "]";
  }

$jsValue = implode(",", $data);
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="css/style.css">

  <script type="text/javascript"
          src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCMdiOluGYwLD5NhjmIMXXOBqR7fBUvcCA">
  </script>
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
  <script type="text/javascript">
    var coords = <?php echo $firstAct->getJson();?>;
    var coords2 = <?php echo $secondAct->getJson();?>;
  </script>
  <script type="text/javascript"
          src="script/script.js">
  </script>
  <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
  <script type="text/javascript">

    // Load the Visualization API and the piechart package.
    google.load('visualization', '1.0', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);

    // Callback that creates and populates a data table,
    // instantiates the pie chart, passes in the data and
    // draws it.
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Time', 'HR', 'HR2'],
          <?php echo $jsValue; ?>
        ]);

        var options = {
          title: 'HR',
          hAxis: {title: 'Time',  titleTextStyle: {color: '#333'}, format: '##:##:##'}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
  </script>
</head>
<body>
<div id="map-canvas"></div>
<div id="info-table">
  <table>
    <tr>
      <th>HR</th>
      <th>Altitude</th>
    </tr>
    <tr>
      <td id="hr-value">0</td>
      <td id="altitude-value">0</td>
    </tr>
  </table>
</div>

<!--Div that will hold the pie chart-->
<div id="chart_div"></div>
</body>
</html>