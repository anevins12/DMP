<!DOCTYPE html>

<?php
//
//	include_once(  dirname(__FILE__) . '/../../controller/tweets.php' );
//
//	$tweets = new Tweets();
//	$allTweets = $tweets->index();
//
//	$graphData = $tweets->getGoogleLineGraphFormat($allTweets);
//	$day1 = $graphData[1];
//	$day2 = $graphData[2];
//	$day3 = $graphData[3];
//	$day4 = $graphData[4];
//	$day5 = $graphData[5];
//	$day6 = $graphData[6];
//	$day7 = $graphData[7];
//	$day8 = $graphData[8];


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
		<script type="text/javascript" src="/application/assets/js/d3.v2.js" language="javascript"></script>
	</head>

	<body id="cities" class="interaction">
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
				<nav class="grid_12 alpha" id="breadcrumbs">
					<ul>
						<li><span class="home icon"></span><span class="txt"><a href="/application/view/">Home</a></span></li>
						<li><span class="separator">&raquo;</span><span class="cities icon"></span><span class="txt">Happiest Cities</span></li>
					</ul>
				</nav>
				<div class="grid_8 alpha testArea">
					<img src="/application/assets/i/happiest-cities-3.png" alt="" />
				</div>
				<div class="grid_4">
					<div id="key">
						<h3>Key</h3>
						<img src="/application/assets/i/happiest-cities-2.png" alt="" />
					</div>
					<div class="" id="description">
						<p>
						Lorem ipsum dolor sit amet, consectetur adipiscing elit.
						</p>
						<p>
						Vivamus cursus ultrices urna, vitae consequat massa suscipit eget. Aliquam erat volutpat.
						</p>
						<p>
						In hac habitasse platea dictumst. Aliquam erat volutpat. Duis id erat mi. Ut nec dui leo, eu molestie ante.
						</p>
						<p>
						Mauris risus odio, vestibulum at convallis vitae, vehicula eu.
						</p>
					</div>
					<a class="interaction" href="/application/view/happiest-cities/"></a>
					
				</div>

		</div>

		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script type="text/javascript" src="/application/assets/js/modernizr-2.5.3.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js" type="text/javascript" language="javascript"></script>
		<script type="text/javascript" src="/application/assets/js/scripts.js" language="javascript"></script>
<!--		<script type="text/javascript" src="https://www.google.com/jsapi"></script>-->
		<script type="text/javascript">
//
//		var dataset = [ 5, 10, 15, 20, 25 ];
//		var h = 200;
//		$i = 0;
//
//		var svg = d3.select(".testArea")
//		.append("svg")
//		.attr("width", "500")
//		.attr("height", "500");
//
//		var circles = svg.selectAll("circle")
//		.data(dataset)
//		.enter()
//		.append("circle");
//
//		circles.append("a")
//		.attr("class", "more-info")
//		.text("i");
//
//		circles.attr("cx", function(d, i) {
//			return (i * 100) + 25;
//		})
//		.attr("cy", h/2)
//		.attr("r", function(d) {
//			return d * 3;
//		})
//		.attr("fill", "yellow")
//		.attr("stroke", "#ccc")
//		.attr("stroke-width", function(d){
//			return d / 4;
//		})






		jQuery(document).ready(function($) {
			$('header nav a.selected').hover(function(){
				$('header nav a.selected .arrow').toggleClass('show');
				$('#main').toggleClass('selected');
			});
			$('.submenu').hover(function() {
				$(this).siblings().toggleClass('hover');
				$(this).hover().parent().children('a').children('.pointer').toggleClass('hover');
			});

		});

		</script>
	</body>
</html>