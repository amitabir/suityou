<?php
include 'header.php';
?>
	<script type="text/javascript" src="connexion.js"></script>
		<div class="content">
		    <form id="connexion_form"action="connexion.php" method="post">
		        Please type your Email to log in:<br />
		        <div class="center">
			        	<label for="email">Email</label><input type="text" name="email" id="email" value="<?php if(isset($_SESSION['email'])) echo $_SESSION['email'];?>" /><br/>
		        <input type="submit" value="Log in" />
				</div>
		    </form>
		</div>