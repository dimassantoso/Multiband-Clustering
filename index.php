<?php
	require_once 'function.php';
	//start(6);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Multiband Clustering</title>
<link rel="stylesheet" type="text/css" href="semantic/dist/semantic.min.css">
<script
  src="https://code.jquery.com/jquery-3.1.1.min.js"
  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
  crossorigin="anonymous"></script>
<script src="semantic/dist/semantic.min.js"></script>
<style type="text/css">
	body{
		padding: 50px;
	}
</style>
</head>
<body>
<div class="ui container" style="margin-bottom:50px;">
	<div class="ui segment">
		<div class="ui header"><center>MULTIBAND CLUSTERING<br>(SATELIT LANDSAT 7)</center></div>
		<div class="ui six column grid">	
			<?php
				for ($i=1; $i <= 7; $i++) {
					if($i==6) continue;
					echo "<div class='column'>"?>
					<div class="ui card">
						<div class="ui image">
							<img title="Result" src="img/gb<?=$i?>.png">
						</div>
						<div class="content">
							<p class="header">Band <?=$i?></p>
						</div>
					</div>
			<?php echo "</div>"; }?>
		</div>
	</div>
	<div class="ui segment">
		<p class="ui header">Image Result</p>
        <div class="ui equal width grid">
			<div class="equal width row">
				<div class="column">
					<div class="ui fluid card">
						<div class="ui image">
							<img title="3 Cluster" src="3cluster.png">
						</div>
						<div class="content">
							<p class="header">3 Cluster</p>
						</div>
					</div>
				</div>
				<div class="column">
					<div class="ui fluid card">
						<div class="ui image">
							<img title="4 Cluster" src="4cluster.png">
						</div>
						<div class="content">
							<p class="header">4 Cluster</p>
						</div>
					</div>
				</div>
			</div>
			<div class="equal width row">
				<div class="column">
					<div class="ui fluid card">
						<div class="ui image">
							<img title="5 Cluster" src="5cluster.png">
						</div>
						<div class="content">
							<p class="header">5 Cluster</p>
						</div>
					</div>
				</div>
				<div class="column">
					<div class="ui fluid card">
						<div class="ui image">
							<img title="6 Cluster" src="6cluster.png">
						</div>
						<div class="content">
							<p class="header">6 Cluster</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>