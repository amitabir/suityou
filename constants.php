<?php
include("header.php");
include("algorithms.php");

$constantsArray = getConstantsWithDescription();
?>
<div class="container">

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header" align="center">
				Manage Constants
			</h1>
		</div>
	</div>	

		<form id="update_constants" class="form-horizontal" action="constants_update.php" method="post" role="form"/>
			<?php 
			 	foreach($constantsArray as $constName=>$constData) {
			?>
			   <div class="row">
					<div class="form-group">
						<div class="col-md-3">
	                    	<label class="control-label" for="<?php echo $constName; ?>"><?php echo $constName; ?></label>
						</div>
						<div class="col-md-9">
	                    	<input type="text" size="5" name="<?php echo $constName; ?>" id="name" value="<?php echo $constData['value']; ?>" />
						</div>
					</div>
				</div>
	 <?php } ?>
	  <div class="row">
		 <div class="col-md-12" style="padding: 0">
	 		 <input class="btn btn-primary" type="submit" value="Update" name="submit"/>
		 </div>
	  </div>
 		</form>
	</div>
