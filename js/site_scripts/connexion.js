/**
 * 
 */
$().ready(function(){
	$("#connexion_form").validate({
		//debug:true,
		rules:{
			email:{
				required: true,
				email:true
			},
		},
		messages:{
			email:{
				required: "Please enter your Email",
				email: "Please enter a valid Email"
			}
		}
	});
});

