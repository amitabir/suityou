<?php
include("header.php");
include("Item.php");

$itemForUpdate = NULL;
if(!empty($_GET["itemId"])) {
	$itemForUpdate = Item::getItemById($_GET["itemId"]);
}
?>
<script>
	function checkNew(category_id, val) {
		if (val == "new") {
			document.getElementById("new_input_"+category_id).style.display = 'block';
		} else {
			document.getElementById("new_input_"+category_id).style.display = 'none';
		}
	}
	
	function addRow(tableID) {
		var table = document.getElementById(tableID);
		var rowCount = table.rows.length;
		var row = table.insertRow(rowCount);
		var colCount = table.rows[0].cells.length;
		for(var i=0; i<colCount; i++) {
			var newcell = row.insertCell(i);
			newcell.innerHTML = table.rows[0].cells[i].innerHTML;
			newcell.childNodes[1].value = "";
		}
	}

	function deleteRow(tableID) {
		var table = document.getElementById(tableID);
		var rowCount = table.rows.length;
		for(var i=0; i<rowCount; i++) {
			var row = table.rows[i];
			var chkbox = row.cells[0].childNodes[0];
			if(null != chkbox && true == chkbox.checked) {
				if(rowCount <= 1) {         // limit the user from removing all the fields
					alert("Must have at least one size available in stock.");
					break;	
				}
				table.deleteRow(i);
				rowCount--;
				i--;
			}
		}
	}
</script>

    <div id="content_header"></div>
    <div id="site_content">
        <div id="content">
			<div class="add_item_form">
				<?php if ($itemForUpdate != NULL) { ?>
	            	<form action="add_item_logic.php?action=update&itemId=<?php echo $itemForUpdate->itemId;?>" method="post" enctype="multipart/form-data"/>
						Update Item:<br />
				<?php } else { ?>
					<form action="add_item_logic.php?action=add" method="post" enctype="multipart/form-data"/>
						Add New Item:<br />
				<?php } ?>
			        <div class="center">
			        	<label for="name">Name</label><input type="text" name="name" value="<?php echo $itemForUpdate->name; ?>"/><br />
			            <label for="gender">Item Gender:</label>
  						  		<input type="radio" name="gender" value="MALE" <?php if ($itemForUpdate->gender == 'MALE') echo "checked"; ?>>Male</option>
  						  		<input type="radio" name="gender" value="FEMALE" <?php if ($itemForUpdate->gender == 'FEMALE') echo "checked"; ?>>Female</option>
							<br/>
			            <label for="type">Item Type:</label>
				  		<input type="radio" name="type" value="TOP" <?php if ($itemForUpdate->type == 'TOP') echo "checked"; ?>>Top</option>
				  		<input type="radio" name="type" value="BOTTOM" <?php if ($itemForUpdate->type == 'BOTTOM') echo "checked"; ?>>Bottom</option>
							<br/>
			            <label for="description">Description:<br/></label><textarea name="description"/><?php echo $itemForUpdate->description; ?></textarea><br />        
			            <label for="price">Item Price:</label><input type="text" name="price" value="<?php echo $itemForUpdate->price; ?>"/><br />
						<?php if ($itemForUpdate != NULL) { ?>
						 
						<img src="images/items/<?php echo $itemForUpdate->picture; ?>" /><br/>
						
						<?php }?>
						
						<label for="image"><?php if ($itemForUpdate != NULL) echo "Change Item Image: "; else echo "Upload Item Image: "; ?></label><input type="file" name="imageToUpload" id="imageToUpload"><br />
						<br/>
						<label for="Categories">Categories:</label>
						<table border="1px">
							<tr><td>Category</td><td>Attribute</td></tr>
							<?php
								$categoriesQuery = mysql_query("SELECT * FROM categories");
								while($catRow = mysql_fetch_array($categoriesQuery)) {
									echo "<tr>";
									echo "<td>".$catRow['name']."</td>";
									echo "<td>";
									echo "<select name='cat_".$catRow['category_id']."' onChange='checkNew(".$catRow['category_id'].",this.value);'>";
										$attributesQuery = mysql_query("SELECT * FROM attributes WHERE category_id = ".$catRow['category_id']);
										
										// For updating item, get the attributes and mark as selected.
										if ($itemForUpdate != NULL) {
											$catArray = $itemForUpdate->getItemAttributes();
										}
										
										// Add an option for each attribue
										while($attRow = mysql_fetch_array($attributesQuery)) {
											echo "<option value='".$attRow['attribute_id']."' ";
											// Mark as selected for updating item
											if ($itemForUpdate != NULL and array_key_exists($catRow['category_id'], $catArray)) {
												if ($catArray[$catRow['category_id']]['att_id'] == $attRow['attribute_id']) {
													echo "selected";
												}
											}
											echo ">".$attRow['name']."</option>";
										}
										echo "<option value='new'>Other...</option>";
									echo "</select><div id='new_input_".$catRow['category_id']."' style='display:none'><input type='text' name=new_att_for_".$catRow['category_id']." placeHolder='Type new attribute...'/></div>";
									echo "</td>";
									echo "</tr>";
								}
							?>
						</table>
						<br/>
			            
						<label for="stock">Item Stock:</label>
						<p> 
						  <input type="button" value="Add Size" onClick="addRow('stockTable');" /> 
						  <input type="button" value="Remove Size" onClick="deleteRow('stockTable');" /> 
						  (All acions apply only to entries with check marked check boxes only.)
						</p>
						<table id="stockTable" class="form" border="1">
						 <tbody>
						<?php
							if ($itemForUpdate != NULL) {
								$stockArray = $itemForUpdate->getItemStock();
								foreach ($stockArray as $stockId=>$stockInfo) { ?>
							  <tr>
								<p>
								<td><input type="checkbox" name="chk[]" checked="checked"/><input type="hidden" name="stockIds[]" value="<?php echo $stockId; ?>"/></td>
								<td><label for="size">Size</label><input type="text" name="size[]" value="<?php echo $stockInfo['size']; ?>"/></td>
								<td><label for="quantity">Quantity</label><input type="text" class="small"  name="quantity[]" value="<?php echo $stockInfo['quantity']; ?>"/></td>
								</p>
							  </tr>
						<?php
								}
							} else {
						?>
						  <tr>
							<p>
							<td><input type="checkbox" name="chk[]" checked="checked"/><input type="hidden" name="stockIds[]"/></td>
							<td><label for="size">Size</label><input type="text" name="size[]"/></td>
							<td><label for="quantity">Quantity</label><input type="text" class="small"  name="quantity[]"/></td>
							</p>
						  </tr>
						<?php
							}	
						?>
						 </tbody>
						</table>
						<?php if ($itemForUpdate != NULL) { ?>
			            	<input type="submit" value="Update Item" name="submit"/>
						<?php } else { ?>
							<input type="submit" value="Add Item" name="submit"/>
						<?php } ?>
					</div>
			    </form>
			</div>			
        </div>
    </div>

</div>

  </body>
</html>