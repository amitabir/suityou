<?php
include("config.php");

$designerId = $_SESSION["user_id"];

if(isset($_POST["page"])){
	$page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
	if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
}else{
	$page_number = 1; //if there's no page number, set it to 1
}

$item_per_page = $_POST["itemsPerPage"];

//get starting position to fetch the records
$page_position = (($page_number-1) * $item_per_page);

//SQL query that will fetch group of records depending on starting position and item per page. See SQL LIMIT clause
$matchesQuery = mysql_query('SELECT matches.*, it1.picture as top_item_picture, it2.picture as bottom_item_picture FROM item_matchings matches INNER JOIN items it1, items it2 WHERE match_type = 1 AND matches.top_item_id = it1.item_id AND matches.bottom_item_id = it2.item_id LIMIT '.$page_position.', '.$item_per_page);
?>

<div class="container">

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header" align="center">
				Manage Matches
			</h1>
		</div>
	</div>			
	
	<div class="row" align="right">
		<a href='add_match.php'> <button class="btn btn-primary">Add New Match</button> </a>
	</div>
	
	<div class="row">
		<table class="table">
			<thead>
				<th class="col-md-2">Top Item</th>
				<th class="col-md-2">Bottom Item</th>
				<th class="col-md-2">Match Information</th>
				<th class="col-md-4">Model</th>
				<th class="col-md-2">Action</th>
			</thead>
			<tbody>
<?php
		while($matchRow = mysql_fetch_array($matchesQuery)) {
			$matchId = $matchRow['match_id'];
			$topItemId = $matchRow['top_item_id'];
			$topItemPicture = $matchRow['top_item_picture'];
			$bottomItemId = $matchRow['bottom_item_id'];
			$bottomItemPicture = $matchRow['bottom_item_picture'];
			$matchCount = $matchRow['match_count'];
			$matchPercent = $matchRow['match_percent'];
			$matchIgnoreCount = $matchRow['ignored_match_count'];
			$matchIgnorePercent = $matchRow['ignored_match_percent'];
			$modelPicture = $matchRow['model_picture'];
 ?>
				<tr>
					<td>
						<a href="show_item.php?itemId=<?php echo $topItemId; ?>" class="thumbnail">
						    <img src="images/items/<?php echo $topItemPicture; ?>" alt="" style="width:150px;height:150px">
						</a>
					</td>
					<td>
						<a href="show_item.php?itemId=<?php echo $bottomItemId; ?>" class="thumbnail">
						    <img src="images/items/<?php echo $bottomItemPicture; ?>" alt="" style="width:150px;height:150px">
						</a>
					</td>
					<td>
						<p><strong><?php echo round($matchPercent,2); ?>% Match</strong></p>
						<p>Number Of Ratings: <?php echo $matchCount; ?></p>
						<p>Ignores Match: <?php echo round($matchIgnorePercent,2); ?>%</p>
						<p>Ignored Ratings: <?php echo $matchIgnoreCount; ?></p>
					</td>
					<td>
						 <img src="images/models/<?php echo $modelPicture; ?>" alt="" style="width:300px;height:300px">
					</td>
					<td>
						<p><a href='add_match?matchId=<?php echo $matchId; ?>'> <button class="btn btn-primary">Update Match</button> </a></p>
						<p><a href='manage_match_logic?action=remove&matchId=<?php echo $matchId; ?>'><button class="btn btn-primary"> Remove Match</button> </a></p>
					</td>
<?php 	}
?>
		</tbody>
		</table>
	</div>
</div>