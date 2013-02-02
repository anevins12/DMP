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
		<style>
			#cities svg circle:hover {
			-webkit-transform: initial;
			}
		</style>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" language="javascript"></script>
		<script type="text/javascript" src="http://d3js.org/d3.v3.min.js" language="javascript"></script>
		<script type="text/javascript" src="/application/assets/js/geom.js" language="javascript"></script>
		<script src="http://mbostock.github.com/d3/talk/20110921/d3/d3.js" language="javascript"></script>
<!--		<script src="http://mbostock.github.com/d3/talk/20110921/d3/d3.layout.js"></script>-->
		<!DOCTYPE html>
<meta charset="utf-8">
<style>

circle {
  stroke: #fff;
}

</style>
<body>
<script src="http://mbostock.github.com/d3/d3.js?2.7.4"></script>
<script src="http://d3js.org/d3.v2.js"></script>


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
		<script>
//			happiestCities()

			
		</script>

		<script>
// var nodes= [{"statuses_count": 11, "name": "Leon Sasson", "friends_count": 4, "followers_count": 6, "id": 213899968, "screen_name": "leonsass"}, {"statuses_count": 378, "name": "Jonathan Kohn", "friends_count": 63, "followers_count": 13, "id": 88363150, "screen_name": "jkohn16"}, {"statuses_count": 5748, "name": "Rhett Allain", "friends_count": 368, "followers_count": 2540, "id": 14201924, "screen_name": "rjallain"}, {"statuses_count": 1252, "name": "TEDTalks Updates", "friends_count": 71, "followers_count": 1112719, "id": 15492359, "screen_name": "tedtalks"}, {"statuses_count": 69, "name": "physicsforums", "friends_count": 1, "followers_count": 209, "id": 75086184, "screen_name": "physicsforums"}];
var nodes = [{"name":"Cardiff","sentiment":3.8840419444444,"tweet_quantity":72},{"name":"London","sentiment":3.9122147457627,"tweet_quantity":59},{"name":"Birmingham","sentiment":3.6631545945946,"tweet_quantity":111},{"name":"Leicester","sentiment":3.8651373469388,"tweet_quantity":49},{"name":"Bristol","sentiment":4.0586666666667,"tweet_quantity":45},{"name":"Edinburgh","sentiment":3.9573819672131,"tweet_quantity":61},{"name":"Sheffield","sentiment":3.8011398809524,"tweet_quantity":84},{"name":"Peterborough","sentiment":3.7982251612903,"tweet_quantity":31},{"name":"Lisburn","sentiment":3.5388041176471,"tweet_quantity":17},{"name":"Manchester","sentiment":3.8332624590164,"tweet_quantity":122},{"name":"Leeds","sentiment":3.836649389313,"tweet_quantity":131},{"name":"Lancaster","sentiment":3.7886764705882,"tweet_quantity":17},{"name":"Wolverhampton","sentiment":3.6353515789474,"tweet_quantity":19},{"name":"Glasgow","sentiment":3.6889735106383,"tweet_quantity":94},{"name":"Sunderland","sentiment":4.083442,"tweet_quantity":40},{"name":"Aberdeen","sentiment":3.9868689189189,"tweet_quantity":37},{"name":"Liverpool","sentiment":3.8158697959184,"tweet_quantity":98},{"name":"Plymouth","sentiment":3.8153829411765,"tweet_quantity":17},{"name":"Cambridge","sentiment":3.695854375,"tweet_quantity":16},{"name":"Nottingham","sentiment":3.8604680645161,"tweet_quantity":31},{"name":"Portsmouth","sentiment":3.8136453125,"tweet_quantity":32},{"name":"Swansea","sentiment":3.9647444186047,"tweet_quantity":43},{"name":"Dundee","sentiment":3.5777,"tweet_quantity":35},{"name":"Newport","sentiment":3.7804325531915,"tweet_quantity":47},{"name":"Worcester","sentiment":4.0023373913043,"tweet_quantity":23},{"name":"Belfast","sentiment":3.6549312698413,"tweet_quantity":63},{"name":"Norwich","sentiment":4.1672233333333,"tweet_quantity":3},{"name":"Southampton","sentiment":3.70718,"tweet_quantity":38},{"name":"Oxford","sentiment":3.72870875,"tweet_quantity":16},{"name":"Hereford","sentiment":3.8747272727273,"tweet_quantity":11},{"name":"Londonderry","sentiment":3.2925,"tweet_quantity":2},{"name":"Coventry","sentiment":3.7478360377358,"tweet_quantity":53},{"name":"Hove","sentiment":4.28,"tweet_quantity":1},{"name":"Gloucester","sentiment":4.1698333333333,"tweet_quantity":21},{"name":"Bath","sentiment":3.5784025,"tweet_quantity":12},{"name":"Salford","sentiment":3.6515764444444,"tweet_quantity":45},{"name":"Lincoln","sentiment":4.60375,"tweet_quantity":2},{"name":"York","sentiment":3.78177125,"tweet_quantity":16},{"name":"Canterbury","sentiment":3.9220454545455,"tweet_quantity":22},{"name":"Chichester","sentiment":4.1403945454545,"tweet_quantity":11},{"name":"Hull","sentiment":2.575,"tweet_quantity":2},{"name":"Bradford","sentiment":3.7214005,"tweet_quantity":40},{"name":"Wakefield","sentiment":3.6409831034483,"tweet_quantity":29},{"name":"Brighton","sentiment":4.983335,"tweet_quantity":2},{"name":"Preston","sentiment":3.6841774193548,"tweet_quantity":31},{"name":"Durham","sentiment":3.9625566666667,"tweet_quantity":3},{"name":"Stirling","sentiment":3.6682142857143,"tweet_quantity":7},{"name":"Inverness","sentiment":3.6507264285714,"tweet_quantity":28},{"name":"Derby","sentiment":3.9646139473684,"tweet_quantity":38},{"name":"Winchester","sentiment":4.170401,"tweet_quantity":10},{"name":"Salisbury","sentiment":4.5045,"tweet_quantity":2},{"name":"St Albans","sentiment":3.48213,"tweet_quantity":9},{"name":"Chester","sentiment":3.5776818181818,"tweet_quantity":11},{"name":"Newry","sentiment":4.195,"tweet_quantity":2},{"name":"Lichfield","sentiment":3.84666625,"tweet_quantity":8},{"name":"Truro","sentiment":4.00667,"tweet_quantity":1},{"name":"Ely","sentiment":3.465,"tweet_quantity":1}];

