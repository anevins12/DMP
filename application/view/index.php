<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link type="text/css" rel="stylesheet" href="/application/assets/css/resets.css" />
		<link type="text/css" rel="stylesheet" href="/application/assets/css/fonts.css" />
		<link type="text/css" rel="stylesheet" href="/application/assets/css/960_12_col.css" />
		<link type="text/css" rel="stylesheet" href="/application/assets/css/nav.css" />
		<link type="text/css" rel="stylesheet" href="/application/assets/css/style.css" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script type="text/javascript" src="/application/assets/js/modernizr-2.5.3.min.js"></script>
	</head>

	<body>
		<div id="wrapper">
			<div class="container_12">
				<header>
					<hgroup class="logo grid_6">
						<h1><a href="/application/view/">How Happy</a></h1>
						<h2>Measuring Happiness un UK Cities from Twitter</h2>
					</hgroup>
					<nav class="grid_6">
						<ul>
							<li class="grid_2 alpha">
								<a href="#" class="selected">
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
								<a href="#" class="dropdown">
									<span class="graphs"></span>
									<span class="txt">Mood Graphs</span>				
									<span class="pointer"></span>
									<div class="arrow">
										<div class="tip"></div>
									</div>
								</a>
								<div class="submenu">
									<ul>
										<li><a href="#">Halloween <br />&amp; Fireworks</a></li>
										<li><a href="#">Christmas</a></li>
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
						<li><span class="home icon"></span><span class="txt">Home</span></li>
					</ul>
				</nav>
				<div class="grid_3 alpha description">
					<p>
						Lorem ipsum dolor sit amet, consectetur adipiscing elit.
						Vivamus cursus ultrices urna, vitae consequat massa suscipit eget.
						Aliquam erat volutpat.
					</p>
				</div>
				<div class="grid_3">
					<h3><a href="#">Happiest Cities<span class="pointer"></span></a></h3>
					<div class="image">
						<a href="#">
							<img src="/application/assets/i/home-icon-1.png" alt="Happiest Cities" />
						</a>
					</div>
				</div>
				<div class="grid_3">
					<h3><a href="#">Mood Graphs<span class="pointer"></span></a></h3>
					<div class="image">
						<a href="#">
							<img src="/application/assets/i/home-icon-2.png" alt="Mood Graphs" />
						</a>
					</div>
				</div>
				<div class="grid_3 omega description">
					<p>
						Lorem ipsum dolor sit amet, consectetur adipiscing elit.
						Vivamus cursus ultrices urna, vitae consequat massa suscipit eget.
						Aliquam erat volutpat.
					</p>
				</div>
			</div>
			<div class="container_12" id="footer">
				<!-- nothing to go in here -->
			</div>
		</div>
		<script type="text/javascript">

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