<?php
include("config.php");

function getAttQuery($categoryId, $att1, $att2)

$queryStart = "SELECT att1.name, att2.name, AVG(user_matchings.rating), 
		STDDEV(user_matchings.rating), COUNT(user_matchings.rating) FROM user_matchings INNER JOIN users, item_matchings, items it1, items it2, 
		item_attributes itatt1, item_attributes itatt2, attributes att1, attributes att2 WHERE user_matchings.rating 
		is not NULL AND users.user_id = user_matchings.user_id AND users.is_spammer = 0 AND user_matchings.match_id = item_matchings.match_id AND
		item_matchings.top_item_id = it1.item_id AND item_matchings.bottom_item_id = it2.item_id AND itatt1.item_id = it1.item_id AND
		itatt2.item_id = it2.item_id AND att1.attribute_id = itatt1.attribute_id AND att2.attribute_id = itatt2.attribute_id AND
		att1.category_id = att2.category_id";

$queryEnd = " GROUP BY att1.attribute_id, att2.attribute_id";

if($categoryId == NULL) {
	$categoryID = 1; // Default
}
	$query = $queryStart." AND att1.category_id = ".$categoryID;
	if($att1 != NULL) {
		$query = $query." AND att1.attribute_id = ". $att1;
	}
	if ($att2 != NULL) {
		$query = $query." AND att2.attribute_id = " .$att2;
	}
	$query = $query.$queryEnd;
}

$attQuery = mysql_query($query) or die(mysql_error());
return $attQuery;
?>