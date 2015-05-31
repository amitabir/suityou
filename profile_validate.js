/**
 * 
 */
$().ready(function(){
	$("#update_form").validate({
		//debug:true,
		rules:{
			email:{
				required: true,
				email:true
			},
			first_name: "required",
			last_name: "required",
			address: "required",
			gender: "required",
			birth_date: {
				required: true,
				dateISO: true
			},
			website_link:{
				url: true
			} 
			
		},
		messages:{
			email:{
				required: "Please enter your Email",
				email: "Please enter a valid Email"
			},
			first_name: "Please enter your first name",
			last_name: "Please enter your last name",
			address: "Please enter your address",
			gender: "Please select your gender",
			birth_date:{
				required: "Please enter your birth date",
				dateISO: "Please enter a valid date"
			},
			website_link:{
				url: "Please enter a valid URL"
			}
		}
	});
});