var margin = {top: 0, right: 0, bottom: 0, left: 0},
    width = 620 - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;

var n = 20,
    m = 1,
    padding = 6;

var div = d3.select("#breadcrumbs").append("div")
	.attr("class", "tooltip")
	.style("opacity", 1e-6);

var color = d3.rgb(50, 50, 50);

nodes = nodes.map(function(obj) {
    obj.radius = Math.sqrt(obj.tweet_quantity * 1500)/(Math.sqrt(obj.tweet_quantity )*.1+ 10) + 1;
    obj.cx=width/2;
    obj.cy=height/2;
    return obj;
});

var force = d3.layout.force()
    .nodes(nodes)
    .size([width, height])
    .gravity(0)
    .charge(0)
    .on("tick", tick)
    .start();
var nodes = force.nodes();
var svg = d3.select("#test").append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
    .append("g").attr("transform", "translate(" + margin.left + "," + margin.top + ")")
	;

var circle = svg.selectAll("circle")
    .data(nodes)
    .enter().append("circle")
	.style("fill", function(nodes) {return color.brighter(nodes.sentiment );})
	.style("text-anchor", "middle")
    .attr("stroke", "#eee")
    .attr("stroke-width", function(nodes){;
    	return nodes.radius/20;
    })
	.on("mouseover", function(nodes, i){ return mouseover(nodes, i);})
    .on("mousemove", function(nodes){mousemove(nodes);})
    .on("mouseout", mouseout)
    .attr("r", function(d) { return d.radius; })
    .call(force.drag);

 circle.append("text")
		  .attr("dy", ".3em")
		  .style("text-anchor", "middle")
		  .text(function(d) {return d.name.substring(0, d.radius  );})
		  .on("mouseover", mouseover)
		  .on("mousemove", function(d){mousemove(d);})
		  .on("mouseout", mouseout)
circle.append("title").text(function(d){return d.name +": " + d.sentiment;});
function tick(e) {
  circle
      .each(gravity(.2 * e.alpha))
      .each(collide(.5))
      .attr("cx", function(d) { return d.x; })
      .attr("cy", function(d) { return d.y; });
}

//https://gist.github.com/2952964
function mouseover(d, i) {

	d3.select("circle" + i).style("fill", "red");

	div.transition()
	.duration(100)
	.style("opacity", 1)
	.style("stroke", 1);
}

function mousemove(d) {
	div
	.text("City: " + d.name + " | Sentiment: " + d.sentiment + " | Tweet Count: " +d.tweet_quantity)
	.style("left", (d3.event.pageX ) + "px")
	.style("top", (d3.event.pageY) + "px")
	.append("image")
	.attr("src", function() {
		var src = "/application/assets/i/smiley-";
		var ext = ".png";

		if ( d.sentiment < 1 ) {
			return src + 0 + ext;
		}
		if ( d.sentiment < 3 ) {
			return src + 2 + ext;
		}
		if ( d.sentiment < 4 ) {
			return src + 3 + ext;
		}
		if ( d.sentiment < 5 ) {
			return src + 4 + ext;
		}
		if ( d.sentiment < 6 ) {
			return src + 5 + ext;
		}
		if ( d.sentiment < 7 ) {
			return src + 6 + ext;
		}
		if ( d.sentiment < 9 ) {
			return src + 8 + ext;
		}
		if ( d.sentiment < 10 ) {
			return src + 9 + ext;
		}
	});

}

function mouseout() {
	div.transition()
	.duration(300)
	.style("opacity", 1e-6);
}

// Move nodes toward cluster focus.
function gravity(alpha) {
  return function(d) {
    d.y += (d.cy - d.y) * alpha;
    d.x += (d.cx - d.x) * alpha;
  };
}

// Resolve collisions between nodes.
function collide(alpha) {
  var quadtree = d3.geom.quadtree(nodes);
  return function(d) {
    var r = d.radius + 12 + padding,
        nx1 = d.x - r,
        nx2 = d.x + r,
        ny1 = d.y - r,
        ny2 = d.y + r;
    quadtree.visit(function(quad, x1, y1, x2, y2) {
      if (quad.point && (quad.point !== d)) {
        var x = d.x - quad.point.x,
            y = d.y - quad.point.y,
            l = Math.sqrt(x * x + y * y),
            r = d.radius + quad.point.radius + (d.color !== quad.point.color) * padding;
        if (l < r) {
          l = (l - r) / l * alpha;
          d.x -= x *= l;
          d.y -= y *= l;
          quad.point.x += x;
          quad.point.y += y;
        }
      }
      return x1 > nx2
          || x2 < nx1
          || y1 > ny2
          || y2 < ny1;
    });
  };
}




</script>

	</body>
</html>