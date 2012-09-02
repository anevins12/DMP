<!DOCTYPE html">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Tweets</title>
</head>

<body>

	<h1>Testing Tweets</h1>
	
	<?php

	include_once('../controller/tweets.php');

	$tweets = new Tweets;
	$tweets->findContinents();

	?>
	
</body>
	
</html>