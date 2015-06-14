<?php
include("config.php");
include("header.php");
include("algorithms.php");

if(isset($_SESSION['user_id'])){
	$userId = $_SESSION['user_id'];
} else {
	$userId = NULL;
}
if ($userId != NULL) {
	$user = User::getUserfromDBbyID($userId);
	$couponMeterValue = $user->coupon_meter;
} else {
	$couponMeterValue = 0;
}
$matchId = getUserNextMatchQuestion($userId);
?>
<script>
function refreshGage(value) {
	g.refresh(value);
	if (value == 100) {
		$("#max_coupon").show("blind", {direction: "up"}, 800);
	}
}

function showSpammerLabel() {
	$("#spammer_label").show("blind", {direction: "up"}, 800);
}

function showUnsignedUserLabel()
{
	$("#unsigned_label").show("blind", {direction: "up"}, 800);
}	

$(document).ready(function(){	
	
$.ajax({ url: "show_match.php?matchId=<?php echo $matchId; ?>",
        context: document.body,
        success: function(result) {
          $("#match").html(result);
        }});
});
</script>
	
	<div class="container">
		<div class="row" align="center">
			<div class="col-md-3" style="padding: 0">
				<div id="gauge" style="width:300px; height:220px"></div>
        		<script>
				var g = new JustGage({
				  id: "gauge",
				  value: <?php echo $couponMeterValue; ?>,
				  min: 0,
				  max: 100,
				  title: "Your Coupon Meter",
				  levelColors:["#8B7500", "#CDAD00","#EEC900","#FFD700"]
					
				});
				
				</script>
				<div id="max_coupon" style="display: none">
					<div class="alert alert-warning alert-dismissible" role="alert" >
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					  <p><strong>Congratulations!</strong></p> <p>You got a 10% discount coupon! </p> <p><a href="cart.php"> Go to Shopping Cart </a> </p>
					</div>
				</div>
				<div id="spammer_label" style="display: none">
					<div class="alert alert-danger alert-dismissible" role="alert" >
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					  <p><strong>Warning!</strong></p> <p> Our system determined your activity as suspicious. You can no longer rate the matches to earn coupons. Please try again later. </p>
					</div>
				</div>
				<div id="unsigned_label" style="display: none">
					<div class="alert alert-info" role="alert" >
					  <!--<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
					  <p><strong>You must sign up to gain coupons</strong></p><a href="sign_up.php">click here to sign up</a></p>
					</div>
				</div>
			</div>
			<div class="col-md-9" id="match">
			</div>
		</div>
	</div>
  </body>
</html>