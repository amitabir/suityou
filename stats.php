<?php
include("header.php");
?>	
<script type="text/javascript">
	function loadCatTable(page, category, att1, att2) {
	    $("#results").load( "stats_fetch.php?categoryID="+category+"&att1ID="+att1+"&att2ID="+att2, {"page":page}); 
	}

	function loadInitialCatTable(page) {
	    $("#results").load( "stats_fetch.php", {"page":page}); 
	}

$(document).ready(function() {

	loadInitialCatTable(1); //load initial records
	
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
				Statistics
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