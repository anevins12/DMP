<!DOCTYPE html>

<?php

	include_once(  dirname(__FILE__) . '/../../../controller/tweets.php' );

//	$tweets = new Tweets();
//	$allTweets = $tweets->index();
//	$graphData = $tweets->getGoogleLineGraphFormat($allTweets);

	//taken from autumn (halloween & fireworks) period
	//NORMALISED
	$graphData = array(1 => 1.0921163490075, 2 => 1.0816360354867, 3 => 1.0852660295042, 
					   4 => 1.0887165840278, 5 => 1.0825088603089, 6 => 1.0853934085242, 7 => 1.0890582223985, 
					   8 => 1.0909382398095);
	
	$day1 = $graphData[1];
	$day2 = $graphData[2];
	$day3 = $graphData[3];
	$day4 = $graphData[4];
	$day5 = $graphData[5];
	$day6 = $graphData[6];
	$day7 = $graphData[7];
	$day8 = $graphData[8];

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
	</head>
	<body id="mood_graph">
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
								<a href="/application/view/happiest-cities">
									<span class="cities"></span>
									<span class="txt">Happiest Cities</span>
									<div class="arrow">
										<div class="tip"></div>
									</div>
								</a>
							</li>
							<li class="grid_2 omega">
								<a href="/application/view/moodgraphs/" class="dropdown selected">
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
											<a href="/application/view/moodgraphs/halloween-and-fireworks/" class="selected">
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
				<nav class="grid_12 alpha" id="breadcrumbs">
					<ul>
						<li><span class="home icon"></span><span class="txt"><a href="/application/view/">Home</a></span></li>
						<li><span class="separator">&raquo;</span><span class="graphs icon"></span><span class="txt"><a href="/application/view/moodgraphs/">Mood Graphs</a></span></li>
						<li><span class="separator">&raquo;</span><span class="halloween icon"></span><span class="txt">Halloween &amp; Fireworks</span></li>
					</ul>
				</nav>

				<div class="" id="options">
					<h2>The Happiest Cities in the United Kingdom</h2>
				</div>
				<div class="grid_12 alpha vis prefix_1">
					<div id="chart">
					</div>
					<div id="smilies" >
						<img id="smiley-9" src="/application/assets/i/smiley-9.png" alt="Happiest" />
						<img id="smiley-0" src="/application/assets/i/smiley-0.png" alt="Saddest" />
					</div>
				</div>
				<div class="grid_12 alpha omega">
<!--					<div id="key">
						<h3>Key</h3>
						<ul>
							<li class="info icon">More Information</li>
						</ul>
					</div>-->
					<div class="grid_8 alpha" id="description">
						<p>
							This Data Visualisation shows how-well public mood has been recorded from Twitter.
						</p>
						<p>
							Tweets were retrieved from the 29th of October to the 5th of November and sentimental values were
							applied to each tweet.
						</p>
						<p>
							Of each day, sentimental values are normalised. It is apparent there is no correlation between data gathered
							and public mood, therefore it seems public mood has not been recorded.
						</p>
					</div>
					<div class="grid_4 omega" id="next">
						<h4>
							<a href="/application/view/moodgraphs/christmas/">
								<span class="christmas icon"></span>
								<span class="text">Christmas</span>
								<span class="arrow-right"></span>
							</a>
						</h4>
					</div>
				</div>
				
		</div>

		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script type="text/javascript" src="/application/assets/js/modernizr-2.5.3.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js" type="text/javascript" language="javascript"></script>
		<script type="text/javascript" src="/application/assets/js/scripts.js" language="javascript"></script>
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		<script type="text/javascript">
		 google.load("visualization", "1", {packages:["corechart"]});
		  google.setOnLoadCallback(drawChart); 
		  
		  function drawChart() {
			  var dataTable = new google.visualization.DataTable();
			  dataTable.addColumn('string', 'Time');
			  dataTable.addColumn('number', 'Actual Normalised Sentiment');
			  dataTable.addColumn({type: 'string', role: 'annotation'});
			  dataTable.addColumn('number', 'Expected Normalised Sentiment');
			  dataTable.addColumn({type: 'string', role: 'annotation'});
			  dataTable.addColumn({type: 'string', role: 'annotationText', p: {html:true}});
			  dataTable.addRows([
				['2012-10-30',  <?php echo $day1 ?>, "", 1, "", ""],
			    ['2012-10-31', <?php echo $day2 ?>, "Halloween", 2, "Halloween", createCustomHTMLContent("http://farm4.staticflickr.com/3082/2574368726_e31c3e4bcc.jpg", 2, <?php echo $day2?>)],
			    ['2012-11-01',  <?php echo $day3 ?>, "", 1.7,"", ""],
			    ['2012-11-02',  <?php echo $day4 ?>, "", 1.5, "", ""],
			    ['2012-11-03',  <?php echo $day5 ?>, "", 1, "", ""],
			    ['2012-11-04',  <?php echo $day6 ?>, "", 1.6, "", ""],
			    ['2012-11-05',  <?php echo $day7 ?>, "Fireworks Nights", 2.4, "Fireworks Nights", createCustomHTMLContent("http://farm2.staticflickr.com/1396/542701018_0857403a92.jpg", 2.25, <?php echo $day2 ?>)],
			    ['2012-11-06',  <?php echo $day8 ?>, "", 1.9, "", ""]
			  ]);

			  /*CREATIVE COMMONS LISENCE*/
			  /*HALLOWEEN IMAGE http://farm4.staticflickr.com/3082/2574368726_e31c3e4bcc.jpg */
			  /*FIREWORKS IMAGE http://farm2.staticflickr.com/1396/542701018_0857403a92.jpg */

			  var options = { tooltip: {isHtml: true}, legend: {position: 'top'}, chartArea:{left:65,top:37} };
			  var chart = new google.visualization.LineChart(document.getElementById('chart'));
			  chart.draw(dataTable, options);
			}
		  
		  
		  
		  function createCustomHTMLContent(eventURL, expectedValue, actualValue) {
			  return '<div style="padding:5px 5px 5px 5px;">' +
				  '<img src="' + eventURL + '" style="height:50px" /><br/>' +
				  '<div id="medals_layout">' +
				  '<img style="display:block; margin: 0 auto;" id="smiley" src="/application/assets/i/smiley-' +expectedValue * 4 +'.png" />' +
				  '</div>';
			}
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

		</script>
	</body>
</html>