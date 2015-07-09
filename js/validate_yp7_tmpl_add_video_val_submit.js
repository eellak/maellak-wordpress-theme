(function($){
	$(document).ready( function(){
		$('#thema-pop').remove();
		$('#publish').click(function(){
			//validation of video title
			var video_title=$('#title').val();
			if (!video_title){
				alert('Ο τίτλος είναι υποχρεωτικός');
				freezepane();
				return false;
			}

			//validation of video_date
			var video_date=$('#_ma_video_date').val();
			if (video_date){
				var video_date_val=isValidDate(video_date);
				if (!video_date_val){
					freezepane();
					return false;
				}
			}

			//validation of video_url
			var video_url = check_videourl($('#_ma_video_url').val());
			if(!video_url){
				freezepane();
				return false;
			}
			var video_url_val=check_videourl_validity($('#_ma_video_url').val());
			if(!video_url_val){
				freezepane();
				return false;
			}

			//validation of video_duration
			var video_hours=$('#_ma_video_duration_hours').val();
			if (!check_videoduration(video_hours, 'hours')){
				freezepane();
				return false;
			}
			var video_minutes=$('#_ma_video_duration_minutes').val();
			if(!check_videoduration(video_minutes, 'minutes')){
				freezepane();
				return false;
			}		
			var video_seconds=$('#_ma_video_duration_seconds').val();
			if (!check_videoduration(video_seconds, 'seconds')){
				freezepane();
				return false;
			}

			//You are aware of what you upload
			if ($("#_ma_video_know").is(':checked')==false) {
                alert('Θα πρέπει να επιλέξετε ότι έχετε γνώση του περιεχομένου που αναρτάτε');
				freezepane();
				return false;
            }

			//Select at least one thema
			var is_admin=$('#admin').val();
			if (is_admin==0){
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
		
		function isValidDate(dateString){
			var is_false=false;
			// First check for the pattern
			if(!/^\d{2}\/\d{2}\/\d{4}$/.test(dateString))
				is_false=true;

			// Parse the date parts to integers
			var parts = dateString.split("/");
			var day = parseInt(parts[1], 10);
			var month = parseInt(parts[0], 10);
			var year = parseInt(parts[2], 10);

			// Check the ranges of month and year
			if(year < 1000 || year > 3000 || month == 0 || month > 12)
				is_false=true;

			if (day < 1 || day > 31)
				is_false=true;
			if (is_false==true){
				alert('Μη έγκυρη ημερομηνία');
				return false;
			}
			return true;
		};

		//Validation rules for video_url field
		function check_videourl(fieldval){
			if (!fieldval){
				alert('Θα πρέπει να παρέχετε σύνδεσμο για το βίντεο');
				return false;
			}
			if (fieldval.match(/\b(youtube)\.com\b/i)){
				if (!fieldval.match(/(http|https):\/\/www\.(www.youtube|youtube|[A-Za-z]{2}.youtube)\.com\/(watch\?v=|w\/\?v=)([\w-]+)(.*?)/)){
					alert('Μη έγκυρος σύνδεσμος youtube');
					return false;
				}
			}
			if (fieldval.match(/\b(vimeo)\.com\b/i)){
				if (!fieldval.match(/(http|https):\/\/(www\.)?vimeo.com\/(\d+)($|\/)/)){
					alert('Μη έγκυρος σύνδεσμος vimeo');
					return false;
				}
			}
			return true;
		}

		//check that the video is youtube or vimeo
		function check_videourl_validity(fieldval){
			if (fieldval.match(/\b(youtube)\.com\b/i) || fieldval.match(/\b(vimeo)\.com\b/i))
				return true;
			else{
				alert('Μη έγκυρος σύνδεσμος youtube ή vimeo');
				return false;
			}
		}
		//Validation rules for video duration
		function check_videoduration(fieldval, field){
			if (field=='minutes')
				msg="Λεπτά";
			else
				msg="Δευτερόλεπτα";
			if (field=='hours'){
				if (!fieldval.match(/^[0-9]*$/)){
					alert('Ώρες: Επιτρέπονται μόνο αριθμοί.');
					return false;
				}
			}
			else{
				if (!fieldval.match(/^[0-9]*$/)){
					alert(msg + ': Επιτρέπονται μόνο αριθμοί με τιμές από 0 έως 59.');
					return false;
				}
				else if (fieldval<0 || fieldval>59){
					alert(msg + ': Έγκυροι είναι οι αριθμοί από 0 έως 59.');
					return false;
				}
			}
			return true;
		}
	} );
})(jQuery)