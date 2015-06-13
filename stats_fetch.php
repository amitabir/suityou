<?php
include("config.php");

if(isset($_POST["page"])){
	$page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
	if(!is_numeric($page_number)){die('Invalid page number!');} //in case of invalid page number
}else{
	$page_number = 1; //if there's no page number, set it to 1
}


//get starting position to fetch the records


$queryStart = "SELECT att1.name, att2.name, AVG(user_matchings.rating), 
		STDDEV(user_matchings.rating), COUNT(user_matchings.rating) FROM user_matchings INNER JOIN users, item_matchings, items it1, items it2, 
		item_attributes itatt1, item_attributes itatt2, attributes att1, attributes att2 WHERE user_matchings.rating 
		is not NULL AND users.user_id = user_matchings.user_id AND users.is_spammer = 0 AND user_matchings.match_id = item_matchings.match_id AND
		item_matchings.top_item_id = it1.item_id AND item_matchings.bottom_item_id = it2.item_id AND itatt1.item_id = it1.item_id AND
		itatt2.item_id = it2.item_id AND att1.attribute_id = itatt1.attribute_id AND att2.attribute_id = itatt2.attribute_id AND
		att1.category_id = att2.category_id";

$queryEnd = " GROUP BY att1.attribute_id, att2.attribute_id";

if(isset($_GET["categoryID"]) and !empty($_GET["categoryID"])){
	$categoryID = $_GET["categoryID"];
	$query = $queryStart." AND att1.category_id = ".$categoryID;
	if(isset($_GET["att1ID"]) and !empty($_GET["att1ID"])){
		$attribute1ID = $_GET["att1ID"];
		$query = $query." AND att1.attribute_id = ". $attribute1ID;
	}
	if (isset($_GET["att2ID"]) and !empty($_GET["att2ID"])){
		$attribute2ID = $_GET["att2ID"];
		$query = $query." AND att2.attribute_id = " .$attribute2ID;
	}
	$query = $query.$queryEnd;
} else {
	$categoryID = 1;
	$query = $queryStart." AND att1.category_id = ".$categoryID;
	$query = $queryStart.$queryEnd;
}

//SQL query that will fetch group of records depending on starting position and item per page. See SQL LIMIT clause
$attQuery = mysql_query($query) or die(mysql_error());

?>

<script>

$('#category').on('change', function() {
  	loadCatTable('<?php echo $page_number; ?>',$(this).val(), "<?php if (isset($attribute1ID)){ echo $attribute1ID; }?>", "<?php  if (isset($attribute2ID)){echo $attribute2ID;} ?>");
});

$('#att1').on('change', function() {
  	loadCatTable('<?php echo $page_number; ?>', "<?php if (isset($categoryID)){ echo $categoryID; }?>",$(this).val(), "<?php  if (isset($attribute2ID)){echo $attribute2ID;} ?>");
});

$('#att2').on('change', function() {
  	loadCatTable('<?php echo $page_number; ?>', "<?php if (isset($categoryID)){ echo $categoryID; }?>","<?php  if (isset($attribute1ID)){echo $attribute1ID;} ?>",$(this).val() );
});

</script>

<div class="row">
				<div class="col-md-4" align="center">
					Category:
					<select id="category">
					<option></option>
					<?php
					 $catQuery = mysql_query("SELECT category_id, name FROM categories");
					while($row = mysql_fetch_array($catQuery)){
						$cat=$row['name'];
						echo '<option ';
						if(isset($_GET['categoryID'])){
							if($row['category_id'] == $_GET['categoryID']){
								echo ' selected ';
							}
						}
						echo 'value=' .$row['category_id']. '>' .$cat.'</option>';
						
					}
					?>
					</select>
				</div>
				<div class="col-md-4" align="center">
					First Attribute:
					<select id = "att1">
					<option></option>
					<?php
					$att1Query = mysql_query("SELECT attribute_id, name FROM attributes WHERE category_id = ".$categoryID);
					while($row = mysql_fetch_array($att1Query)){
						$att1=$row['name'];
						$attribute1ID = $row['attribute_id'];
						echo '<option ';
						if(isset($_GET['att1ID'])){
							if($attribute1ID == $_GET['att1ID']){
								echo ' selected ';
							}
						}
						echo 'value=' .$row['attribute_id']. '>' .$att1.'</option>';
					}
				?>
					</select>

					
	
				</div>
				<div class="col-md-4" align="center">
					Second Atrribute:
					<select id = "att2">
					<option></option>
					<?php
					
					$att2Query = mysql_query("SELECT attribute_id, name FROM attributes WHERE category_id = ".$categoryID);
					while($row = mysql_fetch_array($att2Query)){
						$att2=$row['name'];
						$attribute2ID = $row['attribute_id'];
						echo '<option ';
						if(isset($_GET['att2ID'])){
							if($attribute2ID == $_GET['att2ID']){
								echo ' selected ';
							}
						}
						echo 'value=' .$row['attribute_id']. '>' .$att2.'</option>';
						
					}
				?>
					</select>
				</div>
		</div>

	
<?php
		while($row = mysql_fetch_array($attQuery)) {
			$att1Name = $row[0];
			$att2Name = $row[1];
			$avg = $row[2];
			$stDev = $row[3];
 ?>
 
			<div class="row">
				<div class="col-md-3">
					<?php echo $att1Name ?>
				</div>
				<div class="col-md-3">
					<?php echo $att2Name ?>
				</div>
				<div class="col-md-3">
				<div id="jRate"></div>
				<div id="gauge" style="width: 100px; height:80px;"></div>
					<script>
					var g = new JustGage({
					  id: "gauge",
					  value: <?php echo round($avg,2) ?>,
					  min: 0,
					  max: 10,
					  title: "Average"
					});
					</script>
				</div>
				<div class="col-md-3">
					<?php echo round($stDev,2) ?>
				</div>

			</div>
	<?php	} ?>


	<div class="row text-center">
        <div class="col-lg-12">
<?php 
			//echo '<div align="center">';
			/* We call the pagination function here to generate Pagination link for us. 
			As you can see I have passed several parameters to the function. */
			//echo paginate_function($item_per_page, $page_number, $get_total_rows[0], $total_pages);
			//echo '</div>';
?>
		</div>
	</div>
</div>