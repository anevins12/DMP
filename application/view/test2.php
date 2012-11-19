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
		//http://alignedleft.com/tutorials/d3/using-your-data/
//		var dataset = [ 5, 10, 15, 20, 25 ];
//
//		//grab the DOM of the paragraph elements from the selector class
//		d3.select(".testarea").selectAll("p")
//		//counts and parses the variable dataset values (returns 5 because there are 5 items)
//		.data(dataset)
//		//to create new data elements, you must use enter()
//		//creates a placeholder element
//		.enter()
//		//get the placeholder element created by enter()
//		//insert a paragraph element into the DOM
//		.append("p")
//
//		//use our data to populate the contents of each paragraph
//		//(d) just takes input, anonymous function (set in the original dataset)
//		.text(function(d) { return "potential sentiment value for each tweet: " + d; })
//
//		//as (d) holds the original data set (for each array index),
//		//check if the value is greater than 15, if so, turn elements red
//		.style('color', function(d){
//			if ( d > 15 ) {
//				return "red";
//			}
//			else {
//				return "black"
//			}
//		});
		//without wrapping (d) in an anonymous function, it has no value.

		//http://alignedleft.com/tutorials/d3/drawing-divs/
		//BAR CHART
//		d3.select(".testArea").selectAll("div")
//		.data(dataset)
//		.enter()
//		.append("div")
//		.attr("class", "bar")
//		//apply CSS directly to the elements
//		//make the BAR CHART taller by multiplying the dataset values by 5
//		.style("height", function(d){
//			return ( d * 5 ) + "px";
//		})
//		.style("margin-right", "2px");

		//http://alignedleft.com/tutorials/d3/the-power-of-data/
		var dataset = [ 5, 10, 15, 20, 25 ];
		var h = 50;
		$i = 0;
		
		var svg = d3.select(".testArea")
		.append("svg")
		.attr("width", "500")
		.attr("height", "500");

		var circles = svg.selectAll("circle")
		.data(dataset)
		.enter()
		.append("circle");

		circles.attr("cx", function(d, i) {
			return (i * 50) + 25;
		})
		.attr("cy", h/2)
		.attr("r", function(d) {
			return d;
		})
		.attr("fill", "yellow")
		.attr("stroke", "orange")
		.attr("stroke-width", function(d){
			return d/2;
		});
		
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