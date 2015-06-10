<?php
include 'header.php';
if(isset($_SESSION['update_message']))
{
	$message=$_SESSION['update_message'];
	if(!empty($message))
	{
		if($message=="Updated Successfully")
		{
			$class='"alert alert-success alert-dismissible"';
		}
		else
		{
			$class='"alert alert-danger alert-dismissible"';
		}
		
		echo '<div class='.$class.' role="alert">';
		echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		echo $message;
		echo '</div>';
		unset($_SESSION['update_message']);
	}
}
if(isset($_SESSION['firstTime']) && $_SESSION['firstTime'])
{
	$first_time = true;
}
else
{
	$first_time = false;
}
if(isset($_SESSION['user_id'],$_SESSION['email']))
{		
		$user = User::getUserfromDBbyID($_SESSION['user_id']);
		if($user != null)
		{
			if(isset($_POST['editButton']) || isset($_POST['editDesignerButton']) || $first_time)		
			{
				if (isset($_POST['editButton'])){
					$designerTabActive="";
					$userTabActive="active";
				}else if(isset($_POST['editDesignerButton']) || $first_time){
					$designerTabActive="active";
					$userTabActive="";
				}
				
				$read_only='';
				$disabled='';
				$hidden='';
				$hiddenEdit='style="display:none"';
			}
			else
			{

				$designerTabActive="";
				$userTabActive="active";
				$read_only='readonly';
				$disabled='disabled';
				$hidden='style="display:none"';
				$hiddenEdit='';
			}
			if(isset($_SESSION['is_designer']) && $_SESSION['is_designer'] == "1")
			{
				$designer= true;
			}
			else
			{
				$designer= false;
			}
?>
<script type="text/javascript" src="profile_validate.js"></script>
<style type="text/css">
      .form-control[readonly],.form-control[disabled]
      {
      	background-color: #fff;
      }
</style>
<div class="container">
	<div role="tabpanel">
	  <!-- Nav tabs -->
	  <ul class="nav nav-tabs" role="tablist">
	    <li role="presentation" class="<?php echo $userTabActive?>"><a href="#Personal" aria-controls="Personal" role="tab" data-toggle="tab">Personal details</a></li>
	    <?php
	    	if($designer)
	    	{
	    ?>
	    	<li role="presentation" class="<?php echo $designerTabActive?>"><a href="#designer" aria-controls="designer" role="tab" data-toggle="tab">Designer Details</a></li>
	    <?php		
	    	}
	    ?>
	  </ul>
	  <!-- Tab panes -->
	  <div class="tab-content">
	    <div role="tabpanel" class="tab-pane <?php echo $userTabActive?>" id="Personal">
	    	<div class="container">
				 <div class="row">
				 	<div class="col-md-6 col-md-offset-3">
						    <form class="form-horizontal" id="update_form" action="profile_update.php" method="post" role="form" enctype="multipart/form-data">
						  		<div class="form-group">
						  			<label class="control-label" for="email">Email</label>
						  			<input class="form-control" type="email" name="email" value="<?php echo htmlentities($user->{'email'}, ENT_QUOTES, 'UTF-8'); ?>" <?php echo $read_only;?> />
						  		</div>
						  		<div class="form-group">
						  			<label class="control-label" for="first_name">First name:</label>
						  			<input class="form-control" type="text" name="first_name" id="first_name" value="<?php echo htmlentities($user->{'first_name'}, ENT_QUOTES, 'UTF-8'); ?>" <?php echo $read_only;?>/>
						  		</div>
						  		<div class="form-group">
						  			<label class="control-label" for="last_name">Last name:</label>
						  			<input class="form-control" type="text" name="last_name" id="last_name" value="<?php echo htmlentities($user->{'last_name'}, ENT_QUOTES, 'UTF-8'); ?>" <?php echo $read_only;?>/>
						  		</div>	        	
						        <div class="form-group">
						        	<label class="control-label" for="address">Address:</label>
						        	<input class="form-control" type="text" name="address" id='address' value="<?php echo htmlentities($user->{'address'}, ENT_QUOTES, 'UTF-8'); ?>" <?php echo $read_only;?>/>
						        </div>    
						        <div class="form-group">
						        	<label class="control-label" for="gender">Gender:</label>
						            <?php $gender = $user->{'gender'}; ?>
						            <select class="form-control" name="gender" size="2" <?php echo $disabled;?> >
						            	<option <?php if($gender =="FEMALE") echo "selected='selected'"; ?>value="FEMALE">FEMALE</option>
						            	<option <?php if($gender =="MALE") echo "selected='selected'"; ?>value="MALE">MALE</option>
									</select>
						        </div>    
						        <div class="form-group">
						        	<label class="control-label" for="birth_date">Birth Date:</label>
						        	<input class="form-control" type="date" name="birth_date" id="birth_date" value="<?php echo htmlentities($user->{'birth_date'}, ENT_QUOTES, 'UTF-8'); ?>" <?php echo $read_only; ?> /><br />
						        </div>    
						        <div class="form-actions">
						        	<button class="btn btn-default btn-block" type="submit" <?php echo $read_only.' '; echo $disabled.' '; echo $hidden?> >Update</button>
						        </div>   
						    </form>
						    <form class="form-horizontal" method="POST" action='' role="form" <?php echo $hiddenEdit; ?> >
						 		<div class="form-actions">
						 			<button class="btn btn-default btn-block" type="submit" name="editButton">Edit Your Details</button>
								</div>
							</form>
					    </div>
				    </div>
				</div>
	    </div>
	    <?php
	    if($designer)
	    {
	    ?>
	    <div role="tabpanel" class="tab-pane <?php echo $designerTabActive?>" id="designer">
	    	<div class="container">
				 <div class="row">
				 	<div class="col-md-6 col-md-offset-3">
						    
						  		<div class="form-group">
						  			<label class="control-label" for="description">Description</label>
						  			<textarea class="form-control" name="description" form="update_form" placeholder="Describe yourself..."<?php  echo $read_only; ?>> <?php echo htmlentities($user->{'description'}, ENT_QUOTES, 'UTF-8'); ?> </textarea>
						  		</div>
						  		<div class="form-group">
						  			<label class="control-label" for="website_link">Website:</label>
						  			<input class="form-control" form="update_form" type="text" name="website_link" id="website_link" value="<?php echo htmlentities($user->{'website_link'}, ENT_QUOTES, 'UTF-8'); ?>" <?php echo $read_only;?>/>
						  		</div>
						  		<div class="form-group">
						  		<?php 	
						  		if(!$first_time)
						  		{
						  		?>
						  			<label class="control-label" for="avatar">Image:</label></br>
									<img src="images/users/<?php echo htmlentities($user->{'avatar'}, ENT_QUOTES, 'UTF-8'); ?>" width="170"/>
						  		<?php	
						  		}
						  		?>
								<?php 
								if(isset($_POST['editButton']) || isset($_POST['editDesignerButton']) || $first_time)		
								{
								?>
						  			<input class="form-control" type="file" form="update_form" name="imageToUpload" id="imageToUpload" <?php echo $read_only;?> >
								<?php 
								} 
								?>
						  		</div>
						  		<?php
						  		if(!$first_time)
						  		{
						  		?>
						  		<div class="form-actions">
						        	<button class="btn btn-default btn-block" form="update_form" type="submit" <?php echo $read_only.' '; echo $disabled.' '; echo $hidden?> >Update</button>
						        </div> 	
						    	<form class="form-horizontal" method="POST" action='' role="form" <?php echo $hiddenEdit; ?> >
							 		<div class="form-actions">
							 			<button class="btn btn-default btn-block" type="submit" name="editDesignerButton">Edit Your Details</button>
									</div>
								</form>
						 		<div>
						 			<a href="designer_profile.php?designerId=<?php echo $_SESSION['user_id']?>"><button class="btn btn-default btn-block">View Designer Page</button></a>
								</div>
								<?php
						  		}
						  		else
						  		{
						  		?>
						  		<div class="form-actions">
						        	<button class="btn btn-default btn-block" form="update_form" type="submit" <?php echo $read_only.' '; echo $disabled.' '; echo $hidden?> >Complete Registration</button>
						        </div> 	
						  		<?php
						  		}
								?>
					    </div>
				    </div>
				</div>
	    </div>
	    </div>
	    <?php	 	
	    }
	    ?>
	  </div>
	</div>
</div>
<?php 
		}
		else 
		{
			//user is null	
			echo '<script>window.location.replace("connexion.php")</script>';
		}
}
else
{
	//user is not logged in
	echo '<script>window.location.replace("connexion.php")</script>';
}