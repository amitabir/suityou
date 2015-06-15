<?php
include("header.php");
include("algorithms.php");
include("rating.php");

if(isset($_SESSION['user_id'])){
	$userId = $_SESSION['user_id'];
} else {
	$userId = NULL;
}
$query = mysql_query('SELECT itmatch.*, it1.picture as top_pic, it1.price as top_price, it1.name as top_name, it2.picture as bottom_pic, it2.price as bottom_price, it2.name as bottom_name FROM item_matchings itmatch INNER JOIN items it1, items it2 WHERE itmatch.top_item_id = it1.item_id AND itmatch.bottom_item_id = it2.item_id AND itmatch.match_type = 0');

$num_rows = mysql_num_rows($query);
if ($num_rows == 0) {
?>
	<div class="container">
		<div class="row">
			<h3>There are no trends yet! Please try again later. </h3>
			</div>
		</div>
<?php
} else {
	while($row = mysql_fetch_array($query)) {
		$key=calculateTotalScoreForTrends($row["match_id"]);
		$array[$key]=$row;
	}
	krsort($array);
	?>
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header" align="center">
					Trends
				</h1>
			</div>
		</div>
	
	<?php
	foreach($array as $key=>$row) {
		$matchId = $row['match_id'];
		$topId=$row['top_item_id'];
		$bottomId=$row['bottom_item_id'];
		$pictureTop=$row['top_pic'];
		$pictureBottom = $row['bottom_pic'];
		$priceTop = $row['top_price'];
		$priceBottom = $row['bottom_price'];
		$nameTop = $row['top_name'];
		$nameBottom = $row['bottom_name'];
		?>
	
		<div class="row">
			<div class="panel panel-default">	
				<div class="panel-heading">
				              <h3 class="panel-title"><?php echo round($key, 0)?>% Match</h3>
				            </div>
				<div class="panel-body">
			<div class="col-md-4">
			
				<a href="show_item.php?itemId=<?php echo $topId; ?>" class="thumbnail">
				    <img src="images/items/<?php echo $pictureTop; ?>" class="img-responsive shop_thumbnail">
						<p align="center"> <?php echo $nameTop; ?></p>
					<p align="center"> $<?php echo $priceTop; ?></p>
				</a>
			</div>
			<div class="col-md-4">
	 			<a href="show_item.php?itemId=<?php echo $bottomId; ?>" class="thumbnail">
				    <img src="images/items/<?php echo $pictureBottom; ?>" class="img-responsive shop_thumbnail">
					<p align="center"> <?php echo $nameBottom; ?></p>
	 				<p align="center"> $<?php echo $priceBottom; ?></p>
	 			</a>
			</div>
			<script>
				$(document).ready(function() {
					$.ajax({ url: "show_trend_match.php?matchId=<?php echo $matchId; ?>",
							context: document.body,
							success: function(result) {
							  $("#match_<?php echo $matchId; ?>").html(result);
					}});
				});
			</script>
			<div id="match_<?php echo $matchId; ?>" class="col-md-4" align="center">
			</div>
		  </div>
			</div>
		</div>	
	<?php } ?>
	</div>
<?php } ?>