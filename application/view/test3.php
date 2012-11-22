<!DOCTYPE html">
<?php

	include_once(  dirname(__FILE__) . '/../controller/tweets.php' );

	$tweets = new Tweets();
	$allTweets = $tweets->index();



	// testing functions

	?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Tweets</title>
	<link type="text/css" href="../assets/css/style.css" rel="stylesheet" />
	<script type="text/javascript" src="http://d3js.org/d3.v3.min.js" language="javascript"></script>


</head>

<body>

	<h1>Happiest Cities</h1>
	<div id="test">

	</div>
	<script type="text/javascript">

	var diameter = 960,
		format = d3.format(",d");
//		color = d3.scale.category10();
		

	var bubble = d3.layout.pack()
		.sort(null)
		.size([diameter, diameter])
		.padding(1.5);

	var svg = d3.select("#test").append("svg")
		.attr("width", diameter)
		.attr("height", diameter)
		.attr("class", "bubble");

	d3.json("../assets/js/flare.json", function(error, root) {
		var color = d3.rgb(255, 255, 0);

	  var node = svg.selectAll(".node")
		  .data(bubble.nodes(classes(root))
		  .filter(function(d) { return !d.children; }))
		.enter().append("g")
		  .attr("class", "node")
		  .attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });

	  node.append("title")
		  .text(function(d) { return d.className + ": " + format(d.value); });
	  
	  node.append("circle")
		  .attr("r", function(d) { return d.r; }) 
		  .style("fill", function(d) { return color.darker(d.value / 10000); })
		  .attr("stroke", "#000")

		  .attr("stroke-width", function(d){
			return d.value / 10000;
		  });

	  node.append("text")
		  .attr("dy", ".3em")
		  .style("text-anchor", "middle")
		  .text(function(d) { return d.className.substring(0, d.r / 3); });

		   //FORCE http://bl.ocks.org/950642

		   d3.json("../assets/js/flare.json", function(json) {
			  force
				  .nodes(json.nodes)
				  .links(json.links)
				  .start();

		   var width = 960,
			   height = 500

			var force = d3.layout.force()
				.gravity(.05)
				.distance(100)
				.charge(-100)
				.size([width, height]);

			var node = svg.selectAll(".node")
			  .data(json.nodes)
			  .enter().append("g")
			  .attr("class", "node")
			  .call(force.drag);
			  
			  force.on("tick", function() {
				link.attr("x1", function(d) { return d.source.x; })
					.attr("y1", function(d) { return d.source.y; })
					.attr("x2", function(d) { return d.target.x; })
					.attr("y2", function(d) { return d.target.y; });

				node.attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });
			  });
		   });


	});

				// Returns a flattened hierarchy containing all leaf nodes under the root.
				function classes(root) {
				  var classes = [];

				  function recurse(name, node) {
					if (node.children) node.children.forEach(function(child) { recurse(node.name, child); });
					else classes.push({packageName: name, className: node.name, value: node.size});
				  }

				  recurse(null, root);
				  return {children: classes};
				}

				d3.select(self.frameElement).style("height", diameter + "px");


	</script>

</body>

</html>