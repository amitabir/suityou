/**
 * A validator for the add_match form.
 */

$().ready(function(){
	$("#add_match_form").validate({
		rules:{
			top_item_id: {
				required: true,
				number: true
			},
			bottom_item_id: {
				required: true,
				number: true
			},
		},
		messages:{
			top_item_id:{
				required: "Please enter the top item ID",
				number: "ID muse be a number"
			},
			bottom_item_id:{
				required: "Please enter the bottom item ID",
				number: "ID muse be a number"
			},
			imageToUpload: "Please upload a model picture for the match",
		},
		errorPlacement: function(error, element) {
		    if (element.attr("name") == "top_item_id") {
		    	error.insertAfter("#openerTop");
		    } else if (element.attr("name") == "bottom_item_id" ) {
				error.insertAfter("#openerBottom");
		    } else {
				error.insertAfter(element);
		    }
		  }
	});
});