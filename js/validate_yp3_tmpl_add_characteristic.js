(function($){
	$(document).ready( function(){
		
		$("#ma_ellak_characteristic_submit_form").validate({
			ignore: "",
			rules: {
				ctitle:{ required: true },
				cdescription:{ required:true },
				gstatus:{ required:true },
				_ma_characteristic_type:{ required:true },
			},
			messages: {
				ctitle:{ required: "Απαιτείται" },
				cdescription:{ required:"Απαιτείται" },
				gstatus:{ required: "Απαιτείται" },
				_ma_characteristic_type:{ required:"Απαιτείται" },
			}
		});
		
	} );
})(jQuery)