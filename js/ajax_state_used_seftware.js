(function($){
	$(document).ready( function(){
	
		//if submit button is clicked
		$('.used-it').click( function (){   
			var req_parent = $(this).parent();
			jQuery.post(
				ajax_state_used_it_settings.ajax_url,
				{
					action : 'ma_ellak_state_used_it_action',
					req_user : $(this).attr("usr"),
					req_software : $(this).attr("sid"),
					req_nonce : ajax_state_used_it_settings.req_nonce,
				},
				function( response ) {
					if(response == 'OK'){
						req_parent.html(ajax_state_used_it_settings.success_msg);
					} else {
						req_parent.html(ajax_state_used_it_settings.error_msg);
					}
					
				}
			);
			return false;
		}); 
		
	} );
})(jQuery)