<?php
// 
add_action("wp_ajax_ma_ellak_request_unit_membership_action", "ma_ellak_request_unit_membership");

function ma_ellak_request_unit_membership() {
	
	if ( !wp_verify_nonce( $_POST['req_nonce'], "ma_ellak_request_unit_membership_nonce")) {
		exit("������!");
	}   

	$user_id 	=  esc_attr($_POST['req_user']);
	$unit_id 	=  esc_attr($_POST['req_unit']);
	
	$go = true;
	
	//We want to leave..
	if(isset($_POST['req_reason']) and trim($_POST['req_reason']) == 'leave'){
		delete_user_meta( $user_id, '_ma_ellak_member_unit' );
		delete_user_meta( $user_id, '_ma_ellak_member_unit_request' );
	} else
		$go = update_user_meta( $user_id, '_ma_ellak_member_unit_request',  $unit_id );
	
	//$result = array();
	if($go) {
		echo 'OK';
		//$result['error'] = 		"atrue";
		//$result['user'] =		$user_id;
		//$result['unit'] =		$unit_id;
	} else {
		echo 'ERROR';
		//$result['error'] = 		"afalse";
		//$result['user'] =		$user_id;
		//$result['unit'] =		$unit_id;
	}

    //echo json_encode($result);
	die();
}

add_action("wp_ajax_ma_ellak_register_newsletter_action", "ma_ellak_register_newsletter");
add_action('wp_ajax_nopriv_ma_ellak_register_newsletter_action', 'ma_ellak_register_newsletter');
function ma_ellak_register_newsletter() {
	
	if ( !wp_verify_nonce( $_POST['req_nonce'], "ma_ellak_register_newsletter_nonce")) {
		exit("������!");
	}   
	
	global $wpoi_submit_status;
	//wpoi_init_action();
	
	echo $wpoi_submit_status;
	die();
}

add_action("wp_ajax_ma_ellak_register_video_action", "ma_ellak_register_video");
add_action('wp_ajax_nopriv_ma_ellak_register_video_action', 'ma_ellak_register_video');

function ma_ellak_register_video() {

	if ( !wp_verify_nonce( $_POST['req_nonce'], "ajax_request_streaming_nonce")) {
		exit("Σφάλμα!");
	}
	
	$events = get_post_meta($_POST['eventid'],'eventslive',true);
	$events_keys = array_keys($events);
	if ( count( $events ) >= 0 ) {
		for($i=0;$i<count($events_keys);$i++)
		//foreach( $events as $event ) {
			if ($events[$events_keys[$i]]['_ma_ellak_event_url_title']== $_POST['eventtitle']){
				$events[$events_keys[$i]]['_ma_ellak_event_views']=$events[$events_keys[$i]]['_ma_ellak_event_views']+1;
				$counter = $events[$events_keys[$i]]['_ma_ellak_event_views'];
		}
	}
	update_post_meta($_POST['eventid'],'eventslive',$events);
	echo'<h4 class="magenta">'.$_POST['eventtitle'].'</h4>';
	echo '<iframe width="420" height="315" src="//www.youtube.com/embed/'.$_POST['video'].'?rel=0" frameborder="0" allowfullscreen></iframe>';
	echo'<p class="views-and-likes"><i class="icon-eye-open"></i> '. $counter .'</p>';
	die();
}

add_action("wp_ajax_ma_ellak_change_calendar_action", "ma_ellak_change_calendar");
add_action('wp_ajax_nopriv_ma_ellak_change_calendar_action', 'ma_ellak_change_calendar');

function ma_ellak_change_calendar() {

	if ( !wp_verify_nonce( $_POST['req_nonce'], "ma_ellak_change_calendar_nonce")) {
		exit("Σφάλμα!");
	}
	$date_request = explode('-', $_POST['date_data']);
	ma_ellak_get_calendar($date_request[1], $date_request[0]);
	
	die();
}

add_action("wp_ajax_ma_ellak_state_used_it_action", "ma_ellak_state_used_it");

function ma_ellak_state_used_it() {
	
	if ( !wp_verify_nonce( $_POST['req_nonce'], "ma_ellak_state_used_it_nonce")) {
		exit("������!");
	}   

	$user_id 	=  esc_attr($_POST['req_user']);
	$software_id 	=  esc_attr($_POST['req_software']);
	
	$go1 = true;
	$go2 = true;
	
	// Update the usage
	$current = get_post_meta( $software_id, 'software_used_by', true );
	$current++ ;
	$go1 = update_post_meta( $software_id, 'software_used_by',  $current );
	
	
	$software_voted = get_user_meta($user_id, 'all_software_used_by', true );    
	
	if(!empty($software_voted))
		$software_voted[] = $software_id ;
	else
		$software_voted = array($software_id);
		
	$go2 = update_user_meta( $user_id, 'all_software_used_by', $software_voted);
	
	if($go1 and $go2) {
		echo 'OK';
	} else {
		echo 'ERROR';
	}
	
	die();
}

add_action("wp_ajax_job_application_action", "ma_ellak_job_application");
function ma_ellak_job_application() {
	
	if ( !wp_verify_nonce( $_POST['req_nonce'], "ajax_job_application_nonce")) {
		exit("Σφάλμα!");
	}   

	$user_id 	=  esc_attr($_POST['req_user']);
	$job_id 	=  esc_attr($_POST['req_job']);
	
	$go1 = true;
	$go2 = true;
	
	// Update the application on Job-----------------------------------------
	$current = get_post_meta($job_id, '_ma_ellak_interested_users', true );    
	if(!empty($current))
		$current[] = $user_id ;
	else
		$current = array($user_id);
	
	$go1 = update_post_meta( $job_id, '_ma_ellak_interested_users',  $current );
	
	// Update the User to say he has already requested ----------------------
	$requested = get_user_meta($user_id, '_ma_ellak_all_jobs_applied', true );    
	
	if(!empty($requested))
		$requested[] = $job_id ;
	else
		$requested = array($job_id);
		
	$go2 = update_user_meta( $user_id, '_ma_ellak_all_jobs_applied', $requested);
	
	if($go1 and $go2) {
		echo 'OK';
	} else {
		echo 'ERROR';
	}
	
	die();
}


function ma_ellak_hire_job(){
	$user_applied=$_POST['user'];
	$selected_values=$_POST['list'];
	$previous_jobs=$_POST['previous'];

	if (count($unseri)>0){
		$unseri=unserialize(base64_decode($previous_jobs));
		$all_values=array_merge($selected_values, $unseri);
	}
	else
		$all_values=$selected_values;
	
	ma_ellak_job_profile_save_details($user_applied, $all_values);
	die();
}
// creating Ajax call for WordPress
add_action( 'wp_ajax_nopriv_ma_ellak_hire_job', 'ma_ellak_hire_job' );
add_action( 'wp_ajax_ma_ellak_hire_job', 'ma_ellak_hire_job' );



?>