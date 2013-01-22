<!DOCTYPE html>

<?php

	include_once( dirname(__FILE__) . '/../../../controller/tweets.php' );

	$tweets = new Tweets();
	$allTweets = $tweets->index();


	// testing functions

?>
<html>
	<head>
		<title></title>
		<link type="text/css" rel="stylesheet" href="/application/assets/css/resets.css" />
		<link type="text/css" rel="stylesheet" href="/application/assets/css/fonts.css" />
		<link type="text/css" rel="stylesheet" href="/application/assets/css/960_12_col.css" />
		<link type="text/css" rel="stylesheet" href="/application/assets/css/nav.css" />
		<link type="text/css" rel="stylesheet" href="/application/assets/css/style.css" />
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" language="javascript"></script>
		<script type="text/javascript" src="http://d3js.org/d3.v3.min.js" language="javascript"></script>
		<script type="text/javascript" src="/application/assets/js/geom.js" language="javascript"></script>
	</head>

	<body id="cities">
	<div class="container_12">
				<header>
					<hgroup class="logo grid_6">
						<h1><a href="/application/view/">How Happy</a></h1>
						<h2>Measuring Happiness in the UK from Twitter</h2>
					</hgroup>
					<nav class="grid_6">
						<ul>
							<li class="grid_2 alpha">
								<a href="/application/view/">
									<span class="home"></span>
									<span class="txt">Home</span>
									<div class="arrow">
										<div class="tip"></div>
									</div>
								</a>
							</li>
							<li class="grid_2">
								<a href="/application/view/happiest-cities" class="selected">
									<span class="cities"></span>
									<span class="txt">Happiest Cities</span>
									<div class="arrow">
										<div class="tip"></div>
									</div>
								</a>
							</li>
							<li class="grid_2 omega">
								<a href="/application/view/moodgraphs/" class="dropdown">
									<span class="graphs"></span>
									<span class="txt">Mood Graphs</span>
									<span class="pointer"></span>
									<div class="arrow">
										<div class="tip"></div>
									</div>
								</a>
								<div class="submenu">
									<ul>
										<li>
											<a href="/application/view/moodgraphs/halloween-and-fireworks/">
												<span class="halloween"></span>
												Halloween <br />&amp; Fireworks
											</a>
										</li>
										<li>
											<a href="/application/view/moodgraphs/christmas/" class="christmas">
												<span class="christmas"></span>
												Christmas
											</a>
										</li>
									</ul>
								</div>
							</li>
						</ul>
					</nav>
				</header>
			</div>
			<div class="container_12" id="main">
				<div class="grid_12 alpha omega">
					<nav id="breadcrumbs">
						<ul>
							<li><span class="home icon"></span><span class="txt"><a href="/application/view/">Home</a></span></li>
							<li><span class="separator">&raquo;</span><span class="cities icon"></span><span class="txt">Happiest Cities</span></li>
						</ul>
					</nav>
					<ul class="tabContainer">
						<!-- The jQuery generated tabs go here -->
					</ul>
				</div>

				<div class="" id="options">
					<h2>The Happiest Cities in the United Kingdom</h2>
					<h3>Based on Tweets gathered from the 29th Oct - 6th Nov</h3>
					<h4>Sentiment Values: 9.0 Happiest | 0.0 Saddest</h4>
				</div>
<!--				<form method="get" name="search" onsubmit="findCity(this.form)">
					<input type="text" name="keyword" value="Search a city" onblur="if (this.value == '') {this.value = 'Search a city';}" id="keyword"
                                                     onfocus="if (this.value == 'Search a city') {this.value = '';}" />
				</form>-->
				<script type="text/javascript">

					function findCity(form) {

						var keyword = $("#keyword").val();
						var circles = $("circle");

						for (var i = 0; i < circles.length; i++ ) {
							
							if ( circles[i].getAttribute('id') == keyword ) {
								circles[i].setAttribute('class', 'selected');
							}
						}


					}


				</script>
				<div class="grid_12 omega alpha testArea" id="contentHolder">
					
					<div id="contentHolder">
						<!-- The AJAX fetched content goes here -->
					</div>

				</div>
				<div class="grid_4">
					<div id="key">
						<h3>Key</h3>
						<img src="/application/assets/i/happiest-cities-2.png" alt="" />
					</div>
					<div class="" id="description">
						<p>
						Based on tweets from Twitter, this Data Visualisation shows the happiest cities of the United Kingdom.
						</p>
						<p>
							Tweets were retrieved from the 29th of October to the 5th of November.
							Sentimental values have been averaged from this entire time frame.
						</p>
						<p>
							As you can see, there isn't much deviation. You can explore this in more detail on the <a href="/application/view/moodgraphs/halloween-and-fireworks/">Halloween and Fireworks Mood Graph</a>.
						</p>
					</div>
					
				</div>
				<div class="grid_8" id="test">
					
				</div>

			</div>


		<script type="text/javascript" src="/application/assets/js/scripts.js" language="javascript"></script>
<!--		<script type="text/javascript" src="https://www.google.com/jsapi"></script>-->
		<script>happiestCities()

			
		</script>

	</body>
</html>