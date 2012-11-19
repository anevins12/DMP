<?php require('../head.php'); ?>
<div class="container_12">
				<header>
					<hgroup class="logo grid_6">
						<h1><a href="/application/view/">How Happy</a></h1>
						<h2>Measuring Happiness un UK Cities from Twitter</h2>
					</hgroup>
					<nav class="grid_6">
						<ul>
							<li class="grid_2 alpha">
								<a href="#">
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
								<a href="#" class="dropdown selected">
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
											<a href="#">
												<span class="halloween"></span>
												Halloween <br />&amp; Fireworks
											</a>
										</li>
										<li>
											<a href="#" class="christmas">
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
						<li><span class="separator">&raquo;</span><span class="graphs icon"></span><span class="txt">Mood Graphs</span></li>
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
					<h3><a class="halloween" href="halloween-and-fireworks/">Halloween &amp; Fireworks<span class="pointer"></span></a></h3>
					<div class="image">
						<a href="halloween-and-fireworks/">
							<img src="/application/assets/i/home-icon-2.png" alt="Halloween &amp; Fireworks" />
						</a>
					</div>
				</div>
				<div class="grid_3">
					<h3><a href="#">Christmas<span class="pointer"></span></a></h3>
					<div class="image">
						<a href="#">
							<img src="/application/assets/i/home-icon-2.png" alt="Christmas" />
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