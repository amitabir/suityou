<?php
include("config.php");
include("header.php");
include("algorithms.php");

$userId = $_SESSION['user_id'];
$matchId = getUserNextMatchQuestion($userId);

// echo '<script type="text/javascript">'
//    , 'showMatch('.$matchId.');'
//    , '</script>'
// ;

?>

<script>
$(document).ready(function(){
$.ajax({ url: "show_match.php?matchId=<?php echo $matchId; ?>",
        context: document.body,
        success: function(result) {
          $("#match").html(result);
        }});
});
</script>

    <div id="content_header"></div>
    	<div id="site_content">
			<div id="content">
				<div id="match"></div>
        	</div>
    	</div>
	</div>
  </body>
</html>