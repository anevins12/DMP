/* 
 * The scripts.js file compiles all functions that are used in the applicaiton's view
 *
 * 
 * @author_name Andrew Nevins
 * @author_no 09019549
*/
function polymaps() {
	
	// Import the polymaps namespace into a variable (for convenience)
	var poly = org.polymaps;

	// A map instance retrieved via the constructor. 
	var map = poly.map()
	.container(document.getElementById("map").appendChild(poly.svg("svg")))
	.add(poly.interact())
    .add(poly.hash());
	
	// Use the map instance and insert into it a new SVG instance.
	// The new SVN instance will add a new element in the documet body.
	// Then add an image title layer.
    map.add(poly.image().url(poly.url("http://{S}tile.cloudmade.com"
							+ "/c3060cc966ce4cd89382d09b14e0d1eb" // http://cloudmade.com/register
							+ "/70184/256/{Z}/{X}/{Y}.png")
							.hosts(["a.", "b.", "c.", ""])));

	map.add(poly.compass()
    .pan("none"));

	// When passed with no arguments, Polymaps methods return the value of the associated field, rather than the instance.
	// This allows the method to serve both as a setter and a getter:
	//map.container();

}

/**
* Generates a choropleth map of the specified regions (not used)
* Was used when exploring how to display UK cities on a geographical map
*
* @author_name Andrew Nevins
* @author_no 09019549
*/
/* http://cartographer.visualmotive.com/ */
function cartograph() {

	// Instance of Google Map
	var map = new GMap2( document.getElementById( "map" ) );

	// Colour ranges
	var options = {colors: [ "#000", "#999", "#00aaff" ]};
	
	var cartographer = Cartographer ( map, options );

	cartographer.choropleth([
	{region:"US-MN",val:0},
	{region:"US-IA",val:2},
	{region:"US-WI",val:4},
	{region:"US-SD",val:2},
	{region:"US-ND",val:0},
	{region:"US-MI",val:4},
	{region:"US-UT",val:2}
	], {colorScheme:"BuPu"});

}


