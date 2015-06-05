<?php
include("header.php");
$gender = $_GET["gender"];
$type = $_GET["type"];

$item_per_page = 15;
$countQuery = mysql_query('SELECT count(*) FROM items WHERE gender = "'.$gender.'" AND type = "' .$type. '"');
$countRow = mysql_fetch_array($countQuery);
	
$total_pages = ceil($countRow[0]/$item_per_page);
?>	
<script type="text/javascript">
$(document).ready(function() {
	
	function loadResults(page) {
	    $("#results").load("shop_fetch.php?gender=<?php echo $gender; ?>&type=<?php echo $type; ?>", {"page":page, "itemsPerPage":<?php echo $item_per_page ?>}); 
	}
	
	loadResults(1); //load initial records
	
	<?php if ($total_pages > 1) {  ?>
	$('#pages').twbsPagination({
	        totalPages: <?php echo $total_pages; ?>,
	        visiblePages: 5,
	        onPageClick: function (event, page) {
				loadResults(page);
	    	}
	});
	<?php } ?>
});
</script>
        
<div class="loading-div"><img src="ajax-loader.gif" ></div>
<div id="results"><!-- content will be loaded here --></div>

<div class="container">
	<div class="row text-center">
        <div class="col-lg-12">
			<ul id="pages" class="pagination-sm"></ul>
		</div>
	</div>
</div>


  </body>
</html>