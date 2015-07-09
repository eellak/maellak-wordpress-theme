(function($){
	$(document).ready( function(){
	
		//if submit button is clicked
		$('#interest_on_job').click( function (){   
			var req_parent = $('#application_placeholder');
			jQuery.post(
				ajax_job_application_settings.ajax_url,
				{
					action : 'job_application_action',
					req_user : $(this).attr("usr"),
					req_job : $(this).attr("job"),
					req_nonce : ajax_job_application_settings.req_nonce,
				},
				function( response ) {
					if(response == 'OK'){
						req_parent.html('<p>'+ajax_job_application_settings.success_msg+'</p>');
					} else {
						req_parent.html('<p>'+ajax_job_application_settings.error_msg+'</p>');
					}
					
				}
			);
			return false;
		}); 		
			
	} );
})(jQuery)