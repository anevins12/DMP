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
				<div class="grid_12" id="test">

				</div>

			</div>

		<script type="text/javascript" src="/application/assets/js/cloud.js" language="javascript"></script>
		<script type="text/javascript" src="/application/assets/js/d3.layout.cloud.js" language="javascript"></script>

		<script type="text/javascript" src="/application/assets/js/scripts.js" language="javascript"></script>
<!--		<script type="text/javascript" src="https://www.google.com/jsapi"></script>-->
		<script>

			d3.json("../../../assets/json/tweetTags.json", function(error, json) {
  if (error) return console.warn(error);

  var fill = d3.scale.category20();

  d3.layout.cloud().size([800, 1200])
      .words(json.map(function(d) {;
            return {text: d.word, size: d.sentiment * 40, tweet: d.tweet};
       }))
      .rotate(function(d) { return ~~(Math.random() * 2) * 90; })
      .font("Impact")
      .fontSize(function(d) { return d.size; })
      .on("end", draw)
      .start();

  function draw(words) {
      d3.select("#test").append("svg")
          .attr("width", 1200).attr("height", 1200)
          .append("g").attr("transform", "translate(500,700)")
          .selectAll("text").data(words)
          .enter().append("text")
          .style("font-size", function(d) { return d.size + "px"; })
          .style("font-family", "Impact")
          .style("fill", function(d, i) { return fill(i); })
          .attr("text-anchor", "middle")
          .attr("transform", function(d) {
              return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
          })
          .text(function(d) { return d.text; }).append("svg:title")
          .text(function(d) { return d.tweet; } );
      }
})


		</script>

	</body>
</html>