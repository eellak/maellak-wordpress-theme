(function($){
	$(document).ready( function(){
		$('#thema-pop').remove();
		
		$('#publish').click(function(){
			var ctitle=$('#ctitle').val();
			if (!ctitle){
				alert('Το ονοματεπώνυμο είναι υποχρεωτικό');
				freezepane();
				return false;
			}

			var property=$('#property').val();
			if (!property){
				alert('Η δήλωση ιδιότητας είναι υποχρεωτική');
				freezepane();
				return false;
			}
			
			var location=$('#location').val();
			if (!location){
				alert('Η δήλωση περιοχής είναι υποχρεωτική');
				freezepane();
				return false;
			}
			
			var email=$('#email').val();
			if (!email){
				alert('Η δήλωση email είναι υποχρεωτική');
				freezepane();
				return false;
			}
			if (!validateEmail(email)){
				alert('Το email δεν είναι έγκυρο');
				freezepane();
				return false;
			}
			

		});

		function freezepane(){
			setTimeout("jQuery('.spinner').css('display', 'none');", 500);
			setTimeout("jQuery('#publish').removeClass('button-primary-disabled');", 500);
		};
		function validateEmail(email) { 
			var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			if (re.test(email))
				return true;
			else
				return false;
			//return re.test(email);
		}
	} );
	
	var count = 0;
    count=parseInt($("#experiencecounter").attr('value'));
    $(".add").click(function() {    
        count = count + 1;
        console.log(count);
        $('#here').append('<div class="container-fluid"><div class="row-fluid"><div class="span1"><label>ΤΙΤΛΟΣ</label></div><div class="span3"><input type="text" name="experience['+count+'][_ma_ellak_exp_title]" id="_ma_ellak_exp_title'+count+'"  class="required title" value="" /> </div><div class="span1"><label>ΦΟΡΕΑΣ</label></div><div class="span3"><input type="text" name="experience['+count+'][_ma_ellak_exp_entity]" id="_ma_ellak_exp_entity'+count+'"  class="required entity" value="" /> </div><div class="span1"><label>URL</label></div><div class="span3"><input type="text" name="experience['+count+'][_ma_ellak_exp_url]" id="_ma_ellak_exp_url'+count+'" value="" /> </div></div><div class="row-fluid"><div class="span1"><label>Περιγραφή</label></div><div class="span3"><textarea name="experience['+count+'][_ma_ellak_exp_desc]" id="_ma_ellak_exp_desc'+count+'" value="" rows="2" cols="5"></textarea> </div><div class="span1"><label>Από</label></div><div class="span3"><input type="text" name="experience['+count+'][_ma_ellak_exp_from]" id="_ma_ellak_exp_from'+count+'" value="" /> </div><div class="span1"><label>Έως</label></div><div class="span3"><input type="text" name="experience['+count+'][_ma_ellak_exp_to]" id="_ma_ellak_exp_to'+count+'" value="" /> </div></div><div class="row-fluid"><span class="remove btn btn-danger btn-xs"> - Αφαίρεση</span></div></div>');
        return false;
    });
    $(".remove").live('click', function() {
        $(this).parent().parent().remove();
    });
	
})(jQuery)