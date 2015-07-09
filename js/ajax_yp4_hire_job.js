(function($){
	$(document).ready(function(){
		var user = jQuery("#user").val();
		var previous_jobs=jQuery("#previous_jobs").val();

		allcheck=new Array();
		$("#api input[type=checkbox]").click(function(){
			if ($(this).attr("checked") == "checked"){
				checkbox_value=$(this).attr('rel');
				allcheck.push(checkbox_value);
			}
		});

		$("#add").click(function(){
			jQuery.ajax(
				ajax_request_hire_settings.ajax_url,{
					type: 'POST',
					data:{
						action: 'ma_ellak_hire_job',
						user: user,
						list:allcheck,
						previous:previous_jobs,
					},
					success: function(data, textStatus, XMLHttpRequest){
						jQuery("#test-div1").html('Τα δεδομένα καταχωρήθηκαν.');
						jQuery("#test-div1").append(data);
					},
					error: function(MLHttpRequest, textStatus, errorThrown){
						alert('Προέκυψε κάποιο πρόβλημα!');
					}
				}
			);
		});	
	} );
})(jQuery)