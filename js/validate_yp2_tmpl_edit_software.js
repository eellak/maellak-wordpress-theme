(function($){
	$(document).ready( function(){
		
		
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