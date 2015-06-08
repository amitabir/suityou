<?php
include("header.php");
include("item.php");

if(isset($_SESSION['item_update_message']) and isset($_SESSION['item_update_success'])) {
	$message = $_SESSION['item_update_message'];
	if ($_SESSION['item_update_success']) {
		$class='"alert alert-success alert-dismissible"';
	} else {
		$class='"alert alert-danger alert-dismissible"';
	}
	if(!empty($message)) {
		echo '<div class='.$class.' role="alert">';
		echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		echo $message;
		echo '</div>';
		unset($_SESSION['item_update_message']);
	}
	unset($_SESSION['item_update_success']);
}

$itemForUpdate = NULL;
if(!empty($_GET["itemId"])) {
	$itemForUpdate = Item::getItemById($_GET["itemId"]);
}
?>
<script type="text/javascript" src="add_item_validate.js?12"></script>
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
		var colCount = table.rows[1].cells.length;
		for(var i=0; i<colCount; i++) {
			var newcell = row.insertCell(i);
			newcell.innerHTML = table.rows[1].cells[i].innerHTML;
			newcell.childNodes[0].value = "";
		}
	}

	function deleteRow(tableID) {
		var table = document.getElementById(tableID);
		var rowCount = table.rows.length;
		for(var i=0; i<rowCount; i++) {
			var row = table.rows[i];
			var chkbox = row.cells[0].childNodes[0];
			if(null != chkbox && true == chkbox.checked) {
				if(rowCount <= 2) {         // limit the user from removing all the fields
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

<div class="container">
		<h3 class="page-header">Item Description</h3>
	
				<?php if ($itemForUpdate != NULL) { ?>
	            	<form id="add_item_form" class="form-horizontal" action="manage_item_logic.php?action=update&itemId=<?php echo $itemForUpdate->itemId;?>" method="post" enctype="multipart/form-data" role="form"/>
				<?php } else { ?>
					<form id="add_item_form" class="form-horizontal" action="manage_item_logic.php?action=add" method="post" enctype="multipart/form-data" role="form"/>
				<?php } ?>

		                <div class="form-group">
		                    <label class="control-label" for="name">Name</label>
		                    <input class="form-control" type="text" name="name" id="name" value="<?php echo $itemForUpdate->name; ?>" />
		                </div>
		                <div class="form-group">
		                    <label class="control-label" for="name">Item Gender</label>
		                    <select class="form-control" name="gender">
								<option></option>
		                        <option <?php if ($itemForUpdate->gender == 'FEMALE') echo "selected"; ?> value="FEMALE">FEMALE</option>
		                        <option <?php if ($itemForUpdate->gender == 'MALE') echo "selected"; ?> value="MALE">MALE</option>
		                    </select>
							<label for="gender" class="error" style="display: none;"></label> 
		                </div>
		                <div class="form-group">
		                    <label class="control-label" for="type">Item Type</label>
		                    <select class="form-control" name="type">
								<option></option>
		                        <option <?php if ($itemForUpdate->type == 'TOP') echo "selected"; ?> value="TOP">TOP</option>
		                        <option <?php if ($itemForUpdate->gender == 'BOTTOM') echo "selected"; ?> value="BOTTOM">BOTTOM</option>
		                    </select>
							<label for="type" class="error" style="display: none;"></label>
						</div>
						
						 <div class="form-group">
							 <label class="control-label" for="description">Description</label>
							 <textarea class="form-control" name="description" id="description"/><?php echo $itemForUpdate->description; ?></textarea>
						 </div>
						 
						 <div class="form-group">
							 <label class="control-label" for="price">Item Price</label>
							 <div class="input-group">
							   <span class="input-group-addon">$</span>
							   <input class="form-control" type="text" name="price" id="price" value="<?php echo $itemForUpdate->price; ?>"/>
							  </div>
							  <label for="price" class="error" style="display: none;"></label> 
						 </div>
			            
			            <div class="form-group">
							<?php if ($itemForUpdate != NULL) { ?>
						 	  <p> <label class="control-label">Item Image</label></p>
							<img class="thumbnail" src="images/items/<?php echo $itemForUpdate->picture; ?>" />
						
							<?php }?>
						
							<p><label class="control-label" for="imageToUpload"><?php if ($itemForUpdate != NULL) echo "Change Item Image: "; else echo "Upload Item Image: "; ?></label></p>
								<input class="form-control" type="file" name="imageToUpload" id="imageToUpload" class="file" <?php if ($itemForUpdate == NULL) echo "required"; ?> >
								
						</div>
							
						<div class="form-group">
							<h3 class="page-header">Categories</h3>
						<table class="table">
							<thead>
							<tr><th class="col-md-3">Category</th><th class="col-md-9">Attribute</th></tr>
							</thead>
							<?php
								$categoriesQuery = mysql_query("SELECT * FROM categories");
								while($catRow = mysql_fetch_array($categoriesQuery)) {
									echo "<tr>";
									echo "<td>".$catRow['name']."</td>";
									echo "<td>";
									echo "<select name='cat_".$catRow['category_id']."' onChange='checkNew(".$catRow['category_id'].",this.value);'>"; 
									echo "<option></option>";
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
					</div>	
			           
					<div class="form-group">
						<h3 class="page-header">Item Stock</h3>
						
						<p><label for="size[]" class="error" style="display: none;"></label></p>
						<p><label for="quantity[]" class="error" style="display: none;"></label></p>
						<table id="stockTable" class="table">
						 <thead>
							 <th class="col-md-1"></th>
							 <th class="col-md-5">Size</th>
							 <th class="col-md-6">Quantity</th>
						 </thead>
						 <tbody>
						<?php
							if ($itemForUpdate != NULL) {
								$stockArray = $itemForUpdate->getItemStock();
								foreach ($stockArray as $stockId=>$stockInfo) { ?>
							  <tr>
								<p>
								<td><input type="checkbox" name="chk[]" checked="checked"/><input type="hidden" name="stockIds[]" value="<?php echo $stockId; ?>"/></td>
								<td><input class="form-control" type="text" name="size[]" value="<?php echo $stockInfo['size']; ?>"/></td>
								<td><input class="form-control" type="text" class="small"  name="quantity[]" value="<?php echo $stockInfo['quantity']; ?>"/></td>
								</p>
							  </tr>
						<?php
								}
							} else {
						?>
						  <tr>
							<p>
							<td><input type="checkbox" name="chk[]" checked="checked"/><input type="hidden" name="stockIds[]"/></td>
							<td><input class="form-control"  type="text" name="size[]"/></td>
							<td><input class="form-control" type="text" class="small"  name="quantity[]"/></td>
							</p>
						  </tr>
						<?php
							}	
						?>
						 </tbody>
						</table>
						<p> 
						  <input id="addSize" class="btn btn-sm" name="addSize" type="button" value="Add Size" onClick="addRow('stockTable');" /> 
						  <input id="removeSize" class="btn btn-sm" name="removeSize" type="button" value="Remove Size" onClick="deleteRow('stockTable');" /> 
						  (All acions apply only to entries with check marked check boxes only.)
						</p>
						<input type="hidden" name="designerId" value="<?php echo $_SESSION['user_id']; ?>" />
						<?php if ($itemForUpdate != NULL) { ?>
			            	<input class="btn btn-primary" type="submit" value="Update Item" name="submit"/>
						<?php } else { ?>
							<input class="btn btn-primary" type="submit" value="Add Item" name="submit"/>
						<?php } ?>
					</div>
			    </form>
				
			</div>

  </body>
</html>