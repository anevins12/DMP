<!DOCTYPE html>

<?php
	include_once(  dirname(__FILE__) . '/../../../controller/tweets.php' );

	$tweets = new Tweets();
	$allTweets = $tweets->index();

	$graphData = $tweets->getGoogleLineGraphFormat($allTweets);
	
	$day1 = $graphData[0];
	$day2 = $graphData[1];
	$day3 = $graphData[2];
	$day4 = $graphData[3];
	$day5 = $graphData[4];
	$day6 = $graphData[5];
	$day7 = $graphData[6];
	$day8 = $graphData[7];
	$day9 = $graphData[8];

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
				<div class="grid_12 alpha">
					<div id="chart">
					</div>
				</div>
				<div class="grid_12">
<!--					<div id="key">
						<h3>Key</h3>
						<ul>
							<li class="info icon">More Information</li>
						</ul>
					</div>-->
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
							<a href="/application/view/moodgraphs/halloween-and-fireworks/">
								<span class="halloween icon"></span>
								<span class="text">Halloween &amp; Fireworks</span>
								<span class="arrow-right"></span>
							</a>
						</h4>
					</div>
				</div>

		</div>

		<script type="text/javascript" src="/application/assets/js/modernizr-2.5.3.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js" type="text/javascript" language="javascript"></script>
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		<script type="text/javascript">
		 google.load("visualization", "1", {packages:["corechart"]});
		  google.setOnLoadCallback(drawChart);
		  function drawChart() {
			  var dataTable = new google.visualization.DataTable();
			  dataTable.addColumn('string', 'Time');
			  dataTable.addColumn('number', 'Actual Normalised Sentiment');
			  dataTable.addColumn({type: 'string', role: 'annotation'});
			  //dataTable.addColumn('number', 'Expected Normalised Sentiment');
			  dataTable.addColumn({type: 'string', role: 'annotation'});
			  dataTable.addColumn({type: 'string', role: 'annotationText', p: {html:true}});
			  dataTable.addRows([
				['2012-12-20',  <?php echo $day1 ?>, "", "", ""],
				['2012-12-21',  <?php echo $day2 ?>, "", "", ""],
				['2012-12-22',  <?php echo $day3 ?>, "", "", ""],
			    ['2012-12-23', <?php echo $day4 ?>, "", "", ""],
			    ['2012-12-24',  <?php echo $day5 ?>, "","", ""],
			    ['2012-12-25',  <?php echo $day6 ?>, "Christmas Day", "", ""],
			    ['2012-12-26',  <?php echo $day7 ?>, "", "", ""],
			    ['2012-12-27',  <?php echo $day8 ?>, "", "", ""],
			    ['2012-12-28',  <?php echo $day9 ?>, "", "", ""]
			  ]);

			  /*CREATIVE COMMONS LISENCE*/
			  /*HALLOWEEN IMAGE http://farm4.staticflickr.com/3082/2574368726_e31c3e4bcc.jpg */
			  /*FIREWORKS IMAGE http://farm2.staticflickr.com/1396/542701018_0857403a92.jpg */

			  var options = { tooltip: {isHtml: true}, legend: {position: 'top'}, chartArea:{left:65,top:37}, width: 1210, height: 400 };
			  var chart = new google.visualization.LineChart(document.getElementById('chart'));
			  chart.draw(dataTable, options);
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