/**
 * A validator for the add_item form.
 */

$().ready(function(){	
    $('[name*="updateCartForm_"]').each(function () {
		$(this).validate();
	});

  $('[name*="qty_"]').each(function () {
         $(this).rules('add', {
             required: true,
			 number: true,
             min: 1,

             messages: {
                 required: "Please enter the required quantity",
				 number: "The quantity must be a number",
                 min: "The quantity must be greater or equal to 1"
             }
         });
     });
});