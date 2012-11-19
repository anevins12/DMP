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
	<script type="text/javascript" src="../assets/js/d3.v2.js" language="javascript"></script>
	<script type="text/javascript" src="../assets/js/flare.json" language="javascript"></script>

	<style>
		svg {
			width: 560px;
			height: 200px;
		}

	</style>

</head>

<body>

	<div class="testArea">

	<h1>Happiest Cities</h1>

	<script type="text/javascript">
		var r = 960,
		format = d3.format(",d"),
		fill = d3.scale.category20c();

		var bubble = d3.layout.pack()
			.sort(null)
			.size([r, r])
			.padding(1.5);

		var vis = d3.select(".testArea").append("svg")
			.attr("width", r)
			.attr("height", r)
			.attr("class", "bubble");

		d3.json("../data/flare.json", function(json) {
		  var node = vis.selectAll("g.node")
			  .data(bubble.nodes(classes(json))
			  .filter(function(d) { return !d.children; }))
			.enter().append("g")
			  .attr("class", "node")
			  .attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });

		  node.append("title")
			  .text(function(d) { return d.className + ": " + format(d.value); });

		  node.append("circle")
			  .attr("r", function(d) { return d.r; })
			  .style("fill", function(d) { return fill(d.packageName); });

		  node.append("text")
			  .attr("text-anchor", "middle")
			  .attr("dy", ".3em")
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

	</script>
	<style>
		.bar {
			display: inline-block;
			width: 20px;
			height: 75px;   /* We'll override this later */
			background-color: teal;
		}
	</style>
	</div>
</body>

</html>