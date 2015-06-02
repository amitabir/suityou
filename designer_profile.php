<?php
	include("config.php");
	
	$userId = $_SESSION['user_id'];
	$designerId = $_GET['designerId'];
	
	$designer = User::getUserfromDBbyID($designerId);
	
	if (!$designer->is_designer) {
		echo "This user is not a designer!";
	} else {
		$designerPic=$designer->avatar;
		$designerName=$designer-> first_name;
		$designerLastName=$designer->last_name;
		$designerDesc=$designer->description;
		$website=$designer->website_link;
		echo " <img width='170' src=images/users/$designerPic />";
		echo "<br/> $designerName $designerLastName";	
		echo "<br/> $designerDesc";
		echo "<br/> <a href='$website'> Designer Website </a> </td>";
		
	?>
			
			
					<table border="1px">
				<tr>
					<td>Name</td>
					<td>Price</td>
					<td>Description</td>
					<td>Image</td>
					<td>Add To Cart</td>
					
				</tr>
<?php
			   	$query = mysql_query('SELECT * FROM items WHERE designer_id= "'.$designerId.'"');
				echo mysql_error();
			   	while($row = mysql_fetch_array($query)) {
					$itemId = $row['item_id'];
			   		$name = $row['name'];
			   		$description = $row['description'];
					$picture = $row['picture'];
					$price = $row['price'];
					echo "<tr>";
			   		echo "<td> $name </td> <td> $price $ </td> <td> $description </td> <td> <img width='170' src=images/items/$picture /> </td> <td> <a href='show_item.php?itemId=$itemId'> Buy Now </a> </td>";
					echo "</tr>";
			   	}
			   ?>
			</table>
?>
	
<?php
	}
?>