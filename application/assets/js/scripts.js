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
* The very first bubble chart attempted before Christmas (not used)
*
* @author_name Andrew Nevins
* @author_no 09019549
*/
function happiestCities() {
	var diameter = 940,
			format = d3.format(",d");

		var bubble = d3.layout.pack()
			.size([diameter, diameter]);

		var svg = d3.select("#test").append("svg")
			.attr("width", diameter)
			.attr("height", diameter)
			.attr("class", "bubble");

		var force = d3.layout.force()
			.gravity(0)
			.charge(-10)
			.size([diameter,diameter])
			.on("tick", tick)
			.start();

		var nodes = force.nodes();
		
var div = d3.select("#breadcrumbs").append("div")
		.attr("class", "tooltip")
        .style("opacity", 1e-6);
		

		d3.json("../../../assets/json/christmas-cities.json", function(error, root) {
//		d3.json("../../assets/json/test.json", function(error, root) {

		var links, nodes = [];
		var path = d3.geo.path(),
	    force = d3.layout.force().size([diameter, diameter]);


		var color = d3.rgb(30,30,30);

		  var node = svg.selectAll(".node")
			  .data(bubble.nodes(classes(root))
			  .filter(function(d) {return !d.children;}))
			.enter().append("g")
			  .attr("class", "node")
			  .attr("transform", function(d) {return "translate(" + d.x   + "," + d.y  + ")";});

		  node.append("circle")
			  .attr("r", function(d) {return d.r;})
			  .attr("id", function(d) {return d.className;})
			  .style("fill", function(d) {return color.brighter(d.sentiment );})
			  //http://christopheviau.com/d3_tutorial/
			  .attr("stroke", "#eee")
			  .attr("stroke-width", function(d){
			  	return d.r/25;
			  })

			  
			  .on("mouseover", function(d, i){ return mouseover(d, i);})
			  .on("mousemove", function(d){mousemove(d);})
			  .on("mouseout", mouseout);

		  node.append("text")
			  .attr("dy", ".3em")
			  .style("text-anchor", "middle")
			  .text(function(d) {return d.className.substring(0, d.r  );})
			  .on("mouseover", mouseover)
			  .on("mousemove", function(d){mousemove(d);})
			  .on("mouseout", mouseout)

			  .call(force.drag);

			  function tick(e) {
				  node
					  .each(gravity(.2 * e.alpha))
					  .each(collide(.5))
					  .attr("cx", function(d) { return d.x; })
					  .attr("cy", function(d) { return d.y; });
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

		});

		//https://gist.github.com/2952964
		function mouseover(d, i) {
			
			d3.select("nodes" + i).style("fill", "red");

			div.transition()
			.duration(100)
			.style("opacity", 1)
			.style("stroke", 1);
		}

		function mousemove(d) {
			div
			.text("City: " + d.className + " | Sentiment: " + d.sentiment + " | Tweet Count: " +d.value)
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


		// Returns a flattened hierarchy containing all leaf nodes under the root.
		function classes(root) {
		  var classes = [];

		  function recurse(name, node) {
			if (node.children) node.children.forEach(function(child) {recurse(node.name, child);});
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

}

/**
* Creates the original bubble chart that doesn't use D3 Force layout and collision methods.
* It is less interactive than the improved verison.
*
* @author_name Andrew Nevins
* @author_no 09019549
*/
function happiestCitiesAndTowns() {
var diameter = 620,
			format = d3.format(",d");

		var bubble = d3.layout.pack()
			.sort(null)
			.size([diameter, diameter])
			.padding(1.5);

		var svg = d3.select("#test2").append("svg")
			.attr("width", diameter)
			.attr("height", 800)
			.attr("class", "bubble");

		var div = d3.select("#breadcrumbs").append("div")
		.attr("class", "tooltip")
        .style("opacity", 1e-6);

		d3.json("../../assets/json/cities-towns-average-tweets-quantity.json", function(error, root) {
//		d3.json("../../assets/json/test.json", function(error, root) {

		var nodes = [],
			links = [];

		var path = d3.geo.path(),
	    force = d3.layout.force().size([diameter, 800]);


		var color = d3.rgb(51,51,0);

		 force
		  .gravity(0)
		  .nodes(nodes)
		  .links(links)
		  .linkDistance(function(d) {return d.distance;})
		  .start();

		  var node = svg.selectAll(".node")
			  .data(bubble.nodes(classes(root))
			  .filter(function(d) {return !d.children;}))
			.enter().append("g")
			  .attr("class", "node")
			  .attr("transform", function(d) {return "translate(" + d.x + "," + d.y + ")";});

		  node.append("circle")
			  .attr("r", function(d) {return d.r;})
			  .attr("id", function(d) {return d.className;})
			  .style("fill", function(d) {return color.brighter(d.sentiment );})
			  //http://christopheviau.com/d3_tutorial/
			  .attr("stroke", "#eee")
			  .attr("stroke-width", function(d){
			  	return d.value / 45;
			  })
			  .on("mouseover", function(d){mouseover(d);})
			  .on("mousemove", function(d){mousemove(d);})
			  .on("mouseout", mouseout);

		  node.append("text")
			  .attr("dy", ".3em")
			  .style("text-anchor", "middle")
			  .text(function(d) {return d.className.substring(0, d.r / 3);})
			  .on("mouseover", mouseover)
			  .on("mousemove", function(d){mousemove(d);})
			  .on("mouseout", mouseout);


		  force.start();
		  force.on("tick", function() {
			  node.attr("cx", function(d) {return d.x;})
				  .attr("cy", function(d) {return d.y;});
			});
		node.call(force.drag)
		});

		//https://gist.github.com/2952964
		function mouseover(d) {
			div.transition()
			.duration(100)
			.style("opacity", 1)
			.style("stroke", 1);
		}

		function mousemove(d) {
			div
			.text("City: " + d.className + " | Sentiment: " + d.sentiment + " | Tweet Count: " +d.value)
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


		// Returns a flattened hierarchy containing all leaf nodes under the root.
		function classes(root) {
		  var classes = [];

		  function recurse(name, node) {
			if (node.children) node.children.forEach(function(child) {recurse(node.name, child);});
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
}

/**
* Improves the Happiest Cities bubble chart.
* It generates an SVG element with multiple <circle> elements for each bubble
*
* @author_name Andrew Nevins
* @author_no 09019549
*/
function happiestCitiesImproved(nodes) {

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

	var circle = svg.selectAll("circle")
		.data(nodes)
		.enter().append("circle")
		.style("fill", function(nodes) {return color.brighter(nodes.sentiment / 1.8 );})
		.style("text-anchor", "middle")
		.attr("stroke", "#eee")
		.attr("stroke-width", function(nodes){
			return nodes.radius/20;
		})
		.attr("class", function(nodes, i) { return i; })
		.attr("dy", ".3em")
		.style("text-anchor", "middle")
		.text(function(nodes) {return nodes.name.substring(0, nodes.radius / 3);})
		.on("mouseover", function(nodes, i){ return mouseover(nodes, i);})
		.on("mouseout", mouseout)
		.attr("r", function(d) { return d.radius; })
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

	//	d3.select(cssClass).style("fill", function(){ return color.brighter(d.sentiment  ); } );

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
		height = 400 ;

	var n = 20,
		m = 1,
		padding = 6;

	var div = d3.select("#all_users").append("div")
		.attr("class", "tooltip")
		.style("opacity", 1e-6);

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
		.append("g").attr("transform", "translate(" + 100 + "," + -100 + ")")
		;

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
		.attr("dy", ".3em")
		.style("text-anchor", "middle")
		//.text(function(nodes) {return nodes.name.substring(0, nodes.radius / 3);})
		.on("mouseover", function(nodes, i){ return mouseover(nodes, i);})
		.on("mouseout", mouseout)
		.attr("r", function(d) { return d.radius; })
		.call(force.drag);


	//	.append("text")

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

	//	d3.select(cssClass).style("fill", function(){ return color.brighter(d.sentiment  ); } );

		div.transition()
		.duration(100)
		.style("opacity", 1);

		div
		.text(d.name)
		.style("left", (d3.event.pageX) + 200 + "px")
		.style("top", (d3.event.pageY)  + 200 + "px")
		.style("font-size", "200%");

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
		//div
		//.append('p').text('Feeling value: '+ d.sentiment +'(/10)');

//		div
//		.append('p').attr("class", "tweet")
//		.text("Sample tweet: " + d.tweet )
//		.style("left", (d3.event.pageX) + "px")
//		.style("top", (d3.event.pageY) + "px")

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