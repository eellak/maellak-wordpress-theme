(function($){
	$(document).ready( function(){
		$('#thema-pop').remove();
		$('#publish').click(function(){
			var is_admin=$('#admin').val();
			var update=$('#update').val();
			//validation of video title
			var document_title=$('#title').val();
			if (!document_title){
				alert('Ο τίτλος είναι υποχρεωτικός');
				freezepane();
				return false;
			}

			// No file is uploaded, do not submit.
			if (is_admin==0 && update==0)
				if(!$('input[type="file"]').val()) {
					alert('Θα πρέπει να εισάγετε ένα αρχείο');
					freezepane();
					return false;
				}

			//You are aware of what you upload
			if (is_admin==0){
				if ($("#_ma_document_know").is(':checked')==false) {
					alert('Θα πρέπει να επιλέξετε ότι έχετε γνώση του περιεχομένου που αναρτάτε');
					freezepane();
					return false;
				}
			}

			//Select at least one thema
			var is_admin=$('#admin').val();
			var is_revision=$('#revision').val();
			if (is_admin==0){
				if (is_revision==0){
					var cats = $('[id^="thema-all"]').find('.tagselect-select').find('option');
					var category_selected=false;
					var count_cats = 0;
					var catz = new Array();
					for (counter=0; counter<cats.length; counter++) {
						if (cats.get(counter).selected==true){
							category_selected=true;
							count_cats++;
							catz.push(cats.get(counter).value);
						}
					}

					if(category_selected==false || count_cats==0 ) {
						alert('Επιλέξτε Υποχρεωτικά μία (1) θεματική');
						freezepane();
						return false;
					}
				}
			}
			else{
				var cats = $('[id^="thema-all"]').find('.selectit').find('input');
				var category_selected=false;
				var count_cats = 0;
				var catz = new Array();
				for (counter=0; counter<cats.length; counter++) {
					if (cats.get(counter).checked==true){
						category_selected=true;
						count_cats++;
						catz.push(cats.get(counter).value); 
					}
				}

				if(category_selected==false || count_cats==0 ) {
					if(category_selected==false ){
						alert('Επιλέξτε Υποχρεωτικά μία (1) θεματική');
						jQuery('[id^="taxonomy-thema"]').find('.tabs-panel').css('background', '#F96');
						freezepane();
						return false;
					}
				}
			}
			
		});

		function freezepane(){
			setTimeout("jQuery('.spinner').css('display', 'none');", 500);
			setTimeout("jQuery('#publish').removeClass('button-primary-disabled');", 500);
		};
		
		$('#addnewtags').click(function( event){
			 event.preventDefault();
			$('#selftags').slideToggle();
		});
		
	} );
})(jQuery)