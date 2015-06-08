<?php
include("header.php");

$designerId = $_GET['designerId'];

$designer = User::getUserfromDBbyID($designerId);

$item_per_page = 4;
$countQuery = mysql_query('SELECT count(*) FROM items WHERE designer_id = '.$designerId);
$countRow = mysql_fetch_array($countQuery);
	
$total_pages = ceil($countRow[0]/$item_per_page);
?>	
<script type="text/javascript">
$(document).ready(function() {
	
	function loadResults(page) {
	    $("#results").load("deisgner_items_fetch.php?designerId=<?php echo $designerId ?>", {"page":page, "itemsPerPage":<?php echo $item_per_page ?>}); 
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

<div class="container">
  <h1 class="page-header"><?php echo $designer->first_name.' '.$designer->last_name ?></h1>
  <div class="row">
    <div class="col-md-4">
        <p><img src="<?php echo "images/users/".$designer->avatar ?>" class="avatar img-circle img-thumbnail" alt="avatar"></p>
		<div class = "panel">
			<div class = "panel_body">
				<p><?php echo $designer->description; ?></p>
			</div>
		</div>
		<p><a href="<?php echo $designer->website_link; ?>">Designer Website</a></p>
    </div>
    <div class="col-md-8">
    	<h3>Designer Itmes</h3>
		
		<div id="results"><!-- content will be loaded here --></div>
		<div class="row text-center">
	        <div class="col-lg-12">
				<ul id="pages" class="pagination-sm"></ul>
			</div>
		</div>
    </div>
  </div>
</div>