<?php
include("header.php");
$gender = $_GET["gender"];
$limit=4;
$queryTop = mysql_query('SELECT * FROM items WHERE gender="'.strtoupper($gender).'" AND type="TOP" LIMIT '.$limit);
$queryBottom = mysql_query('SELECT * FROM items WHERE gender="'.strtoupper($gender).'" AND type="BOTTOM" LIMIT '.$limit);

function showSlider($query,$id)
{
	echo '<div id="slider'.$id.'_container" style="position: relative; top: 0px; left: 0px; width: 330px; height: 500px;">';
	echo 	'<div u="slides" style="cursor: move; position: absolute; overflow: hidden; left: 0px; top: 0px; width: 330px; height: 500px;">';
	
		while($row = mysql_fetch_array($query))
		{
			$picture = $row['picture'];
			$price = $row['price'];
			$itemId= $row['item_id'];
			echo '<div><a href="show_item.php?itemId='.$itemId.'"><img u="image" src="images/items/'.$picture.'"/></a>';
			echo '<div u="caption" t="MCLIP|B" t2="MCLIP|B" style="position: absolute; top: 450px; left: 0px;
	            width: 330px; height: 150px;">
	            <div style="position: absolute; top: 0px; left: 0px; width: 330px; height: 50px;
	                background-color: Black; opacity: 0.5; filter: alpha(opacity=50);">
	            </div>
	            <div style="position: absolute; top: 0px; left: 0px; width: 330px; height: 50px;
	                color: White; font-size: 16px; font-weight: bold; line-height: 50px; text-align: center;"><div>
	                Price: $'.$price.' </div>
	            </div>
	        </div></div>';
		}
		
    echo 	'</div>';
    echo '<span u="arrowleft" class="jssora01l" style="top: 220px; left: 8px;"></span>';
    echo '<span u="arrowright" class="jssora01r" style="top: 220px; right: 8px;"></span>';    
	echo '</div>';	
}
?>
	<script src="js/libraries/jssor.slider.mini.js"></script>
	<script src="js/site_scripts/shop_entrance.js?3"></script>
    <div class="container">
		<div class="row">
			<div class="col-md-6" align="center">
								<h3>Browse Shirts</h3>
								<?php showSlider($queryTop,"top");?> <br/>
								 <a href='shop.php?gender=<?php echo $gender;?>&type=top'><button type="button" class="btn btn-lg btn-primary">Show More</button></a>
			</div>
			<div class="col-md-6" align="center">
								<h3>Browse <?php if (strtoupper($gender)=="MALE"){ ?> Pants <?php } else { ?> Pants and Skirts <?php } ?></h3>
								<?php showSlider($queryBottom,"bottom");?> <br/> 
								<a href='shop.php?gender=<?php echo $gender;?>&type=bottom'><button type="button" class="btn btn-lg btn-primary">Show More</button></a>
			</div>
    	</div>
	</div>

  </body>
</html>