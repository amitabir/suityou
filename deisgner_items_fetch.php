<?php
include("config.php");

$designerId = $_GET["designerId"];

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
$itemsQuery = mysql_query('SELECT * FROM items WHERE designer_id = '.$designerId.' LIMIT '.$page_position.', '.$item_per_page);
?>
	
		<table class="table">
			<tbody>
<?php
		while($row = mysql_fetch_array($itemsQuery)) {
			$itemId = $row['item_id'];
			$name = $row['name'];
			$description = $row['description'];
			$picture = $row['picture'];
			$price = $row['price'];
 ?>
				<tr>
					<td>
					<div class="img-container-designer">
						<a href="show_item.php?itemId=<?php echo $itemId; ?>" class="thumbnail">
						    <img class="img-responsive" src="images/items/<?php echo $picture; ?>" alt="" >
						</a>
					</div>
					</td>


					<td>
						<p><strong><?php echo $name; ?></strong></p>
						<p><?php echo $description; ?></p>
						<p>Price: $<?php echo $price; ?></p>
					</td>
<?php 	}
?>
		</tbody>
	</table>
