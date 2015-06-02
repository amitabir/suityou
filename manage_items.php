<?php
include("header.php");
?>
<script type="text/javascript">
$(document).ready(function() {
	$("#results" ).load( "manage_items_fetch.php"); //load initial records
	
	//executes code below when user click on pagination links
	$("#results").on( "click", ".pagination a", function (e){
		e.preventDefault();
		$(".loading-div").show(); //show loading element
		var page = $(this).attr("data-page"); //get page number from link
		$("#results").load("manage_items_fetch.php",{"page":page}, function(){ //get content from PHP page
			$(".loading-div").hide(); //once done, hide loading element
		});
		
	});
});
</script>

    <div id="content_header"></div>
    <div id="site_content">
        <div id="content">
            <div id="content-part">
			<a href='add_item.php'> Add New Item </a>
			
			<div class="loading-div"><img src="ajax-loader.gif" ></div>
			<div id="results"><!-- content will be loaded here --></div>
			
            </div>
        </div>
    </div>

</div>

  </body>
</html>