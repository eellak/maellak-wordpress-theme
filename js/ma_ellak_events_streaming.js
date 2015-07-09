(function($){
	$(document).ready( function(){
	
		    $(".trick").click(function(){
		        var post_id = $(this).attr("rel");
		        var event_id = $(this).attr('data-eventid');
		        var req_parent = $("#single-home-container");
		        
		        jQuery.post(
		        		ajax_request_streaming_settings.ajax_url,
						{
							action : 'ma_ellak_register_video_action',
							video : $(this).attr("rel"),
							eventid : $(this).attr("eventid"),
							eventtitle :$(this).attr("eventtitle"),
							req_nonce : ajax_request_streaming_settings.req_nonce,
						},
		        		function( response ) {
					       //console.log(response);
					       console.log(this);
						   $('#single-home-container').html(response);
						}
					);
					return false;
				 
		        
		    });
	} );
})(jQuery)