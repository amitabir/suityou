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
	
	function loadScore(top, bot) {
		$("#meter").load("score_meter.php?top="+top+"&bot="+bot);
	}

$(document).ready(function() {

	loadMatchInit(); //load initial records
	
	/* 	<?php if ($total_pages > 1) {  ?>
		$('#pages').twbsPagination({
				totalPages: <?php echo $total_pages; ?>,
				visiblePages: 5,
				onPageClick: function (event, page) {
					loadResults(page);
				}
		});
		<?php } ?> */
});
</script>
        
<div class="loading-div"><img src="ajax-loader.gif" ></div>
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

<div class="container">
	<div class="row text-center">
        <div class="col-lg-12">
			<ul id="pages" class="pagination-sm"></ul>
		</div>
	</div>
</div>


  </body>
</html>