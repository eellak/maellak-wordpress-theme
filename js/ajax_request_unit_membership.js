(function($){
	$(document).ready( function(){
	
		//if submit button is clicked
		$('.request-membership').click( function (){   
			var req_parent = $(this).parent();
			jQuery.post(
				ajax_request_unit_membership_settings.ajax_url,
				{
					action : 'ma_ellak_request_unit_membership_action',
					req_user : $(this).attr("usr"),
					req_unit : $(this).attr("unt"),
					req_nonce : ajax_request_unit_membership_settings.req_nonce,
				},
				function( response ) {
					if(response == 'OK'){
						req_parent.html(ajax_request_unit_membership_settings.success_msg);
					} else {
						req_parent.html(ajax_request_unit_membership_settings.error_msg);
					}
					
				}
			);
			return false;
		}); 
		
		//if submit button is clicked
		$('.leave-membership').click( function (){   
			var req_parent = $(this).parent();
			jQuery.post(
				ajax_request_unit_membership_settings.ajax_url,
				{
					action : 'ma_ellak_request_unit_membership_action',
					req_user : $(this).attr("usr"),
					req_unit : $(this).attr("unt"),
					req_nonce : ajax_request_unit_membership_settings.req_nonce,
					req_reason: 'leave',
				},
				function( response ) {
					if(response == 'OK'){
						req_parent.html(ajax_request_unit_membership_settings.success_msg_leave);
					} else {
						req_parent.html(ajax_request_unit_membership_settings.error_msg);
					}
					
				}
			);
			return false;
		}); 
		
		
			
	} );
})(jQuery)