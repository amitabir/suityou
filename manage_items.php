<?php
include("header.php");

if(isset($_SESSION['item_update_message']) and isset($_SESSION['item_update_success'])) {
	$message = $_SESSION['item_update_message'];
	if ($_SESSION['item_update_success']) {
		$class='"alert alert-success alert-dismissible"';
	} else {
		$class='"alert alert-danger alert-dismissible"';
	}
	if(!empty($message)) {
		echo '<div class='.$class.' role="alert">';
		echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		echo $message;
		echo '</div>';
		unset($_SESSION['item_update_message']);
	}
	unset($_SESSION['item_update_success']);
}

$designerId = $_SESSION["user_id"];

$item_per_page = 10;
$countQuery = mysql_query('SELECT count(*) FROM items WHERE designer_id = '.$designerId);
$countRow = mysql_fetch_array($countQuery);
	
$total_pages = ceil($countRow[0]/$item_per_page);
?>	
<script type="text/javascript">
$(document).ready(function() {
	
	function loadResults(page) {
	    $("#results").load("manage_items_fetch.php", {"page":page, "itemsPerPage":<?php echo $item_per_page ?>}); 
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