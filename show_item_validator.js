$().ready(function(){   
    $("#addToCartForm").validate({
                rules:
                {
                    quantity:
                    { 
                        required:true,
                        number: true,
                        min: 1
                    }
                },
                messages:
                {
                    quantity:
                    {
                        required: "Please enter the required quantity",
                        number: "The quantity must be a number",
                        min: "The quantity must be greater or equal to 1"
                    }

                },
                // errorPlacement: function(error, element) 
                // {
                //    error.appendTo($("#errorBox"));
                // }
    });
        
});