<!DOCTYPE html>

<?php

	include_once( dirname(__FILE__) . '/../../controller/tweets.php' );

	$tweets = new Tweets();
	$allTweets = $tweets->index(); 
	$recentTweets = $tweets->getRecentTweets(); 
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
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/jquery-ui.min.js"></script>
	<script src="http://mbostock.github.com/d3/d3.js?2.7.4"></script>
	<script src="http://d3js.org/d3.v2.js"></script>

	</head>

	<body>

	<div id="sidebar">
		<div id="opacity">
		</div>
		<ul>
			<li><a href="#christmas-bubble">Happiest Cities</a></li>
			<li><a href="#tags">Tweet Tags</a></li>
			<li><a href="#recentTweets">Recent Tweets</a></li>
		</ul>
	</div>
	<div id="intro">
		<h2>Explore the Christmas spirit of 2012</h2>
	</div>

	<div id="desc">
		<div class="container">
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
	</div>

	<div id="cities">
		<div class="container">
			<div id="quantities">

				<div class="desc">
					<p>Out of 5002 tweets</p>
				</div>

			</div>
			
			<div id="key">
				<ul>
					<li><span class="circle happy"></span></li><li>Happy City</li>
					<li><span class="circle sad"></span></li><li>Sad City</li>
				</ul>
			</div>
			<div class="bubble">
				<div id="christmas-bubble">
				</div>

				<h1>christmas spirit</h1>
				<h2>data gathered from UK-based tweets of twitter</h2>
			</div>
		</div>
		
	</div>

	<div id="tags">
		<div class="container">
			<div id="sadTagCloud">
				<h2>Sad Tags</h2>
			</div>
			<div id="happyTagCloud">
				<h2>Happy Tags</h2>
			</div>
		</div>
	</div>

	<div id="recentTweets">
		<div class="container">
		<h2>Recent Tweets</h2>
			<ul>
			<?php foreach ( $recentTweets as $tweet ) {?>
				<li>
				<?php
				$imgPath = '../../assets/i/smiley-';
				$imgExt = '.png';
				$tweet->sentiment = (float)$tweet->sentiment;
				$sentiment = $tweet->sentiment;

				if ( $sentiment < 1 ) {
					$img = $imgPath . 0 . $imgExt;
				}
				elseif ( $sentiment < 3 ) {
					$img = $imgPath . 2 . $imgExt;
				}
				elseif ( $sentiment < 4 ) {
					$img = $imgPath . 3 . $imgExt;
				}
				elseif ( $sentiment < 5 ) {
					$img = $imgPath . 4 . $imgExt;
				}
				elseif ( $sentiment < 6 ) {
					$img = $imgPath . 5 . $imgExt;
				}
				elseif ( $sentiment < 7 ) {
					$img = $imgPath . 5 . $imgExt;
				}
				elseif ( $sentiment < 9 ) {
					$img = $imgPath . 8 . $imgExt;
				}
				elseif ( $sentiment < 10 ) {
					$img = $imgPath . 9 . $imgExt;
				}
				echo "<span><img src='$img' alt='feeling' /></span>";
				echo $tweet->tweet_text;
				?> </li>
			<?php } ?>
			</ul>
		</div>
	</div>


		<script type="text/javascript" src="/application/assets/js/cloud.js" language="javascript"></script>
		<script type="text/javascript" src="/application/assets/js/d3.layout.cloud.js" language="javascript"></script>

		<script type="text/javascript" src="/application/assets/js/scripts.js" language="javascript"></script>
		<script type="text/javascript" src="/application/assets/js/sprintf.js" language="javascript"></script>
<!--		<script type="text/javascript" src="https://www.google.com/jsapi"></script>-->

		<script>
			var data = <?php  echo $allTweets['json']; ?>;
			happiestCitiesImproved(data);
			sadTagCloud();
			happyTagCloud();

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
			
			//http://css-tricks.com/scrollfollow-sidebar/
			$(function() {

				var $sidebar   = $("#sidebar"),
					$window    = $(window),
					offset     = $sidebar.offset(),
					topPadding = 15;

				$window.scroll(function() {
					if ($window.scrollTop() > offset.top) {
						$sidebar.stop().animate({
							marginTop: $window.scrollTop() - offset.top + topPadding
						});
					} else {
						$sidebar.stop().animate({
							marginTop: 0
						});
					}
				});

				$('#sidebar a[href^="#"]').bind('click.smoothscroll',function (e) {
					e.preventDefault();
					var target = this.hash;
						$target = $(target);
					$('html, body').stop().animate({
						'scrollTop': $target.offset().top
					}, 500, 'swing', function () {
						window.location.hash = target;
					});
				});
			});


//		  $(function() {
//
//			$( "circle" ).click(function(){
//				$(this).draggable();
//				$(this).mouseup(function(d) {
//					console.log("HII");
//				});
//			});
//
//			$( "#test" ).droppable({
//			  drop: function( event, ui ) {
//				$( this )
//				  .toggleClass( "ui-state-highlight" )
//				  .find( "p" )
//					.html( "Dropped!" );
//			  }
//			});
//
//		  });


</script>
</body>
</html>