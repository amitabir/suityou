<?php

include("config.php");
include("algorithms.php");

$topId=$_GET['top'];
$botId=$_GET['bot'];
$score=7.5;
//$score=calculateTrendScoreFor2Items($topId, $botId);
$imQuTop=mysql_query('SELECT picture FROM items WHERE item_id='.$topId);
$imQuBot=mysql_query('SELECT picture FROM items WHERE item_id='.$botId);
$rowTop=mysql_fetch_array($imQuTop);
$rowBot=mysql_fetch_array($imQuBot);
$pictureTop=$rowTop[0];
$pictureBot=$rowBot[0];

?>
<div id="jRate"></div>
<div class="col-md-4" align="center">
	<img width='170' src=images/items/<?php echo $pictureTop; ?> />
				</div>
<div class="col-md-4" align="center">
				<div id="gauge" style="width: 200px; height:160px;"></div>
					<script>
					var g = new JustGage({
					  id: "gauge",
					  value: <?php echo $score ?>,
					  min: 0,
					  max: 10,
					  title: "Our Score:"
					});
					</script>
				</div>
				
				<div class="col-md-4" align="center">
				<img width='170' src=images/items/<?php echo $pictureBot; ?> />
				</div>