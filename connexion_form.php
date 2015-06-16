<?php
include 'header.php';
?>
	<script type="text/javascript" src="js/site_scripts/connexion.js"></script>
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<form class="form-horizontal" id="connexion_form" action="connexion.php" method="post">
					<h3>Please type your Email to Log in:</h3>
					<div class="form-group">
						<label class="control-label">Email:</label>
						<input class="form-control" type="text" name="email" id="email" value="<?php if(isset($_SESSION['email'])) echo $_SESSION['email'];?>" />
					</div>
					<div class="form-actions">    
                    	<button class="btn btn-default btn-block" type="submit">Log in</button>
                	</div>
                </form>
			</div> 
		</div>
	</div>