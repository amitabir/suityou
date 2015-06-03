/**
 * 
 */

$().ready(function(){
	$("#sign_up_form").validate({
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
			is_designer:"required"
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
			is_designer: "Please mention if you are a designer or not"
		}
	});
});