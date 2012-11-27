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
    format = d3.format(",d"),
    color = d3.scale.category20c();

var bubble = d3.layout.pack()
    .sort(null)
    .size([diameter, diameter])
    .padding(1.5);

var svg = d3.select("body").append("svg")
    .attr("width", diameter)
    .attr("height", diameter)
    .attr("class", "bubble");

d3.json("../assets/json/cities-average-tweets-quantity.json", function(error, root) {
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
	  .style("fill", function(d) { return color.brighter(d.sentiment / 1.5 ); });

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
    else classes.push({packageName: name, className: node.name, value: node.tweet_quantity, sentiment: node.sentiment});
  }

  recurse(null, root);
  return {children: classes};
}

d3.select(self.frameElement).style("height", diameter + "px");


	</script>

</body>

</html>