/**
* The Bubble chart that shows cities in relation to sentiment - animated
* It generates an SVG element with multiple <circle> elements for each bubble
*
* @author_name Andrew Nevins
* @author_no 09019549
*/
function happiestCities(nodes) {

	var nodes = nodes;

	var margin = {top: 0, right: 0, bottom: 0, left: 0},
		width = 1170 - margin.left - margin.right,
		height = 400 ;

	var n = 20,
		m = 1,
		padding = 6;

	var div = d3.select("#christmas-bubble").append("div")
		.attr("class", "tooltip")
		.style("opacity", 1e-6);

	var color = d3.rgb(20, 20, 20);

	nodes = nodes.map(function(obj) {
		obj.radius = obj.sentiment * 8.5;
		obj.cx=width/2;
		obj.cy=height/2;
		return obj;
	});

	//FORCE taken from https://gist.github.com/3161074
	var force = d3.layout.force()
		.nodes(nodes)
		.size([width, height])
		.gravity(0)
		.charge(0)
		.on("tick", tick)
		.start();
	var nodes = force.nodes();
	var svg = d3.select("#christmas-bubble").append("svg")
		.attr("width", width + margin.left + margin.right)
		.attr("height", height + margin.top + margin.bottom)
		.append("g").attr("transform", "translate(" + 300 + "," + 0 + ")")
		;

	// You need to first select all <circle> elements - so D3 will know which to apply the following functions to
	var circle = svg.selectAll("circle")
		// nodes is a variable that holds a json object that represents the dataset
		.data(nodes)
		// The enter() function needs to be called before functions apply to singular data in the dataset
		.enter().append("circle")
		// This fills the data with a shade of grey relative to the sentiment
		// 'color' is a variable that holds an RGB value | var color = d3.rgb(20, 20, 20);
		// Division on the sentiment is applied to lighten the shade of grey.
		.style("fill", function(nodes) {return color.brighter(nodes.sentiment / 1.8 );})
		// Styles each <circle> with a stroke.
		.attr("stroke", "#eee")
		// The stroke width is relative to the radius of the <circle> as not to over/underpower it.
		.attr("stroke-width", function(nodes){
			return nodes.radius/20;
		})
		// This is an attempt to manipulate each <circle> further,
		// by applying an iterative and unique class to each one for further use.
		.attr("class", function(nodes, i) { return i; })
		// Get the mouseover function and pass it the dataset.
		// This function displays more information on particular cities on-hover of their <circle> elements.
		.on("mouseover", function(nodes, i){ return mouseover(nodes, i);})
		// Calls another function when users move their mouse - That just hides the on-hover displays
		.on("mouseout", mouseout)
		// Creates the radius for each <circle> by using a 'radius' method defined above
		// The radius method actually uses the data's sentiment | obj.radius = obj.sentiment * 8.5;
		.attr("r", function(d) { return d.radius; })
		// Calls the force library that handles the gravity simulation
		.call(force.drag);


	//	.append("text")

	function tick(e) {
	  circle
		  .each(gravity(.2 * e.alpha))
		  .each(collide(.5))
		  .attr("cx", function(d) { return d.x; })
		  .attr("cy", function(d) { return d.y; });
	}

	//https://gist.github.com/2952964
	function mouseover(d, i) {
	//debugging
	//alert("circle." + i);

	var iterator = i;
	var cssClass = sprintf("circle.", iterator);

		div.transition()
		.duration(100)
		.style("opacity", 1);

		div
		.text(d.name)
		.style("left", (d3.event.pageX) + - 270 + "px")
		.style("top", (d3.event.pageY)  + -50 + "px")
		.style("font-size", "200%");

		div.append("image")
		.attr("src", function() {
			var src = "/application/assets/i/smiley-";
			var ext = "-light.png";

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
		div
		.append('p').text('Feeling value: '+ d.sentiment +'(/10)');
		
		div
		.append('p').attr("class", "tweet")
		.text("Sample tweet: " + d.tweet )
		.style("left", (d3.event.pageX) + "px")
		.style("top", (d3.event.pageY) + "px")

	}

	function mouseout() {
		div.transition()
		.duration(100)
		.style("opacity", 1e-6);
	}

	// Move nodes toward cluster focus.
	function gravity(alpha) { 
	  return function(d) {
		d.y += (d.cy - d.y) * alpha / 0.7;
		d.x += (d.cx - d.x) * alpha / 15;
	  };
	}
	
	// Resolve collisions between nodes.
	function collide(alpha) {
	  var quadtree = d3.geom.quadtree(nodes);
	  return function(d) {
		var r = d.radius +  padding ,
			nx1 = d.x - r,
			nx2 = d.x + r,
			ny1 = d.y - r,
			ny2 = d.y + r;
		quadtree.visit(function(quad, x1, y1, x2, y2) {
		  if (quad.point && (quad.point !== d)) {
			var x = d.x - quad.point.x,
				y = d.y - quad.point.y,
				l = Math.sqrt(x * x + y * y ),
				r = d.radius + quad.point.radius + (d.color !== quad.point.color) * padding;
			if (l < r) {
			  l = (l - r) / l * alpha * 1.3 ;
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

}

/**
* Create a tag cloud of tweets with sad sentiment
*
* @author_name Andrew Nevins
* @author_no 09019549
*/
function sadTagCloud() {

	$('#tags #sadTagCloud').append('<h2>Sad');

	d3.json("../../assets/json/sadTweetTags.json", function(json) {

	var fill = d3.scale.ordinal()
		.range([ "#5B5B5B", "#727272", "#848484", "#969696", "#A8A8A8", "#BABABA", "#CECECE"]);

	  d3.layout.cloud().size([600, 400])
		  .words(json.map(function(d) {
				return {text: d.word, size: d.sentiment * 25 , tweet: d.tweet};
		   }))
		  .rotate(function(d) { return ~~(Math.random() * 0) * 90; })
		  .font("Impact")
		  .fontSize(function(d) { return d.size; })
		  .on("end", draw)
		  .start();

	  function draw(words) { 
		  d3.select("#sadTagCloud").append("svg")
			  .attr("height", 370)
			  .append("g").attr("transform", "translate(300,200)")
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
			  .text(function(d) { return d.tweet; });
		  }
	});

}

/**
* Create a tag cloud of tweets with happy sentiment
* Pretty much the same as sadTagCloud() but feeds in a different json file and uses different colours
*
* @author_name Andrew Nevins
* @author_no 09019549
*/
function happyTagCloud() {

	$('#tags #happyTagCloud').append('<h2>Happy</h2>');

	d3.json("../../assets/json/happyTweetTags.json", function(json) {

		var fill = d3.scale.ordinal()
		.range([ "#DAE3E6", "#d1dce0", "#E3EAEC", "#EDF1F3", "#F6F8F9", "#DFEEF4", "#C8D2D6", "#CED4D6"]);

		 d3.layout.cloud().size([600, 400])
		  .words(json.map(function(d) { 
				return {text: d.word, size: d.sentiment * 6};
		   }))
		  .rotate(function(d) { return ~~(Math.random() * 0) * 90; })
		  .font("Impact")
		  .fontSize(function(d) { return d.size; })
		  .on("end", draw)
		  .start();

		  function draw(words) {
		  
		  d3.select("#happyTagCloud").append("svg")
			  .attr("height", 370)
			  .append("g").attr("transform", "translate(300,200)")
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
	});

}

/**
* Generates the circles for each city in the 'Cities Sample Tweets' section
*
* @author_name Andrew Nevins
* @author_no 09019549
*/
function allCities() {
	
	$('#all_cities').append('<img src="/application/assets/i/301.gif" alt="loading" class="loader" />').show();

     $.get('../../controller/cities.php', function(result) {

       var citiesTweets = jQuery.parseJSON(result);
       var $oneCity;
	   
       $.each( citiesTweets, function( k, v ) {
             $oneCity = $( '<div/>' );
             $oneCity.html('<h4>' + k + '</h4>');
			 $oneCity.append('<div class="arrow-down"></div>');
             $cityQuotes = $( '<ul/>' );

             $.each(v, function(i,u){
                   $cityQuotes.append('<li><blockquote>' + u + '</blockquote></li>');
             });
            $oneCity.append( $cityQuotes ).appendTo( '#all_cities' );
       });


		$('#all_cities ul, #all_cities .arrow-down').hide();

		$('#all_cities h4').click(function(){
			$(this).toggleClass('selected');
			$(this).parent().find('ul, .arrow-down').slideToggle();
		});

		$('#all_cities').load().find('.loader').remove();

	 });

	 
	 
}

/**
* Returns a particle-like visualisation of multiple users.
* Based on the code from HappiestCitiesImproved function
*
* @author_name Andrew Nevins
* @author_no 09019549
*/
function allUsers(users) {

	var users = users;

	var margin = {top: 0, right: 0, bottom: 0, left: 0},
		width = 1170 - margin.left - margin.right,
		height = 290 ;

	var n = 20,
		m = 1,
		padding = 6;

	var color = d3.rgb(20, 20, 20);

	nodes = users.map(function(obj) {
		obj.radius = 10;
		obj.cx=width/2;
		obj.cy=height/2;
		return obj;
	});

	//FORCE taken from https://gist.github.com/3161074
	var force = d3.layout.force()
		.nodes(nodes)
		.size([width, height])
		.gravity(0)
		.charge(0)
		.on("tick", tick)
		.start();

	var nodes = force.nodes();
	
	var svg = d3.select("#all_users").append("svg")
		.attr("width", width + margin.left + margin.right)
		.attr("height", height + margin.top + margin.bottom)
		.append("g").attr("transform", "translate(" + 100 + "," + -30 + ")")
		;

		$('#all_users svg').wrap('<div class="container" />');

	var div = d3.select("#all_users .container").append("div")
		.attr("class", "tooltip")
		.style("opacity", 1e-6);
		
	var circle = svg.selectAll("circle")
		.data(nodes)
		.enter().append("circle")
		.style("fill", function(nodes) {return d3.scale.ordinal().range([ "#DAE3E6", "#d1dce0", "#E3EAEC", "#EDF1F3", "#F6F8F9", "#DFEEF4", "#C8D2D6", "#CED4D6"]);})
		.style("text-anchor", "middle")
		.attr("stroke", "#eee")
		.attr("stroke-width", function(nodes){
			return 0.5;
		})
		.attr("class", function(nodes, i) { return i; })
		.on("mouseover", function(nodes, i){ return mouseover(nodes, i);})
		.on("mouseout", mouseout)
		.attr("r", function(d) { return d.radius; })
		.call(force.drag);


	function tick(e) {
	  circle
		  .each(gravity(.05))
		  .each(collide(.5))
		  .attr("cx", function(d) { return d.x; })
		  .attr("cy", function(d) { return d.y; });
		  
	}

	//https://gist.github.com/2952964
	function mouseover(d, i) {
	//debugging
	//alert("circle." + i);

	var iterator = i;
	var cssClass = sprintf("circle.", iterator);

		div.transition()
		.duration(100)
		.style("opacity", 1);

		div
		.style("left", 814 + "px")
		.style("top", 47 + "px");

		div
		.text(d.screen_name);

		div
		.append('p').attr("class", "image")
		.html('<img alt="' + d.screen_name + '" src="' + d.profile_image_url + '" />')

		div.append("image")
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

			div
			.append('blockquote')
			.html('<q>' + d.tweet_text + '</q>');

	}

	function mouseout() {
		div.transition()
		.duration(100)
		.style("opacity", 1e-6);
	}

	// Move nodes toward cluster focus.
	function gravity(alpha) {
	  return function(d) {
		d.y += (d.cy - d.y) * alpha ;
		d.x += (d.cx - d.x) * alpha ;
	  };
	}

	// Resolve collisions between nodes.
	function collide(alpha) {
	  var quadtree = d3.geom.quadtree(nodes);
	  return function(d) {
		var r = d.radius +  padding ,
			nx1 = d.x - r,
			nx2 = d.x + r,
			ny1 = d.y - r,
			ny2 = d.y + r;
		quadtree.visit(function(quad, x1, y1, x2, y2) {
		  if (quad.point && (quad.point !== d)) {
			var x = d.x - quad.point.x,
				y = d.y - quad.point.y,
				l = Math.sqrt(x * x + y * y ),
				r = d.radius + quad.point.radius + (d.color !== quad.point.color) * padding;
			if (l < r) {
			  l = (l - r) / l * alpha * .23 ;
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

}