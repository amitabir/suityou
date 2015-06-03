<?php
include('header.php');
if(isset($_SESSION['sign_up_message']))
{
    $message=$_SESSION['sign_up_message'];
    if(!empty($message))
    {
        echo '<script language="javascript">';
        echo 'alert("'.$message.'")';
        echo '</script>';
        unset($_SESSION['sign_up_message']);
    }
}
?>
<script type="text/javascript" src="sign_up_validate.js"></script>
<div class="content">
    <form id="sign_up_form" action="sign_up.php" method="post">
        Please fill the following form to sign up:<br />
        <div class="center">
        	<label for="email">Email</label><input type="email" name="email" value="<?php if(isset($_SESSION['email'])){echo htmlentities($_SESSION['email'], ENT_QUOTES, 'UTF-8');} ?>" /><br />
            <label for="first_name">First name:</label><input type="text" name="first_name" id="first_name" /><br />
            <label for="last_name">Last name:</label><input type="text" name="last_name" id="last_name" /><br />
            <label for="address">Address:</label><input type="text" name="address" id='address' /><br />
            <label for="gender">Gender:</label>
            <select name="gender" size="2">
            	<option selected="selected" value="FEMALE">FEMALE</option>
            	<option value="MALE">MALE</option>
			</select><br/>            
            <label for="birth_date">Birth Date:</label><input type="date" name="birth_date" id="birth_date"  /><br />
            <label for="is_designer">Designer:</label><label>Yes:</label><input type="radio" name="is_designer" value="1"/><label>No:</label><input type="radio" name="is_designer" value="0" checked/><br/>
            <input type="submit" value="Sign up" />
		</div>
    </form>
</div>