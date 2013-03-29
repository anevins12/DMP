<!DOCTYPE html>

<?php

	include_once( dirname(__FILE__) . '/../../controller/tweets.php' );

	include_once( dirname(__FILE__) . '/../../controller/users.php' );

	$users = new Users();
	$allUsers = $users->getAllUsers();
	

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
		</ul>
	</div>
	<div id="intro">
		<h2>Explore the Christmas spirit of 2012</h2>
	</div>

	<div id="desc">
		<div class="container">
			<h2>Data gathered Twitter - 22<span>nd</span> to 29<span>th</span> of December</h2> <!--that was recorded from December 22 - December 29 2012-->
		</div>
	</div>

	<div id="cities">
		<div class="container">

			<div id="quantities">

				<div class="desc">
					<p>Out of 783 tweets</p>
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
			</div>

		</div>
		
	</div>

	<div id="sample_tweets">
		<h2 class="trigger">Cities Sample Tweets</h2>
		<div id="all_cities">
		</div>
	</div>

	<div id="all_users">
		<h2 class="trigger">Ball of Hate</h2>
	</div>

	<div id="tags">
		<h2 class="trigger">Tagclouds</h2>
		<div class="container">
			<div id="sadTagCloud">
				
			</div>
			<div id="happyTagCloud">
				
			</div>
		</div>
	</div>

	<div id="recentTweets">
		<h2 class="trigger">Recent Tweets</h2>
		<div class="container">
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


	<div id="conclusion">
		<div class="container">
			<h3>That's all</h3>
			<p>That was my attempt at retrieving mood from tweets during the Christmas period</p>
			<p>As you can see, it has not always worked.</p>
			<h4>How I did it</h4>
			<h5>Data visualisations</h5>
			<p>The <a href="http://d3js.org">D3.js</a> library was used because it is particularly good at handling large datasets. Initially I was dealing with 40,000 tweets.</p>
			<p>D3.js allows physical simulations to occur through its <a href="https://github.com/mbostock/d3/wiki/Force-Layout">Force Layout</a> class.
				This simulation replicates gravity but, instead of objects falling downwards, they fall towards the centre of the SVG container.
			</p>
			<p><a href="http://140dev.com/free-twitter-api-source-code-library/">140Dev</a> provided a framework to stream Twitter's API and get around that
				dreadful OAuth process.
			</p>
			<p> I manipulated the framework a bit and only brought in tweets from the United Kingdom, by using Rob Hawke's method (2011).
				Hawkes describes how you can draw a hypothetical box around the UK, a box made up geographical coordinates for each of the four corners.
				So, I only brought in tweets that were inside this coordinate range.
			</p>
			<h5>Sentiment Analysis</h5>
			<p><a href="http://www.uvm.edu/~cdanfort/research/dodds-danforth-johs-2009.pdf">Danforth and Dodd's sentiment analysis methodology</a> (2009) was used to retrieve a sentimental value for each tweet.</p>
			<p>Mood is really really difficult to retrieve!</p>
			<p>The issue with using Danforth and Dodd's methodology is that it presupposes the user genuinely has the same emotion that they are writing.</p>
			<p>For example, someone could be trolling, therefore their tweet could be nasty but they may be feeling happy about it.</p>
			<p>There's also a large issue with Internet slang on Twitter, using that methodology. That methodology only works on perfect English.</p>
			
		</div>
	</div>

	<script type="text/javascript" src="/application/assets/js/cloud.js" language="javascript"></script>
	<script type="text/javascript" src="/application/assets/js/d3.layout.cloud.js" language="javascript"></script>
	<script type="text/javascript" src="/application/assets/js/scripts.js" language="javascript"></script>
	<script type="text/javascript" src="/application/assets/js/sprintf.js" language="javascript"></script>

	<script>

		var data = <?php  echo $allTweets['json']; ?>;
		var users = <?php echo $allUsers; ?>;

		happiestCities(data);

		$(document).ready(function(){
			$('img.loader, #recentTweets ul').hide();

			$('#sample_tweets h2.trigger').one("click", function(){
				allCities();
				addToSidebar($(this));
			});
			$('#all_users h2.trigger').one("click", function(){
				allUsers(users);
				addToSidebar($(this));
			});
			$('#tags .trigger').one("click", function(){
				sadTagCloud();
				happyTagCloud();
				addToSidebar($(this));
			})
			$('#recentTweets .trigger').one("click", function(){
				$('#recentTweets ul').show();
				addToSidebar($(this));
			})

			function addToSidebar($element) {

				var heading = $element.context.innerHTML;
				var parent = $element.context.parentNode.id;

				$('#sidebar ul').append('<li><a href="#' + parent + '">' + heading + '</a></li>');

			}
		})
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
				topPadding = 0;

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

	</script>

</body>
</html>