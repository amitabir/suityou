<?php
include("header.php");
include("algorithms.php");

$constantsArray = getConstantsWithDescription();
?>
<script type="text/javascript">
    $(function () {
        $("[data-toggle='popover']").popover();
    });
</script>

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
						<div class="col-md-4">
	                    	<label class="control-label" for="<?php echo $constName; ?>"><?php echo $constName; ?>
								<a tabindex="0" role="button" data-toggle="popover" data-trigger = "focus"
								title="Description" data-content= "<?php echo $constData['description']; ?>">
								<span class = "glyphicon glyphicon-question-sign"></span></a>
							</label>
						</div>
						<div class="col-md-8">
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
