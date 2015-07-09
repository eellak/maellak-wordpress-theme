/*(function($){
	$(document).ready( function(){
		jQuery.validator.addMethod("domain", function(value, element) {
			  return this.optional(element) || /^rtsp:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?$/.test(value);
			},"Please specify the correct domain for your live streaming");
		$("#post").validate({
			ignore: "",
			rules: {
				post_title:{ required: true },
				content:{ required: true },
				'_ma_event_startdate_timestamp':{required:true},
			},
			messages: {
				post_title:{ required: "Το πεδίο είναι υποχρεωτικό" },
				content:{ required: "Το πεδίο είναι υποχρεωτικό" },
				'_ma_event_startdate_timestamp': { required: "Το πεδίο είναι υποχρεωτικό" },

			}
		});
		
	} );
})(jQuery)*/

(function($){
	$(document).ready( function(){
	
		$('#thema-pop').remove();
		
		 $('#publish').click(function(){
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
						
			// Εχουν επιλεγεί Θεματικές ;
			if(category_selected==false ) {
				alert('Επιλέξτε Υποχρεωτικά Θεματική');
				
				jQuery('[id^="taxonomy-thema"]').find('.tabs-panel').css('background', '#F96');
				freezepane();
				return false;
			} 
			var startDate = $('#_ma_event_startdate_timestamp').val();
			if(startDate==''){
				alert('Η ημερομηνία έναρξης είναι υποχρεωτική');
				jQuery('[id="_ma_event_startdate_timestamp"]').css('background', '#F96');
				freezepane();
				return false;
			}			
			var startTime = $('#_ma_event_startdate_time').val();
			if(startTime==''){
				alert('Η ώρα έναρξης είναι υποχρεωτική');
				jQuery('[id="_ma_event_startdate_time"]').css('background', '#F96');
				freezepane();
				return false;
			}
		  });
		
		function freezepane(){
			setTimeout("jQuery('.spinner').css('display', 'none');", 500);
			setTimeout("jQuery('#publish').removeClass('button-primary-disabled');", 500);
		};
	} );
})(jQuery)
