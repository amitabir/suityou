<?php
	define("PERCENT_FACTOR", 10);
	
	// Get the constants from DB, should be cached in the future to avoid so many database accesses
	function getConstants() {
		$result = array();
		$constantQuery = mysql_query("SELECT name, value FROM constants");
		while ($row = mysql_fetch_array($constantQuery)) {
			$result[$row['name']] = $row['value'];
		}
		return $result;
	}
	
	function getConstantsWithDescription() {
		$result = array();
		$constantQuery = mysql_query("SELECT * FROM constants");
		while ($row = mysql_fetch_array($constantQuery)) {
			$result[$row['name']] = array("value" => $row['value'], "description" => $row['description']);
		}
		return $result;
	}
	
	/* This function receives data about match rating for two items and a new vote value and returns the new rating, new number of 
	   ignored votes and the new ignored average. */
	// Normal match
	function calcNewRatingForTwoItems($newRating, $averageRating, $numberOfVotes, $numberOfIgnoredVotes, $ignoredAverage) {
		$constantsArray = getConstants();
		$newRating *= PERCENT_FACTOR;
		// Accept new rating - may be not enough votes yet or new vote is not dramatically different.
		if(($numberOfVotes < $constantsArray['VOTES_LIMIT_FOR_ACCEPT_NEW_VOTE']) or (abs($newRating - $averageRating) <= $constantsArray['DIFF_FOR_ACCEPT_NEW_VOTE'])){
			$newNumberOfVotes = $numberOfVotes + 1;
			$newAverage = ($newRating + $averageRating * $numberOfVotes)/($newNumberOfVotes);
			$newIgnoredAverage = $ignoredAverage;
			$newNumberOfIgnoredVotes = $numberOfIgnoredVotes;
		// Vote was rejected
		} else {
			$newIgnoredAverage = ($newRating + $ignoredAverage * $numberOfIgnoredVotes)/($numberOfIgnoredVotes + 1);
			$newNumberOfIgnoredVotes = $numberOfIgnoredVotes + 1;
			// Number of ignored votes reached limits so join the rating with rejected rating
			if($newNumberOfIgnoredVotes == $constantsArray['IGNORED_VOTES_LIMIT_FOR_ACCEPT']){
				$newAverage = ($averageRating * $numberOfVotes + $newIgnoredAverage * ($numberOfIgnoredVotes + 1))/($numberOfIgnoredVotes + 1 + $numberOfVotes);
				$newNumberOfVotes = $numberOfVotes + $newNumberOfIgnoredVotes;
				$newNumberOfIgnoredVotes = 0;
				$newIgnoredAverage = 0;
			// Add new vote to the rejected
			} else {
				$newAverage = $averageRating;
				$newNumberOfVotes = $numberOfVotes;
			}
		}
		return array($newAverage, $newNumberOfVotes, $newIgnoredAverage, $newNumberOfIgnoredVotes);
	}
	
	/* This function receives two array. The first is the ratings of all the attributes and the second is the weight to 
		be given for each one. The weighted arithmetic mean is calculated and returned. */
	// Trends
	function calcTotalRatingForTwoItems(array $atrributesRatings, array $weights) {
		// Calculating the total weight.
		$totalWeight = 0;
		foreach($weights as $weight){
			$totalWeight += $weight;
		}
		// Calculating the total rating
		$totalRating = 0;
		for($i = 0; $i < count($weights); $i++){
			$totalRating += $averageRating[i] * $weights[i];
		}
		// Returning the averaged rating;
		return totalRating / totalWeight;
	}
	
	function isSpammer($userID){
		$query = mysql_query("SELECT is_spammer FROM Users WHERE user_id = ".$userID);
		$row = mysql_fetch_array($query);
		return $row['is_spammer'];
	}
	
	function calculateTotalScoreForTrends($trendID){
		$constantsArray = getConstants();
		$matchQuery = mysql_query("SELECT match_percent, match_count, trend_percent 
		FROM item_matchings WHERE match_id = ".$trendID) or die(mysql_error());
		$matchRow = mysql_fetch_array($matchQuery);
		if($matchRow["match_count"] > $constantsArray['VOTES_LIMIT_FOR_ACCEPT_NEW_VOTE']){
			return ($constantsArray['TREND_CONSTANT'] * $matchRow["trend_percent"] + $constantsArray['MATCH_CONSTANT'] * $matchRow["match_percent"])/($constantsArray['TREND_CONSTANT'] + $constantsArray['MATCH_CONSTANT']);
		}
		return $matchRow["trend_percent"];
	}
	
	function isGoodCouple($data){
		$constantsArray = getConstants();
		if($data["avg"] > $constantsArray['AVERAGE_LIMIT'] and $data["stdev"] < $constantsArray['STDEV_LIMIT']){
			return true;
		}
		return false;
	}
	
	function calculateTrendScore($topItemAttributes, $bottomItemAttributes, $attributesData){
		$constantsArray = getConstants();
		$score = 0;
		$count = 0;
		foreach($topItemAttributes as $topCategoryID=>$topAttribute){
			foreach($bottomItemAttributes as $bottomCategoryID=>$bottomAttribute){
				if($topCategoryID == $bottomCategoryID){
					$topAttributeID = $topAttribute["att_id"];
					$bottomAttributeID = $bottomAttribute["att_id"];
					if(array_key_exists($topAttributeID."-".$bottomAttributeID, $attributesData)){
						$count++;
						$score += PERCENT_FACTOR * $attributesData[$topAttributeID."-".$bottomAttributeID]["avg"]/$constantsArray['NUMBER_OF_CATEGORIES'];
					}
				}
			}
		}
		return $score;
	}
	
	function checkIfMatchAndTrendExists($topItemID, $bottomItemID){
		$matchQuery = mysql_query("SELECT match_type FROM item_matchings WHERE
		top_item_id = ".$topItemID." AND bottom_item_id = ".$bottomItemID) or die(mysql_error());
		if(mysql_num_rows($matchQuery)== 0){
			$matchExists = false;
			$trendExists = false;
		} else {
			$matchRow = mysql_fetch_array($matchQuery);
			if($matchRow[0] == 1){
				$matchExists = true;
				$trendExists = false; //doesn't matter
			} else {
				$matchExists = false;
				$trendExists = true;
			}
		}
		return array($matchExists, $trendExists);
	}
	
	function dealWithNewVoteTrend() {
		$constantsArray = getConstants();
		$query = mysql_query("SELECT att1.attribute_id, att2.attribute_id, AVG(user_matchings.rating), COUNT(user_matchings.rating),
		STDDEV(user_matchings.rating) FROM user_matchings INNER JOIN users, item_matchings, items it1, items it2, 
		item_attributes itatt1, item_attributes itatt2, attributes att1, attributes att2 WHERE user_matchings.rating 
		is not NULL AND users.user_id = user_matchings.user_id AND users.is_spammer = 0 AND user_matchings.match_id = item_matchings.match_id AND
		item_matchings.top_item_id = it1.item_id AND item_matchings.bottom_item_id = it2.item_id AND itatt1.item_id = it1.item_id AND
		itatt2.item_id = it2.item_id AND att1.attribute_id = itatt1.attribute_id AND att2.attribute_id = itatt2.attribute_id AND
		att1.category_id = att2.category_id GROUP BY att1.attribute_id, att2.attribute_id") or die(mysql_error());
		$attributesData = array();
		while($row = mysql_fetch_array($query)) {
			$attributesData[$row[0]."-".$row[1]] = array("avg" => $row[2], "count"=>$row[3], "stdev" => $row[4]);
		}
		foreach($attributesData as $attributes=>$data) {
			$attributesID = explode("-", $attributes);
			//echo "att1 = ".$attributesID[0]." att2 = ".$attributesID[1]."</br>";
			$itemsQuery = mysql_query("SELECT it1.item_id, it2.item_id FROM items it1, items it2,
			item_attributes itatt1, item_attributes itatt2 WHERE itatt1.attribute_id =".$attributesID[0]." AND 
			itatt2.attribute_id = ".$attributesID[1]." AND it1.item_id = itatt1.item_id AND it2.item_id = itatt2.item_id 
			AND it1.type = 'TOP' AND  it2.type = 'BOTTOM' AND it1.gender = it2.gender") or die(mysql_error());
/* 			$items = mysql_fetch_array($itemsQuery);
			if(empty($items)){
				continue;
			} */
			while($items = mysql_fetch_array($itemsQuery)){
				$topItem = Item::getItemByID($items[0]);
				$bottomItem = Item::getItemByID($items[1]);
				$topItemAttributes = $topItem->getItemAttributes();
				$bottomItemAttributes = $bottomItem->getItemAttributes();
				$matchAndTrendExists = checkIfMatchAndTrendExists($items[0], $items[1]);
				if(!$matchAndTrendExists[0]) {
				//	echo "match doesn't exist</br>";
					$trendScore = calculateTrendScore($topItemAttributes, $bottomItemAttributes, $attributesData);
				//	echo "Score is : ".$trendScore."</br>";
					if($matchAndTrendExists[1]) {
						mysql_query("UPDATE item_matchings SET trend_percent = ".$trendScore."
						WHERE top_item_id = ".$items[0]." AND bottom_item_id = ".$items[1]) or die(mysql_error());
					} else if(isGoodCouple($data) and $trendScore >= $constantsArray['TREND_SCORE_LIMIT'] and $data["count"] >= $constantsArray['TREND_MIN_COUNT']) {
				//		echo "Inserting</br>";
						mysql_query("INSERT INTO item_matchings(top_item_id, bottom_item_id, trend_percent, match_type)
						VALUES (".$items[0].", ".$items[1].", ".$trendScore.", 0)") or die(mysql_error());
					}
				}
			}
		}
	}
	
	function removeOldTrends(){
		$constantsArray = getConstants();
		$matchTrendQuery = mysql_query("DELETE FROM item_matchings WHERE match_type = 0 AND (trend_percent < ".$constantsArray['TREND_SCORE_LIMIT']." OR (match_percent < ".$constantsArray['MATCH_SCORE_LIMIT']." AND match_percent > 0) )") or die(mysql_error());
	}
	
	function increaseCouponMeter($userID, $increaseSize){
		$constantsArray = getConstants();
		if($userID == NULL){
			if (!isset($_SESSION["user_data"])) {
				$_SESSION["user_data"] = array();
			}
			
			// Don't increase coupon meter for spammers
			if (isset($_SESSION["user_data"]["is_spammer"]) and $_SESSION["user_data"]["is_spammer"]) {
				return;
			}
				
			if(	isset($_SESSION['user_data']['coupon_meter'])){
				$_SESSION['user_data']['coupon_meter'] += $increaseSize;
			} else {
				$_SESSION['user_data']['coupon_meter'] = $increaseSize;
			}
			if($_SESSION['user_data']['coupon_meter'] > $constantsArray['MAX_COUPON']){
				$_SESSION['user_data']['coupon_meter'] = $constantsArray['MAX_COUPON'];
			}
		} else {
			$couponQuery = mysql_query("SELECT coupon_meter, is_spammer FROM users WHERE user_id = ".$userID) or die(mysql_error());
			$couponRow = mysql_fetch_array($couponQuery);
			if ($couponRow['is_spammer'] == 1) {
				// Don't increase coupon meter for spammers
				return;
			}
			$newCouponMeter = $couponRow["coupon_meter"] + $increaseSize;
			if($newCouponMeter > $constantsArray['MAX_COUPON']){
				$newCouponMeter = $constantsArray['MAX_COUPON'];
			}
			mysql_query("UPDATE users
						 SET coupon_meter = ".$newCouponMeter."
						 WHERE user_id = ".$userID) or die(mysql_error());
		}
	}
	
	function addUserRatingToHistory($userID, $matchID, $rating, $isSkip) {
		if ($userID == NULL) {
			// User Not signed in - save the rating in the session
			if (!isset($_SESSION["user_data"])) {
				$_SESSION["user_data"] = array();
			}
			
			if (!isset($_SESSION["user_data"]["user_matchings"])) {
				$_SESSION["user_data"]["user_matchings"] = array();
			}
			
			$ratingRecord = array($matchID => array("rating" => $rating, "ratingTime" => time(), "skip" => $isSkip));

			$_SESSION["user_data"]["user_matchings"] += $ratingRecord;
		} else {
			// User signed in - insert to DB.
			if($isSkip){
				mysql_query('INSERT INTO user_matchings(user_id, match_id, skipped) VALUES ('.$userID.', '.$matchID.', 1)') or die(mysql_error());
			} else {
				mysql_query('INSERT INTO user_matchings(user_id, match_id, rating, skipped) VALUES ('.$userID.', '.$matchID.', '.$rating.', 0)') or die(mysql_error());
			}
		}	
	}
	
	/* This function receives a vote, a match ID which the vote belongs to and a user ID which gave the vote.
	   First a spammer check is made and if the user is clean then get the necessary data from the DB, run the
	   calcNewRatingForTwoItems function and update the DB. */
	// Normal match + Trends
	function handleUserRating($matchID, $userID, $rating, $time) {
		$constantsArray = getConstants();
		addUserRatingToHistory($userID, $matchID, $rating, 0);
		increaseCouponMeter($userID, $constantsArray['COUPON_PRIZE']);
		$isSpammer = checkIsSpammer($userID, $rating, $time);
		if (!$isSpammer) {
			$query = mysql_query("SELECT * FROM item_matchings WHERE match_id = ".$matchID) or die(mysql_error());
			$row = mysql_fetch_array($query);
			$averageRating = $row['match_percent'];
			$numberOfVotes = $row['match_count'];
			$ignoredAverage = $row['ignored_match_percent'];
			$numberOfIgnoredVotes = $row['ignored_match_count'];
			$result = calcNewRatingForTwoItems($rating, $averageRating, $numberOfVotes, $numberOfIgnoredVotes, $ignoredAverage);
			mysql_query("UPDATE item_matchings
					 	 SET match_percent =".$result[0].", match_count = ".$result[1].", ignored_match_percent = ".$result[2].", ignored_match_count = ".$result[3]." WHERE match_id = ".$matchID) or die(mysql_error());
				
			dealWithNewVoteTrend();			
			removeOldTrends();
			
		}
	}
	
	function handleUserSkip($matchID, $userID) {
		addUserRatingToHistory($userID, $matchID, NULL, true);
	}
	
	function setUserAsSpammer($userID) {
		if ($userID == NULL) {
			$_SESSION["user_data"]["is_spammer"] = true;
			$_SESSION["user_data"]["is_spammer_time"] = date('Y-m-d G:i:s');
		} else {
			mysql_query("UPDATE users
						 SET is_spammer = 1, is_spammer_time = '".date('Y-m-d G:i:s').
						 "' WHERE user_id = ".$userID) or die(mysql_error());
		}
	}
	
	function updateUserTimeTracking($userID, $timeTracking) {
		if ($userID == NULL) {		
			$_SESSION["user_data"]["time_tracking"] = $timeTracking;
		} else {
			mysql_query("UPDATE users
						 SET time_tracking_ctr = ".$timeTracking."
						 WHERE user_id = ".$userID);
		}
	}
	
	function getUserTimeTracking($userID) {
		if ($userID == NULL) {
			if (!isset($_SESSION["user_data"])) {
				$_SESSION["user_data"] = array();
			}
			
			if (!isset($_SESSION["user_data"]["time_tracking"])) {
				$_SESSION["user_data"]["time_tracking"] = 0;
			}
			
			return $_SESSION["user_data"]["time_tracking"];
		} else {
			$user = User::getUserfromDBbyID($userID);
			return $user->time_tracking_ctr;
		}
	}
	
	function getLastUserRatings($userID) {
		$constantsArray = getConstants();
		$result = array();
		if ($userID == NULL) {
			if (!isset($_SESSION["user_data"])) {
				$_SESSION["user_data"] = array();
			}
			
			if (!isset($_SESSION["user_data"]["user_matchings"])) {
				$_SESSION["user_data"]["user_matchings"] = array();
			}
			
			$counter = 0;
			$reversedRatings = array_reverse($_SESSION["user_data"]["user_matchings"]);
			
			foreach ($reversedRatings as $matchId=>$ratingData) {
				if ($counter > $constantsArray['BAD_RATING_REPEAT_LIMIT']) {
					break;
				}
				array_push($result, $ratingData["rating"]);
				$counter++;
			}
		} else {
			$lastRatingsQuery = mysql_query("SELECT rating FROM user_matchings WHERE user_id = ".$userID." ORDER BY rating_time DESC LIMIT  ".$constantsArray['BAD_RATING_REPEAT_LIMIT']);
			while ($lastRatingRow = mysql_fetch_array($lastRatingsQuery)) {
				array_push($result, $lastRatingRow["rating"]);
			}
		}
		return $result;
	}
	
	/* This function receives a user id, his vote and the time it took for him to vote. Then the function decides if
		the user is a spammer and if so updates it to the DB. It also updates the time_tracking, vote_tracking and
		last_vote fields un the Users table.*/
	function checkIsSpammer($userId, $rating, $time) {
		$constantsArray = getConstants();
		if($time < $constantsArray['MINIMAL_TIME']) {
			$timeTracking = getUserTimeTracking($userId);
			$timeTracking++;
			updateUserTimeTracking($userId, $timeTracking);
			if($timeTracking > $constantsArray['BAD_TIME_REPEAT_LIMIT']) {
				setUserAsSpammer($userId);
				return true;
			}
		} else {
			updateUserTimeTracking($userId, 0);
		}
		
		// Check last votes		
		$lastRatings = getLastUserRatings($userId);
		if (count($lastRatings) == $constantsArray['BAD_RATING_REPEAT_LIMIT']) {
			$is_all_same_rating = true;
			$rating = $lastRatings[0];
			for ($i = 1; $i < count($lastRatings); $i++) {
				if ($rating != $lastRatings[$i]) {
					$is_all_same_rating = false;
					break;
				}
			}
			if ($is_all_same_rating) {
				setUserAsSpammer($userId);
				return true;
			}
		}
		return false;
	}
	
	function insertAnonUserToDB($userID){
		if(isset($_SESSION['user_data'])){
			if(isset($_SESSION['user_data']["is_spammer"]) and $_SESSION['user_data']["is_spammer"]){
				mysql_query("UPDATE users
							 SET is_spammer = 1, is_spammer_time = '".$_SESSION['user_data']["is_spammer_time"]."', time_tracking_ctr = ".$_SESSION['user_data']["time_tracking"].", coupon_meter = ".$_SESSION['user_data']['coupon_meter']."
							 WHERE user_id = ".$userID);
				foreach($_SESSION['user_data']["user_matchings"] as $matchID=>$matchData){
					$matchExistQuery = mysql_query("SELECT * FROM user_matchings WHERE match_id = ".$matchID) or die(mysql_error());
					if(mysql_num_rows($matchExistQuery) == 0){
						addUserRatingToHistory($userID, $matchID, $matchData["rating"], 0);
					}
				}
			} else {
				mysql_query("UPDATE users
							 SET is_spammer = 0, time_tracking_ctr = ".$_SESSION['user_data']["time_tracking"]."
							 WHERE user_id = ".$userID);
				foreach($_SESSION['user_data']["user_matchings"] as $matchID=>$matchData){
					$matchExistQuery = mysql_query("SELECT * FROM user_matchings WHERE match_id = ".$matchID) or die(mysql_error());
					if(mysql_num_rows($matchExistQuery) == 0){
						addUserRatingToHistory($userID, $matchID, $matchData["rating"], $matchData["skip"]);
					}
				}
			}
			increaseCouponMeter($userID, $_SESSION['user_data']['coupon_meter']);
	/* 		$couponMeterQuery = mysql_query("SELECT coupon_meter FROM users WHERE user_id = ".$userID);
			$couponMeterRow = mysql_fetch_array($couponMeterQuery);
			$newCouponMeter = $couponMeterRow["coupon_meter"] + $userData['coupon_meter'];
			mysql_query("UPDATE users
						 SET coupon_meter = ".$newCouponMeter."
						 WHERE user_id = ".$userID) or die(mysql_error()); */
			unset($_SESSION['user_data']);
		}
	}
	
	function getUserNextMatchQuestion($userId) {
		$itemsQuery = mysql_query("SELECT matches.* FROM item_matchings matches INNER JOIN items it1, items it2 WHERE matches.match_type = 1 AND it1.item_id = matches.top_item_id AND it2.item_id = matches.bottom_item_id AND it1.designer_id != ".$userId." AND it2.designer_id != ".$userId." ORDER BY match_count");
		if($userId == NULL) {
			if(!isset($_SESSION["user_data"]["user_matchings"])){
				while($row = mysql_fetch_array($itemsQuery)) {
					return $row["match_id"];
				}
			} else {
				while($row = mysql_fetch_array($itemsQuery)) {
					//if(!array_key_exists($row["match_id"], $_SESSION["user_data"]["user_matchings"])){
						return $row["match_id"]; //TODO uncomment if
				//	}
				}
			}
		} else {
			while($row = mysql_fetch_array($itemsQuery)) {
				$userMatchesQuery = mysql_query("SELECT * FROM user_matchings WHERE match_id = ".$row["match_id"]);
				$userAnswered = mysql_num_rows($userMatchesQuery);
				if ($userAnswered == 0) {
					return $row["match_id"];
				}
			}
		}
		return -1;
	}
?>