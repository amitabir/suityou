/**
 * A validator for the add_item form.
 */

$().ready(function(){
	$("#add_item_form").validate({
		rules:{
			name: "required",
			price: {
				required: true,
				number: true
			},
			type: "required",
			gender: "required",
		},
		messages:{
			name: "Please enter the item name",
			price:{
				required: "Please enter the item price (in USD)",
				number: "Please enter a decimal number for the price"
			},
			type: "Please select the item type",
			gender: "Please select the item gender",
			imageToUpload: "Please upload a picture for the item",
		}
	});
	
    $('[name*="cat_"]').each(function () {
           $(this).rules('add', {
               required: true,
               messages: {
                   required: "Please select an attribute in this category"
               }
           });
       });
	   
   $('[name*="size"]').each(function () {
          $(this).rules('add', {
              required: true,
              messages: {
                  required: "Please enter all the sizes"
              }
          });
      });

  $('[name*="quantity"]').each(function () {
         $(this).rules('add', {
             required: true,
			 number: true,
             messages: {
                 required: "Please enter all the quantities",
				 number: "All quantities must be a number"
             }
         });
     });
});