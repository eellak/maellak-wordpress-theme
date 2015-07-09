(function($){
	$(document).ready( function(){

		jQuery.extend(jQuery.validator.messages, {
		    required: "Απαιτειται",
		});
	$("#commentform").validate({
			ignore: "",
			rules: {
				comment:{ required:true },
				
			},
			messages: {
				comment:{ required:"Απαιτειται" },
				
			}
		});
	} );
})(jQuery)