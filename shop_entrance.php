<?php
include("header.php");
$gender = $_GET["gender"];
$limit=4;
$queryTop = mysql_query('SELECT * FROM items WHERE gender="'.strtoupper($gender).'" AND type="TOP" LIMIT '.$limit);
$queryBottom = mysql_query('SELECT * FROM items WHERE gender="'.strtoupper($gender).'" AND type="BOTTOM" LIMIT '.$limit);

function showSlider($query,$id)
{
	echo '<div id="slider'.$id.'_container" style="position: relative; top: 0px; left: 0px; width: 300px; height: 300px;">';
	echo 	'<div u="slides" style="cursor: move; position: absolute; overflow: hidden; left: 0px; top: 0px; width: 300px; height: 300px;">';
	
		while($row = mysql_fetch_array($query))
		{
			$picture = $row['picture'];
			$price = $row['price'];
			$itemId= $row['item_id'];
			echo '<div><a href="show_item.php?itemId='.$itemId.'"><img u="image" src="images/items/'.$picture.'"/></a>';
			echo '<div u="caption" t="MCLIP|B" t2="NO" style="position: absolute; top: 250px; left: 0px;
	            width: 600px; height: 50px;">
	            <div style="position: absolute; top: 0px; left: 0px; width: 300px; height: 50px;
	                background-color: Black; opacity: 0.5; filter: alpha(opacity=50);">
	            </div>
	            <div style="position: absolute; top: 0px; left: 0px; width: 300px; height: 50px;
	                color: White; font-size: 16px; font-weight: bold; line-height: 50px; text-align: center;"><div>
	                Price: $'.$price.' </div>
	            </div>
	        </div></div>';
		}
		
    echo 	'</div>';
    echo '<span u="arrowleft" class="jssora01l" style="top: 123px; left: 8px;"></span>';
    echo '<span u="arrowright" class="jssora01r" style="top: 123px; right: 8px;"></span>';    
	echo '</div>';	
}
?>
	<script src="jssor.slider.mini.js"></script>
	<script src="shop_entrance.js?3"></script>
    <div id="content_header"></div>
    <div id="site_content">
        <div id="content">
            <div>
				<table>
					<tbody>
						<tr>
							<td>
								<h3>Browse Shirts</h3>
								<?php showSlider($queryTop,"top");?> 
								<a href='shop.php?gender=<?php echo $gender;?>&type=top'> Show More </a>
							</td>
							<td>
								<h3>Browse <?php if (strtoupper($gender)=="MALE"){ ?> Pants <?php } else { ?> Pants and Skirts <?php } ?></h3>
								<?php showSlider($queryBottom,"bottom");?>
								<a href='shop.php?gender=<?php echo $gender;?>&type=bottom'> Show More </a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
        </div>
    </div>

</div>

  </body>
</html>