<?php
include("header.php");
$gender = $_GET["gender"];
$limit=4;
$queryTop = mysql_query('SELECT * FROM items WHERE gender="'.strtoupper($gender).'" AND type="TOP" LIMIT '.$limit);
$queryBottom = mysql_query('SELECT * FROM items WHERE gender="'.strtoupper($gender).'" AND type="BOTTOM" LIMIT '.$limit);
function showTable($query){
	echo '<table border="1px">';

	$i=0;
			 	while($row = mysql_fetch_array($query)) {
					$picture = $row['picture'];
					$price = $row['price'];
					$itemId= $row['item_id'];
					if ($i % 2 == 0){
						echo "<tr>";
					}
					echo "<td> <img width='170' src=images/items/$picture /> <br/> $price <br/> <a href='show_item.php?itemId=$itemId'> Buy Now </a> </td>";
					if ($i % 2 == 1){
			   			echo "</tr>";
					}
					$i++;
			   	}
		echo '</table>';
}
?>
    <div id="content_header"></div>
    <div id="site_content">
        <div id="content">
            <div id="content-part">
                <h2>Welcome to SuitYou!</h2>
            </div>
			<table border="1px">
			<tr><td>Shirts</td><td><?php if (strtoupper($gender)=="MALE"){?> Pants<?php } else {?> Pants and Skirts<?php }?></td></tr>			
			<tr>
			<td><?php showTable($queryTop);?></td>
			<td><?php showTable($queryBottom);?></td>		

			</tr>
			<tr><td><a href='shop.php?gender=<?php echo $gender;?>&type=top'> show more </a></td><td><a href='shop.php?gender=<?php echo $gender;?>&type=bottom'> show more </a></td></tr>
			</table>
			
			
        </div>
    </div>

</div>

  </body>
</html>