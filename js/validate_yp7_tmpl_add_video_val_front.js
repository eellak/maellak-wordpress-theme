jQuery(document).ready(function($) {
	$('#_ma_video_url').keyup(function(){
		$('#result_').html(checkInput_($('#_ma_video_url').val()))
	})
	
	$('#addnewtags').click(function( event){
		 event.preventDefault();
		$('#selftags').slideToggle();
	});
});

jQuery(document).ready(function($) {
	$('#_ma_video_duration_hours').keyup(function(){
		$('#result').html(checkInput($('#_ma_video_duration_hours').val(), 'hours'))
	})

	$('#_ma_video_duration_minutes').keyup(function(){
		$('#result_m').html(checkInput($('#_ma_video_duration_minutes').val(), 'minutes'))
	})

	$('#_ma_video_duration_seconds').keyup(function(){
		$('#result_s').html(checkInput($('#_ma_video_duration_seconds').val(), 'seconds'))
	})
});

//Validation rules for video_duration field
function checkInput_(fieldval){
	if (fieldval.match(/\b(youtube)\.com\b/i))
		if (!fieldval.match(/(http|https):\/\/www\.(www.youtube|youtube|[A-Za-z]{2}.youtube)\.com\/(watch\?v=|w\/\?v=)([\w-]+)(.*?)/))
			return '<font color=#ff0000>Ο σύνδεσμος του youtube που εισάγετε δεν είναι έγκυρος.</font>';
		else
			return ' ';
		else if (fieldval.match(/\b(vimeo)\.com\b/i))
			if (!fieldval.match(/(http|https):\/\/(www\.)?vimeo.com\/(\d+)($|\/)/))
				return '<font color=#ff0000>Ο σύνδεσμος του vimeo που εισάγετε δεν είναι έγκυρος.</font>';
			else
				return ' ';
		else if (fieldval.match(/\b(google)\.com\b/i))
			if (!fieldval.match(/(http|https):\/\/video\.google\.com\/videoplay\?docid=[^&]+/))
				return '<font color=#ff0000>Ο σύνδεσμος του google δεν είναι έγκυρος.</font>';
			else
				return ' ';
}


//Validation rules for video duration
function checkInput(fieldval, field){
	if (field=='minutes')
		msg="Λεπτά";
	else
		msg="Δευτερόλεπτα";
	if (field=='hours'){
		if (!fieldval.match(/^[0-9]*$/))
			return "<font class=error>Ώρες: Επιτρέπονται μόνο αριθμοί.</font>";
		else
			return '';
	}
	else{
		if (!fieldval.match(/^[0-9]*$/))										
			return '<font class=error>' + msg + ': Επιτρέπονται μόνο αριθμοί με τιμές από 0 έως 59.</font>';
		else if (fieldval<0 || fieldval>59)
			return '<font class=error>' + msg + ': Έγκυροι είναι οι αριθμοί από 0 έως 59.</font>';
		else
			return '';
	}
}