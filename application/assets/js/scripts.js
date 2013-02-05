/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
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

function tabs() {
	$(document).ready(function(){
	/* This code is executed after the DOM has been completely loaded */

	/* Defining an array with the tab text and AJAX pages: */
	var Tabs = {
		'Cities'	: '/application/view/happiest-cities/happiest-cities.php',
		'Cities and Towns'	: '/application/view/happiest-cities/happiest-cities-and-towns.php',
	}

	/* The available colors for the tabs: */
	var colors = ['blue','green'];

	/* The colors of the line above the tab when it is active: */
	var topLineColor = {
		blue:'lightblue',
		green:'lightgreen'
	}

	/* Looping through the Tabs object: */
	var z=0;
	$.each(Tabs,function(i,j){
		/* Sequentially creating the tabs and assigning a color from the array: */
		var tmp = $('<li><a href="#" class="tab '+colors[(z++%4)]+'">'+i+' <span class="left" /><span class="right" /></a></li>');

		/* Setting the page data for each hyperlink: */
		tmp.find('a').data('page',j);

		/* Adding the tab to the UL container: */
		$('ul.tabContainer').append(tmp);
	})

	/* Caching the tabs into a variable for better performance: */
	var the_tabs = $('.tab');

	the_tabs.click(function(e){
		/* "this" points to the clicked tab hyperlink: */
		var element = $(this);

		/* If it is currently active, return false and exit: */
		if(element.find('#overLine').length) {
			return false;
		}

		/* Detecting the color of the tab (it was added to the class attribute in the loop above): */
		var bg = element.attr('class').replace('tab ','');

		/* Removing the line: */
		$('#overLine').remove();
		$('.tab.selected').removeClass('selected');

		/* Creating a new line with jQuery 1.4 by passing a second parameter: */
		$('<div>',{
			id:'overLine',
			css:{
				display:'none',
				width:element.outerWidth()-2,
				background:topLineColor[bg] || 'white'
			}}).appendTo(element).fadeIn('slow');

		$(element).toggleClass('selected');

		/* Checking whether the AJAX fetched page has been cached: */

		if(!element.data('cache'))
		{
			/* If no cache is present, show the gif preloader and run an AJAX request: */
			$('#contentHolder').html('<img src="/application/assets/i/ajax_preloader.gif" class="preloader" />');

			$.get(element.data('page'),function(msg){
				$('#contentHolder').html(msg);

				/* After page was received, add it to the cache for the current hyperlink: */
				element.data('cache',msg);
			});
		}
		else $('#contentHolder').html(element.data('cache'));

		e.preventDefault();
	})

	/* Emulating a click on the first tab so that the content area is not empty: */
	the_tabs.eq(0).click();
});


}
