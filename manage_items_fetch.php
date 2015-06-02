<?php
include("config.php");
include("pagination.php");
$designerId = $_SESSION["user_id"];

if(isset($_POST["page"])){
	$page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
	if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
}else{
	$page_number = 1; //if there's no page number, set it to 1
}

$item_per_page = 4;
$countQuery = mysql_query('SELECT count(*) FROM items WHERE designer_id = '.$designerId);
$countRow = mysql_fetch_array($countQuery);
	
//break records into pages
$total_pages = ceil($countRow[0]/$item_per_page);

//get starting position to fetch the records
$page_position = (($page_number-1) * $item_per_page);

//SQL query that will fetch group of records depending on starting position and item per page. See SQL LIMIT clause
$itemsQuery = mysql_query('SELECT * FROM items WHERE designer_id = '.$designerId.' LIMIT '.$page_position.', '.$item_per_page);

?>
			<table border="1px">
				<tr>
					<td>Name</td>
					<td>Price</td>
					<td>Description</td>
					<td>Image</td>
					<td>Action</td>
				</tr>
<?php
			   	while($row = mysql_fetch_array($itemsQuery)) {
					$itemId = $row['item_id'];
			   		$name = $row['name'];
			   		$description = $row['description'];
					$picture = $row['picture'];
					$price = $row['price'];
					echo "<tr>";
			   		echo "<td> $name </td> <td> $price $ </td> <td> $description </td> <td> <img width='170' src=images/items/$picture /> </td> <td> <a href='add_item.php?itemId=$itemId'> Update Item </a> <br/> <a href='manage_item_logic.php?action=remove&itemId=$itemId'> Remove Item </a> </td>";
					echo "</tr>";
			   	}
			   ?>
			</table>
			<?php 
			echo '<div align="center">';
			/* We call the pagination function here to generate Pagination link for us. 
			As you can see I have passed several parameters to the function. */
			echo paginate_function($item_per_page, $page_number, $get_total_rows[0], $total_pages);
			echo '</div>';
			?>