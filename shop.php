<?php
include("header.php");
$gender = $_GET["gender"];
$type = $_GET["type"];
?>
    <div id="content_header"></div>
    <div id="site_content">
        <div id="content">
            <div id="content-part">
                <h2>Welcome to SuitYou!</h2>
            </div>
			
			<table border="1px">
				<tr>
					<td>Name</td>
					<td>Price</td>
					<td>Description</td>
					<td>Image</td>
					<td>Add To Cart</td>
					
				</tr>
<?php
			   	$query = mysql_query('SELECT * FROM items WHERE gender = "'.$gender.'" AND type = "' .$type. '"');
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
			
			
        </div>
    </div>

</div>

  </body>
</html>