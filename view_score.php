<?php
include("header.php");
?>	
<script type="text/javascript">
	function loadMatch(gender, matchId, firstId,secondId) {
	    $("#results").load( "score_viewer.php?gender="+gender+"&matchId="+matchId+"&firstId="+firstId+"&firstId="+firstId); 
	}

	function loadMatchInit() {
	    $("#results").load( "score_viewer.php"); 
	}

$(document).ready(function() {

	loadMatchInit();
});
</script>
        
<div class="container">

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header" align="center">
				Item Scores
			</h1>
		</div>
	</div>	



	
<div id="results"><!-- content will be loaded here --></div>
</div>

  </body>
</html>