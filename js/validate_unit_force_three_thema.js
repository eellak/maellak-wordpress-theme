(function($){
	$(document).ready( function(){
	
		$('#thema-pop').remove();
		
		 $('#publish').click(function(){
			var cats = $('[id^="thema-all"]').find('.selectit').find('input');
			var category_selected=false;
			var count_cats = 0;
			var catz = new Array();;
			for (counter=0; counter<cats.length; counter++) {
				if (cats.get(counter).checked==true){
					category_selected=true;
					count_cats++;
					catz.push(cats.get(counter).value); 
				}
			}
			
			// Εχουν επιλεγεί Θεματικές ;
			if(category_selected==false || count_cats != 3 ) {
				if(category_selected==false )
					alert('Επιλέξτε Υποχρεωτικά Θεματική');
				if(count_cats != 3 && category_selected !=false)
					alert('Επιλέξτε Υποχρεωτικά τρείς (3) Θεματικές');
				jQuery('[id^="taxonomy-thema"]').find('.tabs-panel').css('background', '#F96');
				freezepane();
				return false;
			} else {
				// Η Κύρια Θεματική είναι μέσα στις Επιλεγμένες ;
				var main_cat = $('#_ma_unit_main_thema').val();
				if(jQuery.inArray(main_cat, catz) > -1){ } else {
					alert('Η Κύρια Θεματική πρέπει να είναι μια από τις επιλεγμένες.');
					jQuery('.cmb_id__ma_unit_main_thema').css('background', '#F96');
					freezepane();
					return false;
				}
			}
		  });
		
		function freezepane(){
			setTimeout("jQuery('.spinner').css('display', 'none');", 500);
			setTimeout("jQuery('#publish').removeClass('button-primary-disabled');", 500);
		};
	} );
})(jQuery)