<?php
include("header.php");
$designerId = $_SESSION["user_id"];
$itemsQuery = mysql_query('SELECT * FROM items WHERE designer_id = '.$designerId);
?>
    <div id="content_header"></div>
    <div id="site_content">
        <div id="content">
            <div id="content-part">
                <h2>Welcome to SuitYou!</h2>
            </div>
			<a href='add_item.php'> Add New Item </a>
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
			   		echo "<td> $name </td> <td> $price $ </td> <td> $description </td> <td> <img width='170' src=images/items/$picture /> </td> <td> <a href='add_item.php?itemId=$itemId'> Update Item </a> <br/> <a href='add_item_logic.php?action=remove&itemId=$itemId'> Remove Item </a> </td>";
					echo "</tr>";
			   	}
			   ?>
			</table>
			
			
        </div>
    </div>

</div>

  </body>
</html>