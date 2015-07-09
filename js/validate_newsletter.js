(function($){
	$(document).ready( function(){

		$('.newsletter-btn-submit').click(function() {  
			
			var hasError = false;
			$(".news-error").hide();
			var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
			var emailaddressVal = $("#wpoi_email").val();
			var emailremoveVal = $('#wpoi_remove').attr('checked')?'yes':'no';
			if(emailaddressVal == '') {
				$("#wpoi_email").after('<span class="error news-error">'+ma_ellak_newsletter_settings.need_email+'</span>');
				hasError = true;
			} else if(!emailReg.test(emailaddressVal)) {
				$("#wpoi_email").after('<span class="error news-error">'+ma_ellak_newsletter_settings.valid_email+'</span>');
				hasError = true;
			}
			
			if(!hasError){
				jQuery.post(
					ma_ellak_newsletter_settings.ajax_url,
					{
						action : 'ma_ellak_register_newsletter_action',
						wpoi_email : emailaddressVal,
						wpoi_remove : emailremoveVal,
						req_nonce : ma_ellak_newsletter_settings.req_nonce,
					},
					function( response ) {
						$("#wpoi_email").after('<span class="error news-error">'+response+'</span>');	
					}
				);
			}
			
			return false;
		
		});
	} );
})(jQuery)
