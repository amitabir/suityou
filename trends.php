<?php
include("header.php");
include("algorithms.php");
//$gender = $_GET["gender"];
$limit=4;
$query = mysql_query('SELECT * FROM item_matchings WHERE match_type=0  LIMIT '.$limit);
//function showTable($query){
	echo '<table border="1px">';
			 	while($row = mysql_fetch_array($query)) {
					$key=calculateTotalScoreForTrends($row["match_id"]);
					$array[$key]=$row;
				}
				arsort($array);
			foreach($array as $key=>$row){
				$topId=$row['top_item_id'];
				$bottomId=$row['bottom_item_id'];
				$queryTop = mysql_query('SELECT * FROM items WHERE item_id='.$topId);
				$queryBottom = mysql_query('SELECT * FROM items WHERE item_id='.$bottomId);
				if ($rowTop = mysql_fetch_array($queryTop)) {
					if ($rowBottom = mysql_fetch_array($queryBottom)) {
						$pictureTop=$rowTop['picture'];
						$pictureBottom = $rowBottom['picture'];
						$priceTop = $rowTop['price'];
						$priceBottom = $rowBottom['price'];
						echo "<tr>";
						echo "<td> <img width='170' src=images/items/$pictureTop /> <br/> $priceTop <br/> <a href='show_item.php?itemId=$topId'> Buy Now </a> </td>";
						echo "<td> <img width='170' src=images/items/$pictureBottom /> <br/> $priceBottom <br/> <a href='show_item.php?itemId=$bottomId'> Buy Now </a> </td>";
						echo "<td> our matching score is $key ! <td/>";
						echo "<tr/>";
						
					}
				}
			}
			echo '</table>';
//}
?>