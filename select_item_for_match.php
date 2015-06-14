<?php
include ("config.php");
$gender = $_GET["gender"];
$type = $_GET["type"];
$query = mysql_query('SELECT * FROM items WHERE gender = "'.$gender.'" AND type = "' .$type. '"');
?>	
<script>
$('#gender').on('change', function() {
  	loadItems($(this).val(), "<?php echo $type; ?>");
});
</script>

<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
		<select id="gender"> 
			<option value="male" <?php if ($gender == "male") echo "selected"; ?> >Men</option>
			<option value="female" <?php if ($gender == "female") echo "selected"; ?>>Women</option>
		</select>
	</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
	<table class="table" border="1px">
		<thead>
			<td>Name</td>
			<td>Price</td>
			<td>Description</td>
			<td>Image</td>
			<td>Add To Cart</td>

		</thead>
		<tbody>
	<?php
	   	while($row = mysql_fetch_array($query)) {
			$itemId = $row['item_id'];
	   		$name = $row['name'];
	   		$description = $row['description'];
			$picture = $row['picture'];
			$price = $row['price'];
			echo "<tr>";
	   		echo "<td> $name </td> <td> $price $ </td> <td> $description </td> <td> <img width='170' src=images/items/$picture /> </td> <td> <button id='select_$itemId' data-dismiss='modal'> Select </button> </td>";
			?>
			<script>
			$( "#select_<?php echo $itemId; ?>" ).button().on("click", function(event) {
				<?php if ($type == 'top') { ?>
					$('#top_item_id').val(<?php echo $itemId; ?>)
				<?php } else { ?>
					$('#bottom_item_id').val(<?php echo $itemId; ?>)
				<?php } ?>
			    }); 
			</script>
		<?php
			echo "</tr>";
	   	}
	   ?>
	</tbody>
	</table>
</div>
</div>
</div>