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
		
	<div id="intro">
		<h2>Explore the Christmas spirit of 2012</h2>
	</div>

	<div id="desc">

	<h2>Quick Explanation</h2>
	<p>This webpage illustrates feelings of each main city of the United Kingdom, that was recorded from December 22 - December 29 2012.</p>
	<ul>
		<li>Feelings are:
			<ul>
				<li>Represented in grayscale.
				<li>The brighter the gray, the happier the feeling. The darker the gray, the more sad the feeling
				</li>
				<li>
					Feelings are also represented in numeric values, from 0 to 10. 
					<ul>
						<li>0 represents the worst feeling and 10 the happiest.</li>
						<li>Smiley faces illustrate these values.</li>
					</ul>
				</li>
			</ul>
		</li>
	</ul>

	</div>

	<div id="cities">

		<div id="christmas-bubble">
		</div>

		<h1>christmas spirit</h1>
		<h2>data gathered from UK-based tweets of twitter</h2>
		
	</div>
		
	<div id="quantities">

		<div class="desc">
			<p>Out of 5002 tweets</p>
<!--			<p>
				Feelings are represented in grayscales. The brighter the gray, the happier the feeling. The darker the gray, the more sad the feeling
			</p>
			<p>
				Feelings are also represented in numeric values, from 0 to 10. Zero represents the worst feeling and Ten the happiest.
			</p>
			<p>
				Smiley faces have been used to help communicate the feeling of these 0 to 10 values.
			</p>-->
		</div>

	</div>

	<div id="tags">
		<h2>Sad Tweet Tags</h2>
		<span class="pointer"></span>
		<div id="tagCloud">

		</div>
	</div>


		<script type="text/javascript" src="/application/assets/js/cloud.js" language="javascript"></script>
		<script type="text/javascript" src="/application/assets/js/d3.layout.cloud.js" language="javascript"></script>

		<script type="text/javascript" src="/application/assets/js/scripts.js" language="javascript"></script>
		<script type="text/javascript" src="/application/assets/js/sprintf.js" language="javascript"></script>
<!--		<script type="text/javascript" src="https://www.google.com/jsapi"></script>-->

		<script>
			var data = <?php echo $allTweets ?>;
			happiestCitiesImproved(data);
			tagCloud();

			//http://bl.ocks.org/3887193
			var width = 400,
				height = 400,
				radius = Math.min(width, height) / 2;

			var color = d3.scale.ordinal()
				.range(["#3c3c3c", "#5B5B5B", "#727272", "#848484", "#969696", "#A8A8A8", "#BABABA"]);

			var arc = d3.svg.arc()
				.outerRadius(radius - 10)
				.innerRadius(radius - 70);

			var pie = d3.layout.pie()
				.sort(null)
				.value(function(d) { return d.tweets; });

			var svg = d3.select("#quantities").append("svg")
				.attr("width", width)
				.attr("height", height)
			  .append("g")
				.attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

			d3.csv("../../assets/csv/tweet_quantities.csv", function(data) {

			  data.forEach(function(d) {
				d.tweets = +d.tweets;
			  });

			  var g = svg.selectAll(".arc")
				  .data(pie(data))
				.enter().append("g")
				  .attr("class", "arc");

			  g.append("path")
				  .attr("d", arc)
				  .style("fill", function(d) { return color(d.data.sentiment); });

			  g.append("text")
				  .attr("transform", function(d) { return "translate(" + arc.centroid(d) + ")"; })
				  .attr("dy", ".35em")
				  .style("fill", "#fff")
				  .style("text-anchor", "middle")
				  .text(function(d) { return d.data.sentiment; });

			});



		</script>

</body>
</html>