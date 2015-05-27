<?php
include 'header.php';
if(isset($_SESSION['update_message']))
{
	$message=$_SESSION['update_message'];
	if(!empty($message))
	{
		echo '<script language="javascript">';
		echo 'alert("'.$message.'")';
		echo '</script>';
		unset($_SESSION['update_message']);
	}
}
if(isset($_SESSION['user_id'],$_SESSION['email']))
{		
		$user = User::getUserfromDBbyID($_SESSION['user_id']);
		if($user != null)
		{
			if(isset($_POST['editButton']))		
			{
				$read_only='';
				$disabled='';
			}
			else
			{
				$read_only='readonly';
				$disabled='disabled';
			}
?>
 <div class="content">
 	<form method="POST" action=''>
				 <input type="submit" name="editButton"  value="Edit Your Details">
	</form>
    <form action="update.php" method="post">
  		<div class="center">  			
        	<label for="email">Email</label><input type="text" name="email" value="<?php echo htmlentities($user->{'email'}, ENT_QUOTES, 'UTF-8'); ?>" <?php echo $read_only;?>/><br />
            <label for="first_name">First name:</label><input type="text" name="first_name" id="first_name" value="<?php echo htmlentities($user->{'first_name'}, ENT_QUOTES, 'UTF-8'); ?>" <?php echo $read_only;?>/><br />
            <label for="last_name">Last name:</label><input type="text" name="last_name" id="last_name" value="<?php echo htmlentities($user->{'last_name'}, ENT_QUOTES, 'UTF-8'); ?>" <?php echo $read_only;?>/><br />
            <label for="address">Address:</label><input type="text" name="address" id='address' value="<?php echo htmlentities($user->{'address'}, ENT_QUOTES, 'UTF-8'); ?>" <?php echo $read_only;?>/><br />
            <label for="gender">Gender:</label>
            <?php $gender = $user->{'gender'}; ?>
            <select name="gender" size="2" <?php echo $read_only;?> >
            	<option <?php if($gender =="FEMALE") echo "selected='selected'"; ?>value="FEMALE">FEMALE</option>
            	<option <?php if($gender =="MALE") echo "selected='selected'"; ?>value="MALE">MALE</option>
			</select><br/>            
            <label for="birth_date">Birth Date:</label><input type="text" name="birth_date" id="birth_date" <?php echo $read_only;?> /><br />
            <!--INSERT ISDESIGNER FURTHER LOGICS--><input type="checkbox" name="is_designer" id="is_designer" value="0" <?php echo $read_only;?>/><br/>
            <label for="avatar">Avatar:<span class="small">(optional)</span></label><input type="text" name="avatar" value="<?php echo htmlentities($user->{'avatar'}, ENT_QUOTES, 'UTF-8');?>"  <?php echo $read_only;?>/><br />
            <label for="description">Description:<span class="small">(optional)</span></label><input type="text" name="description" id="description"  value="<?php echo htmlentities($user->{'description'}, ENT_QUOTES, 'UTF-8');?>" <?php echo $read_only;?>/><br />
            <label for="website_link">Web Site:<span class="small">(optional)</span></label><input type="text" name="website_link" id="website_link"  value="<?php echo htmlentities($user->{'website_link'}, ENT_QUOTES, 'UTF-8');?>" <?php echo $read_only;?>/><br />
            <input type="submit" value="update" <?php echo $read_only.' '; echo $disabled;?>/>        
		</div>
    </form>
    
</div>
<?php 
				if($user->is_designer != 0)
				{
					//insert edit designer details	
				}			
		}
		else 
		{
			//user null			
			header("Location: connexion.php");	
		}
}
else
{
	//user not logged in
	header("Location: connexion.php");
}