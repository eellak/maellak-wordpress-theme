(function($){
	$(document).ready( function(){
		
		$("#ma_ellak_event_submit_form").validate({
			ignore: "",
			rules: {
				bname:{ required: true },
				_ma_event_startdate_timestamp:{ required:true },
				_ma_event_enddate_timestamp:{ required:true },
				'_ma_ellak_event_url[]': {required:true,
									 url:true},
				'thema-select[]':{ required:true },
			},
			messages: {
				titlez:{ required: "Ειναι υποχρεωτικο πεδιο." },
				_ma_event_startdate_timestamp:{ required:"Ειναι υποχρεωτικο πεδιο." },
				_ma_event_enddate_timestamp:{ required:"Ειναι υποχρεωτικο πεδιο." },
				'_ma_ellak_event_url[]':{required:" Ειναι υποχρεωτικο πεδιο.",url:"Πρέπει να είναι url"},
				'thema-select[]':{ required:"Ειναι υποχρεωτικο πεδιο." },
				
			}
		});
		$('#addnewtags').click(function( event){
			 event.preventDefault();
			$('#selftags').slideToggle();
		});
	} );


    var count = 0;
    count=parseInt($("#eventslistcounter").attr('value'));
    //alert(count);
    $(".add").click(function() {
    
        count = count + 1;
        console.log(count);
        $('#here').append('<p> <div class="row-fluid"><div class="span1"><label>ΣΥΝΔΕΣΜΟΣ	</label></div><div class="span3"><input type="text" name="eventz['+count+'][_ma_ellak_event_url]" id="_ma_ellak_event_url'+count+'"  class="required url" value="" /> </div><div class="span1"><label>ΤΙΤΛΟΣ</label> </div><div class="span3"><input type="text" name="eventz['+count+'][_ma_ellak_event_url_title]" id="_ma_ellak_event_url_title'+count+'" value="" /> <input type="hidden" name="eventz['+count+'][_ma_ellak_event_views]" id="_ma_ellak_event_views'+count+'"  class="" value="0" /></div><div class="span2"><span class="remove btn btn-danger btn-xs"> - Αφαίρεση</span></div></div></p>' );
       // $('#here').append('<p> <strong>Url </strong><input type="text" name="eventslive['+count+'][_ma_ellak_event_url]" id="_ma_ellak_event_url'+count+'"  class="required url" value="" />  -- <strong>Τίτλος</strong> <input type="text" name="eventslive['+count+'][_ma_ellak_event_url_title]" id="_ma_ellak_event_url_title'+count+'" value="" />  <input type="hidden" name="eventslive['+count+'][_ma_ellak_event_views]" id="_ma_ellak_event_views'+count+'"  class="" value="0" /><span class="remove button button-danger button-small"> - Αφαίρεση</span>' );
        return false;
    });
    $(".remove").live('click', function() {
        $(this).parent().parent().remove();
    });
    
    

})(jQuery);
