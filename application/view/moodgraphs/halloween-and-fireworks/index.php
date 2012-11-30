<!DOCTYPE html>

<?php

	include_once(  dirname(__FILE__) . '/../../../controller/tweets.php' );

	$tweets = new Tweets();
	$allTweets = $tweets->index();

//
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
						<li><span class="separator">&raquo;</span><span class="halloween icon"></span><span class="txt">Halloween</span></li>
					</ul>
				</nav>
				<div class="grid_8 alpha">
					<div id="chart">
					</div>
				</div>
				<div class="grid_4">
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
			  dataTable.addColumn('number', 'Normalised Sentiment');
			  dataTable.addColumn({type: 'string', role: 'annotation'});
			  dataTable.addColumn('number', 'Expected Normalised Sentiment');
			  dataTable.addColumn({type: 'string', role: 'annotation'});
			  dataTable.addColumn({type: 'string', role: 'annotationText', p: {html:true}});
			  dataTable.addRows([
				['2012-10-30',  <?php echo $day1 ?>, "", 1, "", ""],
			    ['2012-10-31', <?php echo $day2 ?>, "Halloween", 2, "Halloween", createCustomHTMLContent("<img width=100px src='http://farm1.staticflickr.com/33/57850248_4c2697e0a8.jpg'>", <?php echo $day2?>)],
			    ['2012-11-01',  <?php echo $day3 ?>, "", 1.7,"", ""],
			    ['2012-11-02',  <?php echo $day4 ?>, "", 1.5, "", ""],
			    ['2012-11-03',  <?php echo $day5 ?>, "", 1, "", ""],
			    ['2012-11-04',  <?php echo $day6 ?>, "", 1.6, "", ""],
			    ['2012-11-05',  <?php echo $day7 ?>, "Fireworks Nights", 2.1, "Fireworks Nights", createCustomHTMLContent("<img width=100px src='http://farm4.staticflickr.com/3596/3790283930_bdf5f56b73.jpg'>")],
			    ['2012-11-06',  <?php echo $day8 ?>, "", 1.9, "", ""]
			  ]);

			  /*CREATIVE COMMONS LISENCE*/
			  /*HALLOWEEN IMAGE http://farm1.staticflickr.com/33/57850248_4c2697e0a8.jpg */
			  /*FIREWORKS IMAGE http://farm4.staticflickr.com/3596/3790283930_bdf5f56b73.jpg */

			  var options = { tooltip: {isHtml: true}};
			  var chart = new google.visualization.LineChart(document.getElementById('chart'));
			  chart.draw(dataTable, options);
			}
		  
		  
		  
		  function createCustomHTMLContent(eventURL, sentimentValue) {
  return '<div style="padding:5px 5px 5px 5px;">' +
      '<img src="' + eventURL + '" style="width:75px;height:50px"><br/>' +
      '<table id="medals_layout">' +
      '<tr>' +
      '<td><img src="/application/assets/i/smiley-2.png" /></td>' +
      '<td><b>' + sentimentValue + '</b></td>' +
      '</tr>' +
      '</table>' +
      '</div>';
}
		  
		  
		  
		  
//		  function drawChart() {

//
//			var data = google.visualization.arrayToDataTable([
//			  ['Time', 'Sentiment'],
//			  ['2012-10-30',  <?php// echo $day1 ?>],
//			  ['HALLOWEEN',  <?php //echo $day2 ?>],
//			  ['2012-11-01',  <?php //echo $day3 ?>],
//			  ['2012-11-02',  <?php //echo $day4 ?>],
//			  ['2012-11-03',  <?php //echo $day5 ?>],
//			  ['2012-11-04',  <?php //echo $day6 ?>],
//			  ['FIREWORKS',  <?php //echo $day7 ?>],
//			  ['2012-11-06',  <?php //echo $day8 ?>]
//			]);
//
//			  data.addColumn({type: 'string', role: 'annotation'});
//			  data.addColumn({type: 'string', role: 'annotationText', p: {html:true}});
//
//			var options = {
//			    title: 'Halloween to Fireworks Night Mood Graph'
//			};
//
////			var chart = new google.visualization.LineChart(document.getElementById('chart'));
////			chart.draw(data,  options);
//
//
//		    // Create and draw the visualization.
//			new google. visualization.LineChart(document.getElementById('chart')).draw(data, options);
//		  }
//
//
//		function createCustomHTMLContent(flagURL, totalGold, totalSilver, totalBronze) {
//		  return '<div style="padding:5px 5px 5px 5px;">' +
//			  '<img src="' + flagURL + '" style="width:75px;height:50px"><br/>' +
//			  '<table id="medals_layout">' +
//			  '<tr>' +
//			  '<td><img src="http://upload.wikimedia.org/wikipedia/commons/1/15/Gold_medal.svg" style="width:25px;height:25px"/></td>' +
//			  '<td><b>' + totalGold + '</b></td>' +
//			  '</tr>' +
//			  '<tr>' +
//			  '<td><img src="http://upload.wikimedia.org/wikipedia/commons/0/03/Silver_medal.svg" style="width:25px;height:25px"/></td>' +
//			  '<td><b>' + totalSilver + '</b></td>' +
//			  '</tr>' +
//			  '<tr>' +
//			  '<td><img src="http://upload.wikimedia.org/wikipedia/commons/5/52/Bronze_medal.svg" style="width:25px;height:25px"/></td>' +
//			  '<td><b>' + totalBronze + '</b></td>' +
//			  '</tr>' +
//			  '</table>' +
//			  '</div>';
//		}
//
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