<!DOCTYPE html">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Tweets</title>
	<link type="text/css" href="../assets/css/style.css" rel="stylesheet" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js" type="text/javascript" language="javascript"></script>
	<script src="http://maps.google.com/maps?file=api&v=2&key=ABQIAAAAjU0EJWnWPMv7oQ-jjS7dYxQGj0PqsCtxKvarsoS-iqLdqZSKfxRdmoPmGl7Y9335WLC36wIGYa6o5Q&sensor=false" type="text/javascript" language="javascript"></script>
	<script type="text/javascript" src="../assets/js/raphael.min.js" language="javascript"></script>
	<script type="text/javascript" src="../assets/js/cartographer.min.0.4.js" language="javascript"></script>
	<script type="text/javascript" src="../assets/js/scripts.js" language="javascript"></script>
</head>

<body onload="cartograph()" onunload="GUnload()">

	<h1>Testing Map</h1>

	<div class="testArea">
	<?php 
	
	include_once( '../controller/tweets.php' );
	
	$tweets = new Tweets();
	$allTweets = $tweets->index();
	

	// testing functions

	?>
	<div id="map">
	</div>
	
	</div>
</body>
	
</html>