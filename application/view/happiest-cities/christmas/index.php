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
var nodes = [{"name":"Glasgow","sentiment":5.66333,"tweet":"@clarebalding a really strong like really strong magnet will get it off. I'm from Scotland I should know lol"},{"name":"Cardiff","sentiment":5.856,"tweet":"I am weak at me ordering in #Harvester I am far too funny ? How do you cope with me @ChelseaMH_X &amp; @LucyShan06"},{"name":"Nottingham","sentiment":5.5725,"tweet":"Caffe Nero makes me happy, caffe Nero knows how to treat a girl"},{"name":"Plymouth","sentiment":6.384,"tweet":"put a ring in my top ear and now I'm afraid a fishermans rod will get caught around it and catch me and eat me, ok I go into things too much"},{"name":"Southampton","sentiment":5.83,"tweet":"I love that one of the people my mum cuts hair for sends me sweets every time :)"},{"name":"Sheffield","sentiment":5.632,"tweet":"Could lay claim to being hungriest man in the world presently . Get me a chicken of the large variety"},{"name":"Bristol","sentiment":5.456,"tweet":"\"@ronnabe: If there was any doubt that City will win today, I've got my lucky pants on. Nice festive image for you all.\" Lovely!! :\/ lol"},{"name":"Worcester","sentiment":4.84,"tweet":"Nadelik Lowen one and all, hope you've had a good one. Time for a Bailey's! #Christmas #christmasattheblackmores"},{"name":"Dundee","sentiment":5.67,"tweet":"the only boy I have respect for today is paddy. I'll love him forever. "},{"name":"Preston","sentiment":3.12,"tweet":"Puking again deciding if its onions or peppers in my sick nice purple vimto sick with veg! Cracking! U want some?!?!??"},{"name":"Inverness","sentiment":5.605,"tweet":"@Charlie_MK1 merry xmas hope u and sim have a good one all the best for 2013 come back up n see nessie soon :-) #mygfwantstosecretlysteelyou"},{"name":"Peterborough","sentiment":5.48,"tweet":"Your either a sheep or a wolf ...i am a wolf!"},{"name":"Leeds","sentiment":6.505,"tweet":"@robbo555 I don't love and wouldn't marry him. I'd just have sex with him whilst he shouted at me like I was in University Challenge"},{"name":"Bradford","sentiment":5.23667,"tweet":"@RobbynSE xD well it's me but yeah apparently I'm B\/A in food so I could try to :3"},{"name":"Edinburgh","sentiment":5.30667,"tweet":"@hollyshmit facetime soon, you wanting to come to the port wi me and louise? ive got a party too, dunno what ur wanting to do tho"},{"name":"Newport","sentiment":5.97857,"tweet":"@ShaneWilliams11 it would make my day if you wished me happy birthday today from my all time favourite rugby player xx"},{"name":"Aberdeen","sentiment":6.032,"tweet":"Makes me laugh when people think there better then everyone else then you see them at the weekend coked out there nut, aye ok "},{"name":"Coventry","sentiment":5.1575,"tweet":null},{"name":"Wolverhampton","sentiment":4.918,"tweet":"#EndOfTheWorldConfessions I hate people, especially rude ignorant people who are aactually dole dosers. No time for them"},{"name":"Birmingham","sentiment":6.65667,"tweet":"@Lsbeth every time she refers to herself or people as 'one' as in oneself or one must... Etc. also \"people of Britain\""},{"name":"Manchester","sentiment":6,"tweet":"@ChiefAnna I love beetroot soup *sob* speak to you on chrimbo day. Have brilliant fun times for Polish Christmas x"},{"name":"Liverpool","sentiment":5.5875,"tweet":"Came to bed and left Preston on the couch. Had to go back for him, he would have forgiven me but I couldn't have forgiven myself."},{"name":"Gloucester","sentiment":5.29333,"tweet":"I'm done with people I swear the only person I can trust is my self nowadays! Christmas has been ruined!"},{"name":"Swansea","sentiment":5.99833,"tweet":"One more time music got me feeling so free"},{"name":"Portsmouth","sentiment":4.98333,"tweet":"@IwasGobby @ROODvintage She's already done that, several times. Strangely enough she thought it was very funny...."},{"name":"Lisburn","sentiment":5.25167,"tweet":"@JosshWells_ I think Hannah wants to me to go into lisburn after her stupid lunch other wise I would ask him hehe!"},{"name":"Salford","sentiment":4.8725,"tweet":"@_established91 yes, we'll get crunk like last time lool. I was so hungover the next day hahaha"},{"name":"Derby","sentiment":6.02333,"tweet":"@DeclanPotter @Garon_Potter your sister came running up to me in jimmys like I know you I'm so drunk Laura? Is it hahahaha"},{"name":"St Albans","sentiment":6.2275,"tweet":null},{"name":"Chester","sentiment":3.92,"tweet":"@chris_lei I'm not saying it until its *actually* your birthday."},{"name":"Canterbury","sentiment":7.11875,"tweet":"@MichaelShaw__ I disagree, I think weed smells like strong BO which I like, therefore I love that smell on a girl, makes me think of sweat"},{"name":"Leicester","sentiment":5.56667,"tweet":"3 followers on tumblr wow I'm loved. \nfollow me babies I follow back http:\/\/t.co\/8X5aS8hM \n#KokeHead @KokeUSG \nlove you all beautifuls."},{"name":"Lancaster","sentiment":3.58333,"tweet":"Had a good night, I'm sooooo tired now :("},{"name":"Stirling","sentiment":4.67667,"tweet":"@CapitalCaley that was the song of the day! 'Feed the weegies,  let them know its Christmas Time..'"},{"name":"Durham","sentiment":5.566,"tweet":"@theswan64 @wearethemags @robatkinsonnufc you obviously know fuck all. Deluded Isn't the word. Wouldn't surprise me if you were a part timer"},{"name":"Wakefield","sentiment":4.76667,"tweet":"@twinktop I'm in London first couple of weeks in feb"},{"name":"Oxford","sentiment":6.17,"tweet":"Seeing as my mother very kindly woke me at 9, it's time for me to go back to sleep. "},{"name":"Armagh","sentiment":3.51333,"tweet":"Well done Jim &amp; Eilish with the presents, spoilt me! But can dinner compare?..... No pressure http:\/\/t.co\/9lc5nTyH"},{"name":"Belfast","sentiment":5.624,"tweet":"@CaoimheCregan no I know but that's not what I mean lol I don't really know what you're getting at. I know a lot of people aren't sexist and"},{"name":"York","sentiment":4.36,"tweet":"@alexsimmonsdj @jakegooch Simmo we love u!! Hahahha made our year!! #courtyard #fuckthefuckingrain"},{"name":"Winchester","sentiment":4.47,"tweet":"@playdoh play time in bed! http:\/\/t.co\/8oijtMbo"},{"name":"Chichester","sentiment":5.3975,"tweet":"@Elliot_Fenty Awwwwww I feel so nice tonight knowing we made them all smile &amp; the children can have a chocolate biscuit tonight xxx ? you xx"},{"name":"Lichfield","sentiment":5.995,"tweet":"Had a really lovely evening with great friends chez @NursieJo &amp; family. Some sobering thoughts, but makes me remember to treasure my friends"},{"name":"Cambridge","sentiment":4.586,"tweet":"Was gonna get my mun a fake winning lottery ticket for christmas.. Nah im not that mean;)"},{"name":"Brighton","sentiment":3.785,"tweet":"Forgot to tell U went to paulines thru up on her stairs felt so bad she gave us a lift home allergic to busses xxx @vikkimatt"},{"name":"Bath","sentiment":3.786,"tweet":"@MissAvA_  I'm everywhere. ;) I haven't heard of a carol bus in a long time, such a shame. It was a magical thing. Happy Xmas Xx"},{"name":"Sunderland","sentiment":4.89333,"tweet":"The dinner better be done soon other wise I'm garn GANNY BASHING #NANImComingForYa"},{"name":"Hereford","sentiment":4.32667,"tweet":"I want my car now I'm getting rather fed up of it sat at the garage!!"},{"name":"Newry","sentiment":6.074,"tweet":"Have fun tonight @aoifemcevoy12 #gohardorgohome free bar so i could only imagine "}];

var margin = {top: 0, right: 0, bottom: 0, left: 0},
    width = 620 - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;

var n = 20,
    m = 1,
    padding = 6;

var div = d3.select("#breadcrumbs").append("div")
	.attr("class", "tooltip")
	.style("opacity", 1e-6);

var color = d3.rgb(2,2,2);

nodes = nodes.map(function(obj) {
    obj.radius = obj.sentiment * 4.5;
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
	.style("fill", function(nodes) {return color.brighter(nodes.sentiment / 1.5 );})
	.style("text-anchor", "middle")
    .attr("stroke", "#eee")
    .attr("stroke-width", function(nodes){;
    	return nodes.radius/20;
    })
	.on("mouseover", function(nodes, i){ return mouseover(nodes, i);})
//    .on("mousemove", function(nodes){mousemove(nodes);})
    .on("mouseout", mouseout)
    .attr("r", function(d) { return d.radius; })
    .call(force.drag);


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
	.style("opacity", 1);

	div
	.text("City: " + d.name + " | Sentiment: " + d.sentiment + " | Sample tweet: " + d.tweet )
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

function mousemove(d) {
	

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