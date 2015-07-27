<?php
require_once('../lib/Activity.php');
$firstAct = new Activity('activity_600703191.gpx');
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
  <script type="text/javascript">
    var coords = <?php echo $firstAct->getJson();?>;
  </script>
  <script type="text/javascript">
    var hrData = [['Time', 'HR']];

    for (var i in coords.points) {
      var point = coords.points[i];
      hrData.push([point.time, point.hr]);
    }
    // Load the Visualization API and the piechart package.
    google.load('visualization', '1.0', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);

    // Callback that creates and populates a data table,
    // instantiates the pie chart, passes in the data and
    // draws it.
    function drawChart() {
      var data = google.visualization.arrayToDataTable(hrData);

      var options = {
        title: 'HR',
        hAxis: {title: 'Time',  titleTextStyle: {color: '#333'}}
      };

      var chart = new google.visualization.AreaChart(document.getElementById('hr_chart_div'));
      chart.draw(data, options);
    }
  </script>
</head>
<body>
<div id="hr_chart_div"></div>
</body>
</html>