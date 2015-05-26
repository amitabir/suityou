<?php
	include("config.php");
		
	$userId = $_SESSION['user_id'];
	$matchId = $_GET['matchId'];
	
	$matchQuery = mysql_query("SELECT * FROM item_matchings WHERE match_id = ". $matchId);
	
	$row = mysql_fetch_array($matchQuery);
	$topItemId = $row['top_item_id'];
	$bottomItemId = $row['bottom_item_id'];
	$modelPic = $row['model_picture'];
	
	echo "<img src=images/models/$modelPic height='600' width='300'/> <br/>";	
	echo "<a href='show_item.php?itemId=$topItemId'> Buy Top Item </a> <br/>";
	echo "<a href='show_item.php?itemId=$bottomItemId'> Buy Bottom Item </a> <br/>";
	
	echo 'Rating:';
	echo '<span class="star-rating">';
	for ($i = 1; $i <= 10; $i++) {
		echo '<input type="radio" name="rating" value="'.$i.'" onclick="submitUserRating('.$matchId.', '.$userId.', $(this).val(), 10);"><i></i>';
	}
	echo '</span>';
?>
<div id="next">
	<a onclick="skipRating(<?php echo $matchId; ?>, <?php echo $userId; ?>);" href="javascript:void(0);" > Next </a>
</div>