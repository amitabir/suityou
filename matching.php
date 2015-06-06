<?php
include("config.php");
include("header.php");
include("algorithms.php");

$userId = $_SESSION['user_id'];
$matchId = getUserNextMatchQuestion($userId);

// TODO: don't show a designer mathces with his clothes
?>
<script src="js/raphael.2.1.0.min.js"></script>
<script src="js/justgage.1.0.1.min.js"></script>
<script>
$(document).ready(function(){
$.ajax({ url: "show_match.php?matchId=<?php echo $matchId; ?>",
        context: document.body,
        success: function(result) {
          $("#match").html(result);
        }});
});
</script>


	<div class="container" id="match"></div>
  </body>
</html>