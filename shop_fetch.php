<?php
include("config.php");

$gender = $_GET["gender"];
$type = $_GET["type"];

function getHeader($gender, $type) {
	$header = "";
	if ($gender == "male") {
		$header .= "<small>MEN'S</small><br/>";
		if ($type == "top") {
			$header .=  "Shirts";
		} else {
			$header .=  "Pants";
		}
	} else {
		$header .= "<small>WOMEN'S</small><br/>";
		if ($type == "top") {
			$header .=  "Shirts";
		} else {
			$header .=  "Pants And Skirts";
		}
	}
	return $header;
}

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
$itemsQuery = mysql_query('SELECT * FROM items WHERE gender = "'.$gender.'" AND type = "' .$type. '" LIMIT '.$page_position.', '.$item_per_page);
?>

<div class="container">

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header" align="center">
				<?php echo getHeader($gender, $type); ?>
			</h1>
		</div>
	</div>			

<?php
		$itemsPerRow = 3;
		$i = 0;
		while($row = mysql_fetch_array($itemsQuery)) {
			$itemId = $row['item_id'];
			$name = $row['name'];
			$description = $row['description'];
			$picture = $row['picture'];
			$price = $row['price'];
			
			if ($i % $itemsPerRow == 0) { ?>
				<div class="row">
<?php		} ?>
					<div class="col-md-4">
						<a href="show_item.php?itemId=<?php echo $itemId; ?>" class="thumbnail">
						    <img src="images/items/<?php echo $picture; ?>" alt="" style="width:200px;height:200px">
						    <p align="center"> <?php echo $name; ?></p>
							<p align="center"> $<?php echo $price; ?></p>
						</a>
					</div>
<?php 		if ($i % $itemsPerRow == $itemsPerRow - 1) { ?>
				</div>
<?php 		}
			$i++;
		}
		// Add last row close if number of items doesn't fit exactly.
		if ($i % $itemsPerRow != 0) { ?>
			</div>
<?php 	}
?>

</div>