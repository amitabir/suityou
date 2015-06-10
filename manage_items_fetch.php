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
$itemsQuery = mysql_query('SELECT * FROM items WHERE designer_id = '.$designerId.' LIMIT '.$page_position.', '.$item_per_page);
?>

<div class="container">

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header" align="center">
				Manage Items
			</h1>
		</div>
	</div>			
	
	<div class="row" align="right">
		<a href='add_item.php'> <button class="btn btn-primary">Add New Item</button> </a>
	</div>
	
	<div class="row">
		<table class="table">
			<thead>
				<th class="col-md-3">Item Image</th>
				<th class="col-md-5">Item Description</th>
				<th class="col-md-4">Actions</th>
			</thead>
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
						<a href="show_item.php?itemId=<?php echo $itemId; ?>" class="thumbnail">
						    <img src="images/items/<?php echo $picture; ?>" alt="" style="width:200px;height:200px">
						</a>
					</td>
					<td>
						<p><strong><?php echo $name; ?></strong></p>
						<p><?php echo $description; ?></p>
						<p>Price: $<?php echo $price; ?></p>
					</td>
					<td>
						<p><a href='add_item.php?itemId=<?php echo $itemId;?>'> <button class="btn btn-primary">Update Item</button> </a></p>
						<p><a href='manage_item_logic.php?action=remove&itemId=<?php echo $itemId;?>'><button class="btn btn-primary"> Remove Item</button> </a></p>
					</td>
<?php 	}
?>
		</tbody>
		</table>
	</div>
</div>