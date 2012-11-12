<!DOCTYPE html">
<?php

	include_once(  dirname(__FILE__) . '/../controller/tweets.php' );

	$tweets = new Tweets();
	$allTweets = $tweets->index();

	$graphData = $tweets->getGoogleLineGraphFormat($allTweets);
	$day1 = $graphData[1];
	$day2 = $graphData[2];
	$day3 = $graphData[3];
	$day4 = $graphData[4];
	$day5 = $graphData[5];
	$day6 = $graphData[6];
	$day7 = $graphData[7];
	$day8 = $graphData[8];


	// testing functions

	?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Tweets</title>
	<link type="text/css" href="../assets/css/style.css" rel="stylesheet" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js" type="text/javascript" language="javascript"></script>
	<script type="text/javascript" src="../assets/js/scripts.js" language="javascript"></script>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript">
	 google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Time', 'Sentiment (normalised) '],
          ['2012-10-30',  <?php echo $day1 ?>],
          ['2012-10-31',  <?php echo $day2 ?>],
          ['2012-11-01',  <?php echo $day3 ?>],
		  ['2012-11-02',  <?php echo $day4 ?>],
		  ['2012-11-03',  <?php echo $day5 ?>],
		  ['2012-11-04',  <?php echo $day6 ?>],
		  ['2012-11-05',  <?php echo $day7 ?>],
		  ['2012-11-06',  <?php echo $day8 ?>]
        ]);

        var options = {
          title: 'Halloween to Fireworks Night Mood Graph'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart'));
        chart.draw(data, options);
      }
	</script>

</head>

<body>

	<h1>Testing Area</h1>

	<div class="testArea">
	
	<div id="chart">
	</div>
	
	</div>
</body>
	
</html>