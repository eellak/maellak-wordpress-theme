(function($){
	$(document).ready( function(){

		jQuery.extend(jQuery.validator.messages, {
		    required: "Απαιτειται",
		});
	$("#ma_ellak_profile_submit_form").validate({
			ignore: "",
			rules: {
				comment:{ required:true },
				email:{required:true, email:true},
				ctitle:{required:true},
				url:{url:true},
				_ma_profile_type:{required:true}
				
			},
			messages: {
				comment:{ required:"Απαιτειται" },
				email:{required:'Ειναι υποχρεωτικο πεδίο', email:'Δηλωστε σωστη μορφη email'},
				ctitle:{required:'Το ονοματεπωνυμο είναι υποχρεωτικo'},
				url:{url:"Δηλώστε σωστή μορφή ιστοχώρου"},
				_ma_profile_type:{ required:"Απαιτειται" },

				
			}
		});
	} );
	
	var count = 0;
    count=parseInt($("#experiencecounter").attr('value'));
    $(".add").live('click', function() {    
        count = count + 1;
        //console.log(count);
        $('#here').append('<div class="container-fluid"><div class="row-fluid"><div class="span1"><label>ΤΙΤΛΟΣ</label></div><div class="span3"><input type="text" name="experience['+count+'][_ma_ellak_exp_title]" id="_ma_ellak_exp_title'+count+'"  class="required title" value="" /> </div><div class="span1"><label>ΦΟΡΕΑΣ</label></div><div class="span3"><input type="text" name="experience['+count+'][_ma_ellak_exp_entity]" id="_ma_ellak_exp_entity'+count+'"  class="required entity" value="" /> </div><div class="span1"><label>URL</label></div><div class="span3"><input type="text" name="experience['+count+'][_ma_ellak_exp_url]" id="_ma_ellak_exp_url'+count+'" value="" /> </div></div><div class="row-fluid"><div class="span1"><label>Περιγραφή</label></div><div class="span3"><textarea name="experience['+count+'][_ma_ellak_exp_desc]" id="_ma_ellak_exp_desc'+count+'" value="" rows="2" cols="5"></textarea> </div><div class="span1"><label>Από</label></div><div class="span3"><input type="text" name="experience['+count+'][_ma_ellak_exp_from]" id="_ma_ellak_exp_from'+count+'" value="" /> </div><div class="span1"><label>Έως</label></div><div class="span3"><input type="text" name="experience['+count+'][_ma_ellak_exp_to]" id="_ma_ellak_exp_to'+count+'" value="" /> </div></div><div class="row-fluid"><span class="remove btn btn-danger btn-xs"> - Αφαίρεση</span></div></div>');
        return false;
    });
    $(".remove").live('click', function() {
        $(this).parent().parent().remove();
    });
	
})(jQuery)