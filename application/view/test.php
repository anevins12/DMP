<!DOCTYPE html">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Tweets</title>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js" type="text/javascript"></script>
	<script src="modernizr.custom.17633.js" type="text/javascript"></script>
	<script src="../polymaps/polymaps.min.js" type="text/javascript"></script>
	<script src="../polymaps/nns.min.js" type="text/javascript"></script>
	<script src="../assets/js/scripts.js" type="text/javascript"></script>
	<link type="text/css" href="../assets/css/style.css" />
</head>

<body>

	<h1>Testing Tweets</h1>

	<?php

	include_once('../controller/tweets.php');

	?>
	<div id="map">
		<script>
			polymaps();
		</script>
	</div>

</body>

</html>