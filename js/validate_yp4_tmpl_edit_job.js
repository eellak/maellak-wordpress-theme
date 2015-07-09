(function($){
	$(document).ready( function(){
		
		$("#ma_ellak_job_submit_form").validate({
			ignore: "",
			rules: {
				ctitle:{ required: true },
				cdescription:{ required:true },
				_ma_job_contact_point_name:{ required:true },
				_ma_job_contact_point_email:{ required:true,email:true },
				'jobtype-select[]':{ required:true },
				_ma_job_applicant_type:{ required:true },
				_ma_job_complete_comment:{ 
					required: function(element){ return $("#stage_status").val() == "done"; }
				},
				_ma_vote_user:{ 
					required: function(element){ return $("#stage_status").val() == "done"; }
				},				
				_ma_job_success:{ 
					required: function(element){ return $("#stage_status").val() == "done"; }
				}
			},
			messages: {
				ctitle:{ required: "Απαιτείται" },
				cdescription:{ required:"Απαιτείται" },
				_ma_job_contact_point_name:{ required:"Απαιτειται" },
				_ma_job_contact_point_email:{ required:"Απαιτειται",email:"Πρεπει να προσθέσετε email" },
				'jobtype-select[]':{ required:"Απαιτείται" },
				_ma_job_applicant_type:{ required:"Απαιτείται" },
				_ma_job_complete_comment:{ required:"Απαιτείται στην περίπτωση Ολοκλήρωσης!" },
				_ma_vote_user:{ required:"Απαιτείται στην περίπτωση Ολοκλήρωσης!" },
				_ma_job_success:{ required:"Απαιτείται στην περίπτωση Ολοκλήρωσης!" },
			}
		});
		
		$('#addnewtags').click(function( event){
			 event.preventDefault();
			$('#selftags').slideToggle();
		});
		
		$('#stage_status').change(function(event) {
			var valueSelected= this.value;
			if(valueSelected == 'done'){
				$('#acceptance').slideDown();
			} else {
				$('#acceptance').slideUp();
			}
		});
		
		if($("#stage_status").val() == "done"){
			$('#acceptance').slideDown();
		}
		
		$('.action-comment').click(function(){
			if(window.confirm("Είστε Σίγουρος/η ;")){
				
			} else {
				return false;
			}
		});
		
	} );
})(jQuery)