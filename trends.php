<?php
include("header.php");
include("algorithms.php");
include("rating.php");

$userId = $_SESSION['user_id'];
$query = mysql_query('SELECT itmatch.*, it1.picture as top_pic, it1.price as top_price, it2.picture as bottom_pic, it2.price as bottom_price FROM item_matchings itmatch INNER JOIN items it1, items it2 WHERE itmatch.top_item_id = it1.item_id AND itmatch.bottom_item_id = it2.item_id AND itmatch.match_type = 0');
echo '<table border="1px">';
while($row = mysql_fetch_array($query)) {
	$key=calculateTotalScoreForTrends($row["match_id"]);
	$array[$key]=$row;
}
arsort($array);
foreach($array as $key=>$row) {
	$matchId = $row['match_id'];
	$topId=$row['top_item_id'];
	$bottomId=$row['bottom_item_id'];
	$pictureTop=$row['top_pic'];
	$pictureBottom = $row['bottom_pic'];
	$priceTop = $row['top_price'];
	$priceBottom = $row['bottom_price'];
	echo "<tr>";
	echo "<td> <img width='170' src=images/items/$pictureTop /> <br/> $priceTop <br/> <a href='show_item.php?itemId=$topId'> Buy Now </a> </td>";
	echo "<td> <img width='170' src=images/items/$pictureBottom /> <br/> $priceBottom <br/> <a href='show_item.php?itemId=$bottomId'> Buy Now </a> </td>";
	echo "<td> Match Percent: $key% <br/> What do you think? <br/>";
	showRating($matchId, $userId);	
	echo "</td></tr>";
}
echo '</table>';
?>