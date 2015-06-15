<?php

function showItemAttributes($item) {
	$attArray = $item->getItemAttributes();
?>
	<table class="table">
		<thead>
		<tr>
			<th class="col-md-6">Category</th>
			<th class="col-md-6">Attribute</th></tr>
		</thead>
		<tbody>
			<?php foreach($attArray as $catId=>$catData) { ?>
				<tr>
					<td>
						<?php echo $catData['cat_name']; ?>
					</td>
					<td>
						<?php echo $catData['att_name']; ?>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php
}

include("config.php");
include("algorithms.php");

$topId=$_GET['top'];
$botId=$_GET['bot'];
$topItem = Item::getItemById($topId);
$bottomItem = Item::getItemById($botId);

$score=calculateTrendScoreFor2Items($topId, $botId);
?>
<div id="jRate"></div>
<div class="col-md-4" align="center">
	<img width='170' src=images/items/<?php echo $topItem->picture; ?> />
	<?php showItemAttributes($topItem) ?>
</div>
				
<div class="col-md-4" align="center">
				<div id="gauge" style="width: 200px; height:160px;"></div>
					<script>
					var g = new JustGage({
					  id: "gauge",
						value: <?php echo round($score, 0) ?>,
					  min: 0,
					  max: 100,
					  title: "Our Score:",
					  levelColors:["#FF0000", "#FFCC33","#00FF00"]
					});
					</script>
				</div>
				
<div class="col-md-4" align="center">
	<img width='170' src=images/items/<?php echo $bottomItem->picture; ?> />
	<?php showItemAttributes($bottomItem) ?>
</div>
