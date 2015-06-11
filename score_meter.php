<?php

include("config.php");
$topId=$_GET['top'];
$botId=$_GET['bot'];
?>
<div id="jRate"></div>
				<div id="gauge" style="width: 100px; height:80px;"></div>
					<script>
					var g = new JustGage({
					  id: "gauge",
					  value: <?php echo 10 ?>,
					  min: 0,
					  max: 10,
					  title: "Average"
					});
					</script>
				</div>