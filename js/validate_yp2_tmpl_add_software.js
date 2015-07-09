(function($){
	$(document).ready( function(){
		
		$("#ma_ellak_software_submit_form").validate({
			ignore: "",
			rules: {
				ctitle:{ required: true , minlength: 3 },
				cdescription:{ required:true , minlength:20 },
				'thema-select[]':{ required:true },
				_ma_software_website_url:{ url:true },
				_ma_software_repository_url:{ url:true },
			},
			messages: {
				ctitle:{ required: "Απαιτείται",  minlength:"Τουλάχιστον 3 χαρακτήρες!" },
				cdescription:{ required:"Απαιτείται",  minlength:"Τουλάχιστον 20 χαρακτήρες!" },
				'thema-select[]':{ required:"Απαιτείται" },
				_ma_software_website_url:{ url:"Ο σύνδεσμος θα πρέπει να ειναι πλήρης (http://...)" },
				_ma_software_repository_url:{ url:"Ο σύνδεσμος θα πρέπει να ειναι πλήρης (http://...)" },
			}
		});
		
		$('#addnewtags').click(function( event){
			 event.preventDefault();
			$('#selftags').slideToggle();
		});
		
	});
})(jQuery)
