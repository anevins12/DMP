<!DOCTYPE html>

<?php

	include_once( dirname(__FILE__) . '/../../controller/tweets.php' );

	$tweets = new Tweets();
	$allTweets = $tweets->index();


?>
<html>
	<head>
		<title></title>
		<link type="text/css" rel="stylesheet" href="/application/assets/css/resets.css" />
		<link type="text/css" rel="stylesheet" href="/application/assets/css/fonts.css" />
		<link type="text/css" rel="stylesheet" href="/application/assets/css/960_12_col.css" />
		<link type="text/css" rel="stylesheet" href="/application/assets/css/nav.css" />
		<link type="text/css" rel="stylesheet" href="/application/assets/css/style.css" />
		<style>
			#cities svg circle:hover {
			-webkit-transform: initial;
			}
		</style>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" language="javascript"></script>
		<script type="text/javascript" src="http://d3js.org/d3.v3.min.js" language="javascript"></script>
		<script type="text/javascript" src="/application/assets/js/geom.js" language="javascript"></script>
		<script src="http://mbostock.github.com/d3/talk/20110921/d3/d3.js" language="javascript"></script>
<!--		<script src="http://mbostock.github.com/d3/talk/20110921/d3/d3.layout.js"></script>-->

<meta charset="utf-8">
<style>

circle {
  stroke: #fff;
}

</style>

<script src="http://mbostock.github.com/d3/d3.js?2.7.4"></script>
<script src="http://d3js.org/d3.v2.js"></script>


	</head>

	<body>
	<div id="cities">

		<div id="christmas-bubble">

		</div>

		<h1>happiest cities</h1>
		<h2>data gathered from christmas</h2>
	</div>
		<script type="text/javascript" src="/application/assets/js/scripts.js" language="javascript"></script>
		<script type="text/javascript" src="/application/assets/js/sprintf.js" language="javascript"></script>
<!--		<script type="text/javascript" src="https://www.google.com/jsapi"></script>-->
		<script>
//			happiestCities()


		</script>

		<script>
			var data = <?php echo $allTweets ?>;
			happiestCitiesImproved(data);
		</script>

</body>
</html>