(function($){
	$(document).ready( function(){
		
		$("#ma_ellak_characteristic_submit_form").validate({
			ignore: "",
			rules: {
				ctitle:{ required: true },
				cdescription:{ required:true },
				_ma_characteristic_type:{ required:true },
				_ma_characteristic_acceptance:{ 
					required: function(element){ return $("#stage_status").val() == "done"; }
				}
			},
			messages: {
				ctitle:{ required: "Απαιτείται" },
				cdescription:{ required:"Απαιτείται" },
				_ma_characteristic_type:{ required:"Απαιτείται" },
				_ma_characteristic_acceptance:{ required:"Απαιτείται στην περίπτωση Ολοκλήρωσης!" },
			}
		});
		
		$('#stage_status').change(function(event) {
			var valueSelected= this.value;
			if(valueSelected == 'done'){
				$('#acceptance').slideDown();
			} else {
				$('#acceptance').slideUp();
			}
		});
		
		if($("#stage_status").val() == "done"){
			$('#acceptance').slideDown();
		}
		
		$('#comment_head_edit').click(function(){
			$('#comment_list_admin').slideToggle();
		});
		
		var clickers = $('.action-comment');
		var myClick = null;
		var jQueryHandlers = clickers.data('events').click;

		$.each(jQueryHandlers,function(i,f) {
		   myClick = f.handler; 
		   return false; 
		});
		$(clickers).unbind('click');
		$(clickers).click(function(){
			if(window.confirm("Είστε Σίγουρος/η ;")){
				myClick();
			} else {
				return false;
			}
		});
	} );
})(jQuery)