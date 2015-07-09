(function($){
	$(document).ready( function(){
		
		$("#ma_ellak_unit_submit_form").validate({
			ignore: "",
			rules: {
				ctitle:{ required: true },
				cdescription:{ required:true },
			},
			messages: {
				ctitle:{ required: "Απαιτείται" },
				cdescription:{ required:"Απαιτείται" },
			}
		});
		
	} );
})(jQuery)