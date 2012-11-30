<!DOCTYPE html>

<?php

	include_once( dirname(__FILE__) . '/../../controller/tweets.php' );

	$tweets = new Tweets();
	$allTweets = $tweets->index();

	
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
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" language="javascript"></script>
		<script type="text/javascript" src="http://d3js.org/d3.v3.min.js" language="javascript"></script>
		<script type="text/javascript" src="http://keith-wood.name/js/jquery.svg.js" language="javascript"></script>
		<script type="text/javascript" src="http://keith-wood.name/js/jquery.svgdom.js" language="javascript"></script>
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
				<nav class="grid_12 alpha" id="breadcrumbs">
					<ul>
						<li><span class="home icon"></span><span class="txt"><a href="/application/view/">Home</a></span></li>
						<li><span class="separator">&raquo;</span><span class="cities icon"></span><span class="txt">Happiest Cities</span></li>
					</ul>
				</nav>
<!--				<form method="get" name="search" onsubmit="findCity(this.form)">
					<input type="text" name="keyword" value="Search a city" onblur="if (this.value == '') {this.value = 'Search a city';}" id="keyword"
                                                     onfocus="if (this.value == 'Search a city') {this.value = '';}" />
				</form>-->
				<script>

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
				<div class="grid_8 alpha testArea" id="test">
<!--					<img src="/application/assets/i/happiest-cities-1.png" alt="" />-->
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
					
				</div>

		</div>

		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script type="text/javascript" src="/application/assets/js/modernizr-2.5.3.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js" type="text/javascript" language="javascript"></script>
		<script type="text/javascript" src="/application/assets/js/scripts.js" language="javascript"></script>
<!--		<script type="text/javascript" src="https://www.google.com/jsapi"></script>-->
		<script type="text/javascript">

		var diameter = 620,
			format = d3.format(",d");

		var bubble = d3.layout.pack()
			.sort(null)
			.size([diameter, diameter])
			.padding(1.5);

		var svg = d3.select("#test").append("svg")
			.attr("width", diameter)
			.attr("height", 800)
			.attr("class", "bubble");

		var div = d3.select("#breadcrumbs").append("div")
		.attr("class", "tooltip")
        .style("opacity", 1e-6);

		d3.json("../../assets/json/cities-average-tweets-quantity.json", function(error, root) {
//		d3.json("../../assets/json/test.json", function(error, root) {
			var color = d3.rgb(51,51,0);

		  var node = svg.selectAll(".node")
			  .data(bubble.nodes(classes(root))
			  .filter(function(d) { return !d.children; }))
			.enter().append("g")
			  .attr("class", "node")
			  .attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });

		  node.append("title")
			  .text(function(d) { return d.className + " - Sentiment: " + d.sentiment + " | Tweet Count: " + format(d.value); });

		  node.append("circle")
			  .attr("r", function(d) { return d.r; })
			  .attr("id", function(d) { return d.className; })
			  .style("fill", function(d) { return color.brighter(d.sentiment ); })
			  //http://christopheviau.com/d3_tutorial/
			  .attr("stroke", "#eee")
			  .attr("stroke-width", function(d){
			  	return d.value / 45;
			  })
			  .on("mouseover", mouseover)
			  .on("mousemove", function(d){mousemove(d);})
			  .on("mouseout", mouseout);

		  node.append("text")
			  .attr("dy", ".3em")
			  .style("text-anchor", "middle")
			  .text(function(d) { return d.className.substring(0, d.r / 3); })
			  .on("mouseover", mouseover)
			  .on("mousemove", function(d){mousemove(d);})
			  .on("mouseout", mouseout);
		});
		
		//https://gist.github.com/2952964
		function mouseover() {
			div.transition()
			.duration(100)
			.style("opacity", 1)
			.style("stroke", 1);
		}

		function mousemove(d) {
			div
			.text("City: " + d.className + " | Sentiment: " + d.sentiment + " | Tweet Count: " +d.value)
			.style("left", (d3.event.pageX ) + "px")
			.style("top", (d3.event.pageY) + "px");
		}

		function mouseout() {
			div.transition()
			.duration(300)
			.style("opacity", 1e-6);
		}


		// Returns a flattened hierarchy containing all leaf nodes under the root.
		function classes(root) {
		  var classes = [];

		  function recurse(name, node) {
			if (node.children) node.children.forEach(function(child) { recurse(node.name, child); });
			else classes.push({packageName: name, className: node.name, value: node.tweet_quantity, sentiment: node.sentiment});
		  }

		  recurse(null, root);
		  return {children: classes};
		}

		d3.select(self.frameElement).style("height", diameter + "px");

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