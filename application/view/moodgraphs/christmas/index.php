<!DOCTYPE html>

<?php

	include_once(  dirname(__FILE__) . '/../../../controller/tweets.php' );

	$tweets = new Tweets();
	$allTweets = $tweets->index();

	$graphData = $tweets->getGoogleLineGraphFormat($allTweets);
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

	<div class="container_12">
				<header>
					<hgroup class="logo grid_6">
						<h1><a href="/application/view/">How Happy</a></h1>
						<h2>Measuring Happiness un UK Cities from Twitter</h2>
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
								<a href="#">
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
											<a href="/application/view/moodgraphs/halloween-and-fireworks/">
												<span class="halloween"></span>
												Halloween <br />&amp; Fireworks
											</a>
										</li>
										<li>
											<a href="/application/view/moodgraphs/christmas/" class="christmas selected">
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
						<li><span class="separator">&raquo;</span><span class="christmas icon"></span><span class="txt">Christmas</span></li>
					</ul>
				</nav>
				<div class="grid_8 alpha">
					<div id="chart">
					</div>
				</div>
				<div class="grid_4">
					<div id="key">
						<h3>Key</h3>
						<ul>
							<li class="info icon">More Information</li>
						</ul>
					</div>
					<div class="" id="description">
						<p>
						Lorem ipsum dolor sit amet, consectetur adipiscing elit.
						</p>
						<p>
						Vivamus cursus ultrices urna, vitae consequat massa suscipit eget. Aliquam erat volutpat.
						</p>
						<p>
						In hac habitasse platea dictumst. Aliquam erat volutpat. Duis id erat mi. Ut nec dui leo, eu molestie ante.
						</p>
						<p>
						Mauris risus odio, vestibulum at convallis vitae, vehicula eu.
						</p>
					</div>
					<div class="grid_4 alpha" id="next">
						<h4>
							<a href="../halloween-and-fireworks/">
								<span class="halloween icon"></span>
								<span class="text">Halloween &amp; Fireworks</span>
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
			var data = google.visualization.arrayToDataTable([
			  ['Time', 'Sentiment'],
			  ['2012-10-30',  <?php echo $day1 ?>],
			  ['HALLOWEEN',  <?php echo $day2 ?>],
			  ['2012-11-01',  <?php echo $day3 ?>],
			  ['2012-11-02',  <?php echo $day4 ?>],
			  ['2012-11-03',  <?php echo $day5 ?>],
			  ['2012-11-04',  <?php echo $day6 ?>],
			  ['FIREWORKS',  <?php echo $day7 ?>],
			  ['2012-11-06',  <?php echo $day8 ?>]
			]);

			var options = {
			  title: 'Halloween to Fireworks Night Mood Graph'
			};

			var chart = new google.visualization.LineChart(document.getElementById('chart'));
			chart.draw(data,  options);
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