<!DOCTYPE html">
<?php

	include_once(  dirname(__FILE__) . '/../controller/tweets.php' );

	$tweets = new Tweets();
	$allTweets = $tweets->index();


	$data = file_get_contents( dirname(__FILE__) . '/../assets/json/cities-average-tweets-quantity.json');




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

	var width = 960,
	height = 500;

 //FORCE http://bl.ocks.org/950642

	   var force = d3.layout.force()
		.charge(-120)
		.linkDistance(30)
		.size([width, height]);
		

	var bubble = d3.layout.pack()
		.sort(null)
		.size([diameter, diameter])
		.padding(1.5);

	var svg = d3.select("#test").append("svg")
		.attr("width", diameter)
		.attr("height", diameter)
		.attr("class", "bubble");

	d3.json("../assets/json/cities-average-tweets-quantity.json", function(error, root) {
		var color = d3.rgb(255, 255, 0);

		var node = svg.selectAll(".node")
		  .data(bubble.nodes(classes(root))
		  .filter(function(d) { return !d.children; }))
		.enter().append("g")
		  .attr("class", "node")
		  .attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });

		  force.on("tick", function() {
			  node.attr("cx", function(d) { return d.x; })
			  .attr("cy", function(d) { return d.y; });
		});

	  node.append("title")
	  	.attr("IJDSAJIDIJSA", function(d){  return d  }   )
		  .text(function(d) { return d.className + ": " + format(d.value); });

	  
	  node.append("circle")
		  .attr("r", function(d) { return d.r; })
		  .style("fill", function(d) { return color.darker(d.value / 10000); })
		  .attr("stroke", "#000")

		  .attr("stroke-width", function(d){
			return d.value / 10000;
		  })

		  .call(force.drag);

	  node.append("text")
		  .attr("dy", ".3em")

		  .style("text-anchor", "middle")
		  .text(function(d) { return d.className.substring(0, d.r / 3); });

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