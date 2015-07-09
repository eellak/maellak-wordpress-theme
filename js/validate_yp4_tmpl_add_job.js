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
			},
			messages: {
				ctitle:{ required: "Απαιτειται" },
				cdescription:{ required:"Απαιτειται" },
				_ma_job_contact_point_name:{ required:"Απαιτειται" },
				_ma_job_contact_point_email:{ required:"Απαιτειται",email:"Πρεπει να προσθέσετε email" },
				'jobtype-select[]':{ required:"Απαιτειται" },
				_ma_job_applicant_type:{ required:"Απαιτειται" },
			}
		});
		
		$('#addnewtags').click(function( event){
			 event.preventDefault();
			$('#selftags').slideToggle();
		});
		
	} );
})(jQuery)