(function($){
	$(document).ready( function(){
		
		$("#commentform-praktikh").validate({
			ignore: "",
			rules: {
				ctitle:{ required: true },
				comment:{ required:true },
				
			},
			messages: {
				ctitle:{ required: "Απαιτειται" },
				comment:{ required:"Απαιτειται" },
				
			}
		});
		
	
		$("#commentform-alter").validate({
			ignore: "",
			rules: {
				ctitle:{ required: true },
				comment:{ required:true },
				
			},
			messages: {
				ctitle:{ required: "Απαιτειται" },
				comment:{ required:"Απαιτειται" },
				
			}
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