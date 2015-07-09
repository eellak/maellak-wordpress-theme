(function($){
	$(document).ready( function(){
		
		$("#ma_ellak_software_submit_form").validate({
			ignore: "",
			rules: {
				namez:{ required: true },
				surnamez:{ required:true },
				emailz:{ required:true,
						 email:true},
				fileToUpload: {required:true},
			    cptch_number:{required:true}
				
			},
			messages: {
				namez:{ required: "Απαιτείται" },
				surnamez:{ required:"Απαιτείται" },
				emailz:{ required:"Απαιτείται",
						 email:"Πρέπει να έχει την μορφή email"},
				fileToUpload: {required: "Το βιογραφικό είναι υποχρεωτικό"},
				cptch_number:{required:"Απαιτείται το captcha που ακολουθεί"}
			
			},
			errorPlacement: function(error, element) {         
					if(element.attr("name") == "cptch_number") 
						error.insertBefore(element.parent());
					else 
						error.insertAfter(element);
			   }
		});
		
	} );
})(jQuery)