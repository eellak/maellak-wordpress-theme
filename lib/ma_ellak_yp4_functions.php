<?php
/**
* Αρχείο συναρτήσεων για την Υπηρεσία 4.
*
* @licence GPL
* @author Fotis Routsis - fotis@routsis.gr
* 
* Project URL http://ma.ellak.gr
*/

// Εγγραφή του Σύνθετου Τύπου Προσφορά (job) [1/2]
add_action( 'init', 'ma_ellak_register_job_posttype', 0 );

// Εγγραφή του Σύνθετου Τύπου Προσφορά (job) [2/2]
function ma_ellak_register_job_posttype() {
	$labels = array(
		'name' 					=> _x( 'Προσφορά', 'γενικό όνομα', 'ma-ellak' ),
		'singular_name' 		=> _x( 'Προσφορά', 'γενικό όνομα', 'ma-ellak' ),
		'add_new' 				=> _x( 'Προσθήκη Προσφοράς', 'Γνωρίσματος', 'ma-ellak' ),
		'add_new_item'			=> __( 'Προσθήκη Προσφοράς', 'ma-ellak' ),
		'edit_item' 			=> __( 'Επεξεργασία Προσφοράς', 'ma-ellak' ),
		'new_item' 				=> __( 'Νέα Προσφορά', 'ma-ellak' ),
		'all_items' 			=> __( 'Όλες οι Προσφορές', 'ma-ellak' ),
		'view_item' 			=> __( 'Προβολή Προσφοράς', 'ma-ellak' ),
		'search_items' 			=> __( 'Αναζήτηση Προσφοράς', 'ma-ellak' ),
		'not_found' 			=> __( 'Δεν εντοπίστηκε', 'ma-ellak' ),
		'not_found_in_trash' 	=> __( 'Δεν εντοπίστηκε στον Κάδο', 'ma-ellak' ),
		'parent_item_colon' 	=> '',
	);

	$args = array(
		'labels' 				=> $labels,
		'public' 				=> true,
		'publicly_queryable' 	=> true,
		'show_ui' 				=> true,
		'can_export'			=> true,
		'show_in_nav_menus'		=> false,
		'query_var' 			=> true,
		'has_archive' 			=> true,
		'rewrite' 				=> array( 'slug' => 'job', 'with_front' => true, 'feeds' => true ) ,
		'capability_type' 		=> 'post',
		'hierarchical' 			=> false,
		'menu_position' 		=> null,
		'supports' 				=> array( 'title', 'author', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions', 'custom-fields' ),
		'taxonomies' 			=> array('post_tag')
	);

	register_post_type( 'job' , $args  );
	
	$labels = array(
		'name' 					=> _x( 'Προφίλ', 'γενικό όνομα', 'ma-ellak' ),
		'singular_name' 		=> _x( 'Προφίλ', 'γενικό όνομα', 'ma-ellak' ),
		'add_new' 				=> _x( 'Προσθήκη Προφίλ', 'Γνωρίσματος', 'ma-ellak' ),
		'add_new_item'			=> __( 'Προσθήκη Προφίλ', 'ma-ellak' ),
		'edit_item' 			=> __( 'Επεξεργασία Προφίλ', 'ma-ellak' ),
		'new_item' 				=> __( 'Νέο Προφίλ', 'ma-ellak' ),
		'all_items' 			=> __( 'Όλα τα Προφίλ', 'ma-ellak' ),
		'view_item' 			=> __( 'Προβολή Προφίλ', 'ma-ellak' ),
		'search_items' 			=> __( 'Αναζήτηση Προφίλ', 'ma-ellak' ),
		'not_found' 			=> __( 'Δεν εντοπίστηκε', 'ma-ellak' ),
		'not_found_in_trash' 	=> __( 'Δεν εντοπίστηκε στον Κάδο', 'ma-ellak' ),
		'parent_item_colon' 	=> '',
	);

	$args = array(
		'labels' 				=> $labels,
		'public' 				=> true,
		'publicly_queryable' 	=> true,
		'show_ui' 				=> true,
		'can_export'			=> true,
		'show_in_nav_menus'		=> false,
		'query_var' 			=> true,
		'has_archive' 			=> true,
		'rewrite' 				=> array( 'slug' => 'profile', 'with_front' => true, 'feeds' => true ) ,
		'capability_type' 		=> 'post',
		'hierarchical' 			=> false,
		'menu_position' 		=> null,
		'supports' 				=> array( 'title', 'author', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions', 'custom-fields' ),
		'taxonomies' 			=> array('post_tag')
	);

	register_post_type( 'profile' , $args  );
	
	$labels = array(
		'name' 				=> _x( 'Είδος Εργασίας', 'γενικό όνομα', 'ma-ellak' ),
		'singular_name' 	=> _x( 'Είδος Εργασίας', 'γενικό όνομα', 'ma-ellak' ),
		'search_items' 		=>  __( 'Αναζήτηση Εργασίας', 'ma-ellak' ),
		'all_items' 		=> __( 'Όλες οι Εργασίας', 'ma-ellak' ),
		'parent_item' 		=> __( 'Γονική Εργασίας', 'ma-ellak' ),
		'parent_item_colon' => __( 'Γονική Εργασίας:', 'ma-ellak' ),
		'edit_item' 		=> __( 'Επεξεργασία Εργασίας', 'ma-ellak' ),
		'update_item' 		=> __( 'Ενημέρωση Εργασίας', 'ma-ellak' ),
		'add_new_item' 		=> __( 'Προσθήκη Εργασίας', 'ma-ellak' ),
		'new_item_name' 	=> __( 'Προσθήκη Εργασίας', 'ma-ellak' ),
		'menu_name' 		=> __( 'Είδη Εργασίας', 'ma-ellak' ),
	);

	register_taxonomy( 'jobtype', array( 'job', 'profile' ), array(
		'hierarchical' 	=> true,
		'labels' 		=> $labels,
		'show_ui' 		=> true,
		'query_var' 	=> true,
		'rewrite' 		=> array( 'slug' => 'jobtype', 'with_front' => true, 'feeds' => true ) ,
	) );
}

global $ma_prefix ;
global $job_fields ; 
global $profile_fields ;
global $social_fields;

$job_fields =  array(
			array(
				'name' => __('Θέλω', 'ma-ellak'),
				'desc' => __('Επαγγελματία/Εθελοντή', 'ma-ellak'),
				'id'   => $ma_prefix . 'job_applicant_type',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Επαγγελματία', 'ma-ellak'), 'value' => 'professional', ),
					array( 'name' => __('Εθελοντή', 'ma-ellak'), 'value' => 'volunteer', ),
					array( 'name' => __('Αδιάφορο', 'ma-ellak'), 'value' => 'nomatter', ),
				),
			),
			
			array(
				'name' => __('Στοιχεία Υπευθύνου - Ονοματεπώνυμο', 'ma-ellak'),
				'desc' => __('Στοιχεία Υπευθύνου Επικοινωνίας για την Προσφορά.', 'ma-ellak'),
				'id'   => $ma_prefix . 'job_contact_point_name',
				'type' => 'text',
			),
			array(
					'name' => __('Στοιχεία Υπευθύνου - email', 'ma-ellak'),
					'desc' => __('Στοιχεία Υπευθύνου Επικοινωνίας για την Προσφορά.', 'ma-ellak'),
					'id'   => $ma_prefix . 'job_contact_point_email',
					'type' => 'text',
			),
			array(
					'name' => __('Στοιχεία Υπευθύνου - Φορέας', 'ma-ellak'),
					'desc' => __('Στοιχεία Υπευθύνου Επικοινωνίας για την Προσφορά.', 'ma-ellak'),
					'id'   => $ma_prefix . 'job_contact_point_foreas',
					'type' => 'text',
			),
			array(
					'name' => __('Στοιχεία Υπευθύνου - Τηλέφωνο', 'ma-ellak'),
					'desc' => __('Στοιχεία Υπευθύνου Επικοινωνίας για την Προσφορά.', 'ma-ellak'),
					'id'   => $ma_prefix . 'job_contact_point_phone',
					'type' => 'text',
			),
		
			array(
				'name' => __('Κατάσταση', 'ma-ellak'),
				'desc' => __('Η κατάσταση του Εργασίας', 'ma-ellak'),
				'id'   => $ma_prefix . 'job_status',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Ενεργή', 'ma-ellak'), 'value' => 'active', ),
					array( 'name' => __('Σε εξέλιξη', 'ma-ellak'), 'value' => 'processed', ),
					array( 'name' => __('Ολοκληρωμένη', 'ma-ellak'), 'value' => 'done', ),
					array( 'name' => __('Μη Ενεργή', 'ma-ellak'), 'value' => 'inactive', ),
				),
			),
			array(
				'name' => __('Επιτυχής Εργασία', 'ma-ellak'),
				'desc' => __('Η επιτυχία ή όχι Εργασίας', 'ma-ellak'),
				'id'   => $ma_prefix . 'job_success',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Ναι', 'ma-ellak'), 'value' => 'yes', ),
					array( 'name' => __('Όχι', 'ma-ellak'), 'value' => 'no', ),
				),
			),
			
			array(
				'name' => __('Αξιολόγηση Αναδόχου', 'ma-ellak'),
				'desc' => __('Αξιολογήστε τον Επαγγελματία/Εθελοντή', 'ma-ellak'),
				'id'   => $ma_prefix . 'accepted_user_vote',
				'type'    => 'select',
				'options' => array(
					array( 'name' => '0', 'value' => '0', ),
					array( 'name' => '1', 'value' => '1', ),
					array( 'name' => '2', 'value' => '2', ),
					array( 'name' => '3', 'value' => '3', ),
					array( 'name' => '4', 'value' => '4', ),
					array( 'name' => '5', 'value' => '5', ),
				),
			),
			
			array(
				'name' => __('Περιγραφή Ολοκλήρωσης Εργασίας', 'ma-ellak'),
				'desc' => __('Σύντομη Περιγραφή μετά την Ολοκλήρωση της Εργασίας', 'ma-ellak'),
				'id'   => $ma_prefix . 'job_complete_comment',
				'type' => 'textarea',
			),
			
			array(
				'name' => __('Ημερομηνία Λήξης', 'ma-ellak'),
				'desc' => __('Ημερομηνία Λήξης της Προσφοράς', 'ma-ellak'),
				'id'   => $ma_prefix . 'job_expiration',
				'type' => 'text_date_timestamp',
			),
			
			
		);

$profile_fields =  array(
	array(
				'name' => __('Είδος παρεχόμενης υπηρεσίας ', 'ma-ellak'),
				'desc' => __('Παρέχω Υπηρεσίες ως Επαγγελματίας ή Εθελοντής ;', 'ma-ellak'),
				'id'   => $ma_prefix . 'profile_type',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Εγγυημένη', 'ma-ellak'), 'value' => 'professional', ),
					array( 'name' => __('Εθελοντική', 'ma-ellak'), 'value' => 'volunteer', ),
				),
	),
	array(
		'name' => __('Κόστος Ανθρωποώρας', 'ma-ellak'),
		'id'   => $ma_prefix . 'hourly_rate',
		'type' => 'text',
	),
	array(
		'name' => __('Περιγραφή παρεχόμενης υπηρεσίας', 'ma-ellak'),
		'id'   => $ma_prefix . 'service_desc',
		'type' => 'textarea',
	),
);

$social_fields=array(
	array(
		'name' => __('Facebook', 'ma-ellak'),
		'id'   => $ma_prefix . 'profile_facebook',
		'type' => 'text',
	),
	array(
		'name' => __('Twitter', 'ma-ellak'),
		'id'   => $ma_prefix . 'profile_twitter',
		'type' => 'text',
	),
	array(
		'name' => __('Linkedin', 'ma-ellak'),
		'id'   => $ma_prefix . 'profile_linkedin',
		'type' => 'text',
	),
);

$personal_fields=array(
	array(
		'name' => __('Ιδιότητα', 'ma-ellak'),
		'id'   => $ma_prefix . 'profile_property',
		'type' => 'text',
	),
	array(
		'name' => __('Περιοχή δραστηριότητας', 'ma-ellak'),
		'id'   => $ma_prefix . 'profile_location',
		'type' => 'text',
	),
	array(
		'name' => __('Προσωπικός ιστοχώρος', 'ma-ellak'),
		'id'   => $ma_prefix . 'profile_url',
		'type' => 'text',
	),
	array(
		'name' => __('Τηλέφωνο επικοινωνίας', 'ma-ellak'),
		'id'   => $ma_prefix . 'profile_phone',
		'type' => 'text',
	),
	array(
		'name' => __('E-mail', 'ma-ellak'),
		'id'   => $ma_prefix . 'profile_email',
		'type' => 'text',
	),
	array(
		'name' => __('Όνομα χρήστη', 'ma-ellak'),
		'id'   => $ma_prefix . 'profile_username',
		'type' => 'text',
	),
	array(
		'name' => __('Φωτογραφία', 'ma-ellak'),
		'id'   => $ma_prefix . 'profile_photo',
		'type' => 'file',
	),
);

// Δηλώνουμε την εμφάνιση του metabox για τον τύπο αντικειμένου Προσφορά [1/2]
add_filter( 'cmb_meta_boxes', 'ma_ellak_job_metabox' );

//Δηλώνουμε την εμφάνιση του metabox για τον τύπο αντικειμένου Προσφορά [2/2]
function ma_ellak_job_metabox( array $meta_boxes ) {

	global $job_fields; 
	global $profile_fields;
	global $social_fields;
	global $personal_fields;

	$all_fields=array_merge($profile_fields, $social_fields, $personal_fields);
	$meta_boxes[] = array(
		'id'         => 'job_metabox',
		'title'      => __('Προσφορά', 'ma-ellak'),
		'pages'      => array( 'job'), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => $job_fields,
	);

	$meta_boxes[] = array(
		'id'         => 'profile_metabox',
		'title'      => __('Προφίλ', 'ma-ellak'),
		'pages'      => array( 'profile'), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => $all_fields,
	);

	return $meta_boxes;
}

// Αρχικοποιεί εφόσον δεν έχει γίνει ήδη τη βιβλιοθήκη των MetaBoxes [1/2]
add_action( 'init', 'ma_ellak_yp4_meta_boxes', 9999 );

// Αρχικοποιεί εφόσον δεν έχει γίνει ήδη τη βιβλιοθήκη των MetaBoxes [2/2]
function ma_ellak_yp4_meta_boxes() {
	if ( ! class_exists( 'cmb_Meta_Box' ) ) require_once (TEMPLATEPATH . '/scripts/metabox/init.php');
}

// Προσθέτει javascripts και css styles [1/2]
function ma_ellak_yp4_scripts() {
	$template_dir =  get_bloginfo('template_directory');

	if (is_page_template('ma_ellak_yp4_tmpl_add_job.php') or is_page_template('ma_ellak_yp4_tmpl_edit_job.php') or 
		is_page_template('ma_ellak_yp4_tmpl_add_profile.php') or is_page_template('ma_ellak_yp4_tmpl_edit_profile.php')) {
		wp_enqueue_style( 'ma_ellak_chosen_css', $template_dir . '/scripts/tagselect/chosen/chosen.css' );
		wp_enqueue_style( 'ma_ellak_tagselect_css',  $template_dir . '/scripts/tagselect/tagselect.css');
			
		wp_enqueue_script( 'ma_ellak_chosen_js', $template_dir . '/scripts/tagselect/chosen/chosen.jquery.min.js', array('jquery'), '1.0', true );
		wp_enqueue_script( 'ma_ellak_tagselect_js',  $template_dir . '/scripts/tagselect/tagselect.js',  array('jquery'), '1.0', true );
		// From init.php
		 $cmb_script_array = array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker', 'media-upload', 'thickbox' );
		 $cmb_style_array = array( 'thickbox' );
		wp_enqueue_script( 'cmb-timepicker', CMB_META_BOX_URL . 'js/jquery.timePicker.min.js', true );
		wp_enqueue_script( 'cmb-scripts', CMB_META_BOX_URL . 'js/cmb.js', $cmb_script_array, '1.0', true );
		wp_enqueue_style( 'cmb-styles', CMB_META_BOX_URL . 'style.css', $cmb_style_array );
		wp_enqueue_script( 'ma_ellak_validate',  $template_dir . '/js/jquery.validate.min.js',  array('jquery'), '1.0', true );
	}
	if ( is_page_template('ma_ellak_yp4_tmpl_add_job.php')) {
		wp_enqueue_script( 'ma_ellak_validate_yp4_job',  $template_dir . '/js/validate_yp4_tmpl_add_job.js',  array('jquery'), '1.0', true );
	}
	if ( is_page_template('ma_ellak_yp4_tmpl_add_profile.php') or is_page_template('ma_ellak_yp4_tmpl_edit_profile.php')) {
		wp_enqueue_script( 'validate_yp4_tmpl_add_profile',  $template_dir . '/js/validate_yp4_tmpl_add_front_profil.js',  array('jquery'), '1.0', true );
		wp_enqueue_script( 'validate_yp4_tmpl_add_submit_profile',  $template_dir . '/js/validate_yp4_tmpl_profile_val_submit.js',  array('jquery'), '1.0', true );
	}
	if ( is_page_template('ma_ellak_yp4_tmpl_edit_job.php') ) {
		wp_enqueue_script( 'ma_ellak_validate_yp4_job_edit',  $template_dir . '/js/validate_yp4_tmpl_edit_job.js',  array('jquery'), '1.0', true );
	}
	
	if ( is_page_template('ma_ellak_yp4_tmpl_hire.php') ) {
		wp_enqueue_script( 'ajax_yp4_hire_job', $template_dir . '/js/ajax_yp4_hire_job.js', array( 'jquery' ), '1.0', true );
		wp_localize_script( 'ajax_yp4_hire_job', 'ajax_request_hire_settings', array(
			'ajax_url' => admin_url( 'admin-ajax.php' )
		) );
	}
	
	global $post;
	if(get_post_type($post->ID) == 'job'){
		wp_enqueue_script( 'ajax_job_application', $template_dir . '/js/ajax_yp4_job_application.js', array( 'jquery' ), '1.0', true );
		wp_localize_script( 'ajax_job_application', 'ajax_job_application_settings', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'req_nonce' => wp_create_nonce("ajax_job_application_nonce"),
			'success_msg' => __('Η αίτησή σας καταχωρήθηκε!', 'ma-ellak'),
			'error_msg' => __('Προέκυψε σφάλμα!', 'ma-ellak'),
		) );
	}
	if(get_post_type($post->ID) == 'profile'){
		wp_enqueue_script( 'ma_ellak_single_yp4',  $template_dir . '/js/validate_yp4_tmpl_list_profil.js',  array('jquery'), '1.0', true );
	}
}

// Προσθέτει javascripts και css styles [2/2]
add_action( 'wp_enqueue_scripts', 'ma_ellak_yp4_scripts', 11 );

function ma_ellak_job_profile_save_details($user_id, $jobs_hire){
	global $ma_prefix;

	for($i=0; $i<count($jobs_hire); $i++){
		update_post_meta( $jobs_hire[$i], $ma_prefix . 'job_status', 'processed');
		update_post_meta( $jobs_hire[$i], '_ma_ellak_accepted_user', $user_id);
	}
	update_user_meta( $user_id, '_ma_ellak_all_jobs_selected', $jobs_hire);
}

// Αποθηκεύει τα έξτρα πεδία (post meta) απο τη φόρμα front-end υποβολής
function ma_ellak_job_save_details( $post_id ){
	
	global $ma_prefix ; 
	
	global $job_fields;
	foreach($job_fields as $field){		
		if ( isset( $_POST[$field['id']]) )
			update_post_meta( $post_id, $field['id'],  $_POST[$field['id']] );
	}
	
	$unit_id =  ma_ellak_get_unit_id();
		if( $unit_id != 0)
			update_post_meta( $post_id, '_ma_ellak_belongs_to_unit',$unit_id );
}


function ma_ellak_profile_save_details( $post_id ){
	global $ma_prefix;
	global $profile_fields;
	global $social_fields;

	foreach($profile_fields as $field){
		if ( isset( $_POST[$field['id']]) )
			update_post_meta( $post_id, $field['id'],  $_POST[$field['id']] );
	}

	foreach($social_fields as $field){
		if ( isset( $_POST[$field['id']]) )
			update_post_meta( $post_id, $field['id'],  $_POST[$field['id']] );
	}

	$unit_id =  ma_ellak_get_unit_id();
	if( $unit_id != 0)
		update_post_meta( $post_id, '_ma_ellak_belongs_to_unit',$unit_id );

	if ( isset( $_POST['property'] ) )
		update_post_meta( $post_id, $ma_prefix.'profile_property',  $_POST['property'] );
	else
		delete_post_meta( $post_id, $maprefix.'profile_property' );

	if ( isset( $_POST['location'] ) )
		update_post_meta( $post_id, $ma_prefix.'profile_location',  $_POST['location'] );
	else
		delete_post_meta( $post_id, $ma_prefix.'profile_location' );

	if ( isset( $_POST['url'] ) )
		update_post_meta( $post_id, $ma_prefix.'profile_url',  $_POST['url'] );
	else
		delete_post_meta( $post_id, $ma_prefix.'profile_url' );
	
	if ( isset( $_POST['phone'] ) )
		update_post_meta( $post_id, $ma_prefix.'profile_phone',  $_POST['phone'] );
	else
		delete_post_meta( $post_id, $ma_prefix.'profile_phone' );

	if ( isset( $_POST['email'] ) )
		update_post_meta( $post_id, $ma_prefix.'profile_email',  $_POST['email'] );
	else
		delete_post_meta( $post_id, $ma_prefix.'profile_email' );

	if ( isset( $_POST['username'] ) )
		update_post_meta( $post_id, $ma_prefix.'profile_username',  $_POST['username'] );
	else
		delete_post_meta( $post_id, $ma_prefix.'profile_username' );

	if ( isset( $_POST['characteristic_type'] ) )
		update_post_meta( $post_id, $ma_prefix.'profile_characteristic_type',  $_POST['characteristic_type'] );
	else
		delete_post_meta( $post_id, $ma_prefix.'profile_characteristic_type' );

	if ( isset( $_POST['logo'] ) )
		update_post_meta( $post_id, $ma_prefix.'profile_logo',  $_POST['logo'] );
	else
		delete_post_meta( $post_id, $ma_prefix.'profile_logo' );

	if(isset($_POST['experience']) && $_POST['experience']!=''){
		update_post_meta( $post_id, '_ma_ellak_profile_experience',  $_POST['experience'] );
	}	
	else
		delete_post_meta( $post_id, '_ma_ellak_profile_experience' );
}

function get_job_status_name($status){
	
	$details = '<span class="'.$status.'">';
	if($status == 'active') $details .= __('Ενεργή', 'ma-ellak'); 
	if($status == 'processed') $details .= __('Σε εξέλιξη', 'ma-ellak'); 
	if($status == 'done') $details .= __('Ολοκληρωμένη', 'ma-ellak');
	if($status == 'inactive') $details .= __('Μη Ενεργή', 'ma-ellak');
	$details .='</span>';
	return $details ;
}

function user_has_profile($user_id = 0){
	if($user_id == 0){
		$cur_user = wp_get_current_user();
		$user_id = $cur_user->ID;
	}
	$args = array(
		'post_per_page' => 1,
		'post_type' => 'profile',
		'post_status' => 'publish', 
		'author' => $user_id
	); 
	$profiles = get_posts($args);
	if(count($profiles) > 0)
		return true;
	return false;
}

function user_has_applied_for($user_id, $job_id){
	$requested = get_user_meta($user_id, '_ma_ellak_all_jobs_applied', true );
	if(!empty($requested)){
		if(in_array($job_id,$requested ))
			return true;
	}
	return false;
}

function user_can_apply_for($user_id, $job_id){
	global $ma_prefix ;
	$type = get_post_meta( $job_id, $ma_prefix . 'job_applicant_type', true);
	
	$args = array(
		'post_per_page' => 1,
		'post_type' => 'profile',
		'post_status' => 'publish', 
		'author' => $user_id
	); 
	$profiles = get_posts($args);
	
	if(count($profiles) > 0){
		foreach($profiles as $profile){
			$user_type = get_post_meta( $profile->ID, $ma_prefix . 'user_applicant_type', true);
		}
	} else { return false; }
	$user_type  = 'volunteer';
	if($type =='nomatter' or $type == $user_type)
		return true;

	return false;
}


function job_keyword_search( $where, &$wp_query ){
    global $wpdb;

	$where .= ' AND (' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( like_escape( $_GET['keyword'] ) ) . '%\'';
	$where .= ' OR ' . $wpdb->posts . '.post_content LIKE \'%' . esc_sql( like_escape( $_GET['keyword'] ) ) . '%\')';

	return $where;
}

function get_job_stats(){
	$stats = array(
		'all' => 0,
		'active' => 0,
		'processed' => 0,
		'done' => 0,
		'inactive' => 0,
	);
	
	$args = array(
		'post_per_page' => -1,
		'post_type' => 'job',
		'post_status' => 'publish'
	);

	$posts = get_posts($args);
	$stats['all'] = count($posts);
	global $ma_prefix;
	
	foreach($posts as $post){
		$job_status = get_post_meta($post->ID, $ma_prefix . 'job_status', true);
		if(array_key_exists($job_status, $stats))
			$stats[$job_status] = $stats[$job_status] +1 ;
		else
			$stats[$job_status] =  1;
	}
	
	return $stats;
}

/*************************EXPERIENCE**********************/
add_action( 'add_meta_boxes', 'ma_ellak_yp4_experience' );
/* Do something with the data entered */
add_action( 'save_post', 'ma_ellak_yp4_experience_save_postdata' );

function ma_ellak_yp4_experience() {
	add_meta_box(
		'_ma_ellak_profile_experience',
		__( 'Εμπειρία', 'ma-ellak' ),
		'ma_ellak_yp4_exp_inner_custom_box',
		'profile',
		'normal',//The part of the page where the edit screen section should be shown ('normal', 'advanced', or 'side'). 
      	'high' //The priority within the context where the boxes should show ('high', 'core', 'default' or 'low')
	);
}

/* Prints the box content */
function ma_ellak_yp4_exp_inner_custom_box() {
	global $post;
	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), 'dynamicMeta_noncename' );
	$meta = get_post_meta(get_the_ID());?>
	<div id="meta_inner"></div>

	<span class="add button button-primary button-small"><?php _e('Προσθήκη Εμπειρίας','ma-ellak'); ?></span>
	<?php
	//get the saved meta as an array
	$experience = get_post_meta($post->ID,'_ma_ellak_profile_experience',true);
	$c = 0;
	if($experience)
	 if ( count( $experience ) >= 0 ) {
	 	foreach( $experience as $exp ) {
	 		
	 		if ( isset( $exp['_ma_ellak_exp_title'] ) ) {
	 			printf( '<p><strong>Τίτλος</strong> <input type="text" name="experience[%1$s][_ma_ellak_exp_title]" id="_ma_ellak_exp_title%1$s"  value="%2$s" /> <strong>Φορέας</strong> <input type="text" name="experience[%1$s][_ma_ellak_exp_entity]" id="_ma_ellak_exp_entity%1$s"  value="%3$s" /> <strong>Url</strong> <input type="text" name="experience[%1$s][_ma_ellak_exp_url]" value="%4$s" id="_ma_ellak_exp_url%1$s" /> <br><strong>Περιγραφή</strong> <textarea name="experience[%1$s][_ma_ellak_exp_desc]" id="_ma_ellak_exp_desc%1$s" rows="2" cols="5">%5$s</textarea> <strong>Από</strong> <input type="text-date" name="experience[%1$s][_ma_ellak_exp_from]" id="_ma_ellak_exp_from%1$s"  value="%6$s" /> <strong>Έως</strong> <input type="text-date" name="experience[%1$s][_ma_ellak_exp_to]" id="_ma_ellak_exp_to%1$s"  value="%7$s" /> <span class="remove">%8$s</span></p>', $c, $exp['_ma_ellak_exp_title'], $exp['_ma_ellak_exp_entity'], $exp['_ma_ellak_exp_url'], $exp['_ma_ellak_exp_desc'], $exp['_ma_ellak_exp_from'],$exp['_ma_ellak_exp_to'],"<span class='button button-warning button-small'>".__( ' - Αφαίρεση','ma-ellak' )."</span>" );
	 			$c = $c +1;
	 		}
	 	}
	 }

	$template_dir =  get_bloginfo('template_directory');
	wp_enqueue_script( 'ma_ellak_chosen_js', $template_dir . '/scripts/tagselect/chosen/chosen.jquery.min.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'ma_ellak_validate',  $template_dir . '/js/jquery.validate.min.js',  array('jquery'), '1.0', true );
	wp_register_script( 'cmb-scripts', $template_dir .'/scripts/metabox/js/cmb.js', 'jquery-ui-datepicker', '0.9.1' );
	wp_enqueue_script( 'cmb-scripts' );
	?>
	 <!--------------ADD THE PART EXPERIENCE------------->
	 <span id="here"></span>
	 <script>
	     var $ =jQuery.noConflict();
	     $(document).ready(function() {
	         var count = <?php echo $c; ?>;
	         $(".add").click(function() {
	             count = count + 1;
	             $('#here').append('<p><strong>Τίτλος</strong><input type="text" name="experience['+count+'][_ma_ellak_exp_title]" id="_ma_ellak_exp_title'+count+'"  class="required title" value="" /> <strong>Φορέας</strong><input type="text" name="experience['+count+'][_ma_ellak_exp_entity]" id="_ma_ellak_exp_entity'+count+'"  class="required entity" value="" /> <strong>Url </strong><input type="text" name="experience['+count+'][_ma_ellak_exp_url]" id="_ma_ellak_exp_url'+count+'" value="" /> <br><strong>Περιγραφή</strong><textarea name="experience['+count+'][_ma_ellak_exp_desc]" id="_ma_ellak_exp_desc'+count+'" value="" rows="2" cols="5"/>  <strong>Από</strong><input type="text-date" name="experience['+count+'][_ma_ellak_exp_from]" id="_ma_ellak_exp_from'+count+'"  class="required from date" value="" /> <strong>Έως</strong><input type="text-date" name="experience['+count+'][_ma_ellak_exp_to]" id="_ma_ellak_exp_to'+count+'"  class="required to date" value="" /> <span class="remove button button-danger button-small"> Αφαίρεση</span>' );
				 return false; 
	         });
	         $(".remove").live('click', function() {
	             $(this).parent().remove();
	         });
	       });
	     </script>
	 <?php
	 }
	 
/* When the post is saved, saves our custom data */
function ma_ellak_yp4_experience_save_postdata( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return;
	 
	if ( !isset( $_POST['dynamicMeta_noncename'] ) )
		return;
	 
	if ( !wp_verify_nonce( $_POST['dynamicMeta_noncename'], plugin_basename( __FILE__ ) ) )
		return;

	//$experience = $_POST['_ma_ellak_profile_experience'];
	if (isset($_POST['experience']) && $_POST['experience']!=''){
		$experience = $_POST['experience'];
		update_post_meta($post_id,'_ma_ellak_profile_experience',$experience);
	}
	else
		delete_post_meta( $post_id, '_ma_ellak_profile_experience' );
}

/**************PRESENTATION FUNCTIONS********************/

//Επιστρέφει το αποτέλεσμα ενός query
function ma_ellak_yp4_get_results($args){
	global $wpdb;
	$wp_query=null;
	$wp_query = new WP_Query( $args );
	return $wp_query;
}

// Δημιουργία του query για τη λίστα των profiles σε κατάσταση "προσχέδιο" ή "δημοσιευμένο"
// Είσοδος: $limit ο χρήστης μπορεί να περιορίσει τα αποτελέσματα που θα του επιστραφούν, εάν η τιμή είναι -1 επιστρέφονται όλα τα αποτελέσματα
function ma_ellak_profile_get_list_query($limit){
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$args = array (
		'post_type' => 'profile',
		'post_status'=>'publish',
		'paged' => $paged,
		'posts_per_page' => $limit,
		'ignore_sticky_posts'=> 1,
		'orderby' => 'post_date',
		'order' =>  'ASC'
	);
	return $args;
}

//Εκτυπώνει τη λίστα με τα προφίλ
// 1. $limit το όριο των αποτελεσμάτων ανά σελίδα
function ma_ellak_profile_get_list_page($limit){
	$args=ma_ellak_profile_get_list_query($limit);
	$wp_query=ma_ellak_yp4_get_results($args);

	if ($wp_query->found_posts>0)
		profile_list_page($wp_query);
	else
		_e('Δεν έχουν καταχωρηθεί ακόμη προφίλ στην πλατφόρμα.', 'ma_ellak');

	if ($wp_query->found_posts>$limit)
		pagination(false, false, $wp_query);
	//echo social_output();
}

// Εκτυπώνει τη λίστα με τα προφίλ με βάση τα αποτελέσματα που επιστρέφονται από κάποιο query
// Είσοδος:
// 1. $wp_query ο πίνακας των αποτελεσμάτων που επιστρέφονται από κάποιο query
function profile_list_page($wp_query,$type='all'){
?>
	<?php
	if ( $wp_query->have_posts() ) :
		$count=0;
		while ( $wp_query->have_posts() ) : $wp_query->the_post();
			$count++;
			$post_id=get_the_ID();
			$meta=get_post_meta($post_id);
			$logo=$meta['_ma_profile_logo'][0];
			$link=get_permalink();
			
			$post_data=get_post($post_id);
			$name=$post_data->post_title;
			$description=$post_data->post_content;

			$link=get_permalink();
			$status=$post_data->post_status;
			$property=$post_data->_ma_profile_property;
			
			?>
				<div class="row-fluid event">
					<div class="cols">
					<?php if($type=='search'){?>
						<div class="span4 col">
					<?php }else{?>
						<div class="span3 col">
					<?php }?>
					
							<div class="boxed-in text-center the-date">
								<p class="magenta">
									<?php 
										if ($logo!=""){
											$thumbnail=get_profile_logo($logo);
											echo "<img src=\"". $thumbnail ."\" alt=\"".$name."\" title=\"".$name."\">";
										}
										else
											echo"<img src=\"". get_template_directory_uri() ."/images/profile.jpg\" alt=\"profile\" width=\"150\" height=\"150\"/>";
									?>
								</p>
							</div>
						</div><!-- span4 col -->
					<?php if($type=='search'){?>
						<div class="span8 col">
					<?php }else{?>
						<div class="span9 col">
					<?php }?>
								<h3><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php echo $name;?>" class="btn btn-large btn-link"><?php echo $name;?></a></h3>
								<?php
									if ($property!='')
								?>
								<strong class="magenta"><?php _e('ΙΔΙΟΤΗΤΑ: ', 'ma-ellak');?></strong><?php echo $property; ?><br>
								<?php
									if ($description!=''){
										//echo html_entity_decode($description);
										if($type=='search')
										$description=substr($description, 0, 800);
										else 
										$description=substr($description, 0, 1000);
										$description.="...";
										echo html_entity_decode($description);
									}
									ma_ellak_social_print_data ($post_id, 'profile', 'list');
								?>
							</div><!-- span8 text col -->
						</div><!-- cols -->
				</div>
	
	<?php
	endwhile;
	endif;
	wp_reset_query();
}

// Δημιουργία του query για τα πιο δημοφιλή προφίλ
// Είσοδος: $limit ο χρήστης μπορεί να περιορίσει τα αποτελέσματα που θα του επιστραφούν, εάν η τιμή είναι -1 επιστρέφονται όλα τα αποτελέσματα
function ma_ellak_profile_get_popular_query($limit){
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$args = array(
        'post_type' => 'profile',
		'paged' => $paged,
		'posts_per_page' => $limit,
		'ignore_sticky_posts'=> 1,
        'post_status' => 'publish',
        'meta_key' => 'ratings_average',
        'orderby' => 'meta_value',
        'order' => 'DESC',
        'meta_query' => array(
			'relation' => 'AND',
			array(
				'key' => 'ratings_average',
				'compare' => '='
			)
		)
	);
	return $args;
}

// Δημιουργία του query για τα πιο ενεργά προφίλ
// Είσοδος: $limit ο χρήστης μπορεί να περιορίσει τα αποτελέσματα που θα του επιστραφούν, εάν η τιμή είναι -1 επιστρέφονται όλα τα αποτελέσματα
function ma_ellak_profile_get_active_query($limit){
	global $wpdb, $ma_prefix;

	$result = mysql_query("SELECT DISTINCT b.ID, c.meta_value FROM {$wpdb->users} a, {$wpdb->posts} b, {$wpdb->usermeta} c
		WHERE b.post_author=a.ID AND a.ID=c.user_id AND c.meta_key='". $ma_prefix ."all_jobs_selected' AND b.post_type='profile' AND b.post_status='publish'");
	
	$k=0;
	while($row=mysql_fetch_row($result)){
		$unserialized_data=unserialize($row[1]);
		$data[]=array('id'=> $row[0], 'jobs'=>count($unserialized_data));
	}
	
	foreach ($data as $key => $row) {
		$ids[$key]  = $row['id'];
		$jobs[$key] = $row['jobs'];
	}

	array_multisort($jobs, SORT_DESC, $data);
	
	// Query arguments for WP_Query
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$args = array(
        'post_type' => 'profile',
		'paged' => $paged,
		'posts_per_page' => $limit,
		'ignore_sticky_posts'=> 1,
        'post_status' => 'publish',
		'post__in'    => $ids,
	);
	return $args;
}

//Εκτυπώνει τη λίστα με τα ενεργά προφίλ (επιστρέφονται όλα τα προφίλ στα οποία έχει ανατεθεί κάποια δουλειά)
// 1. $limit το όριο των αποτελεσμάτων ανά σελίδα
function ma_ellak_profile_get_active_page($limit){
	$args=ma_ellak_profile_get_active_query($limit);
	$wp_query=ma_ellak_yp4_get_results($args);

	if ($wp_query->found_posts>0)
		profile_list_page($wp_query);
	else
		_e('Δεν βρέθηκαν προφίλ στα οποία να έχει ανατεθεί κάποια εργασία.', 'ma_ellak');

	if ($wp_query->found_posts>$limit)
		pagination(false, false, $wp_query);
}

//Εκτυπώνει τη λίστα με τα πιο δημοφιλή προφίλ
// 1. $limit το όριο των αποτελεσμάτων ανά σελίδα
function ma_ellak_profile_get_popular_page($limit){
	$args=ma_ellak_profile_get_popular_query($limit);
	$wp_query=ma_ellak_yp4_get_results($args);

	if ($wp_query->found_posts>0)
		profile_list_page($wp_query);
	else
		_e('Δεν έχουν καταχωρηθεί ακόμη προφίλ στην πλατφόρμα.', 'ma_ellak');

	if ($wp_query->found_posts>$limit)
		pagination(false, false, $wp_query);
}


function get_profile_logo($logo){
	//get the extension for the image
	$userfile_name = $logo;
	$userfile_extn = substr($userfile_name, strrpos($userfile_name, '.'));
	$get_filename= explode($userfile_extn, $userfile_name);
	$thumbnail=$get_filename[0] ."-150x150" . $userfile_extn;

	return $thumbnail;
}

function ma_ellak_get_profile_experience($profile_id){
	$experience = get_post_meta($profile_id,'_ma_ellak_profile_experience',true);
	$c = 0;
	if($experience)
		if ( count( $experience ) >= 0 )
			foreach( $experience as $exp )
				if ( isset( $exp['_ma_ellak_exp_title'] ) ){
					$title=$exp['_ma_ellak_exp_title'];
					$entity=$exp['_ma_ellak_exp_entity'];
					$url=$exp['_ma_ellak_exp_url'];
					$desc=$exp['_ma_ellak_exp_desc'];
					$from=$exp['_ma_ellak_exp_from'];
					$to=$exp['_ma_ellak_exp_to'];

					echo "<span class='magenta'>".__('Τίτλος:', 'ma_ellak')."</span>";
									echo"<strong class=\"magenta\">";
									echo " ". $title;
									echo"</strong><BR>";
					
					
					if ($entity!=''){
						echo "<span class='magenta'>".__('Φορέας:', 'ma_ellak')."</span>";
									echo"<strong class=\"magenta\">";
									echo " ". $entity;
									echo"</strong><BR>";
					}
					if ($from!=''){
									echo"<strong class=\"magenta\">";
									echo " ". $from;
									echo"</strong>";
									if ($to=='')
										echo"<BR>";
					}
					if ($to!=''){
									echo"<strong class=\"magenta\">";
									echo " - ". $to;
									echo"</strong><BR>";
					}
					if ($desc!=''){
						echo $desc;
					}
					echo"<p>&nbsp;</p>";
				}
}

function ma_ellak_profiles_upper_bar(){
?>
	<div class="row-fluid">&nbsp;</div>
	<div class="row-fluid">
		<div class="span6">
			<ul class="unstyled inline filters">
				<?php $link_page=get_permalink(get_option_tree('ma_ellak_list_profiles'));?>
				<?php if (isset($_GET['action']) && $_GET['action']!=''){?>
				<li><a href="<?php echo $link_page; ?>?action=list"><?php _e('ΠΙΣΩ ΣΤΗ ΛΙΣΤΑ', 'ma-ellak');?></a></li>
				<li>|</li>
				<?php }?>
				<li><a href="<?php echo $link_page; ?>?action=active"
				class="<?php if (isset($_GET['action']) && $_GET['action']=='active') echo'active-menu';?>">
				
				<?php _e('ΕΝΕΡΓΑ ΠΡΟΦΙΛ', 'ma-ellak');?> </a></li>
				<li>|</li>
				<li><a href="<?php echo $link_page; ?>?action=popular"
						class="<?php if (isset($_GET['action']) && $_GET['action']=='popular') echo'active-menu';?>">
				<?php _e('ΔΗΜΟΦΙΛΗ', 'ma-ellak');?> </a></li>
				<li>|</li>
				<li><a href="<?php echo $link_page; ?>?action=search"
				class="<?php if (isset($_GET['action']) && $_GET['action']=='search') echo'active-menu';?>">
				<?php _e('ΑΝΑΖΗΤΗΣΗ', 'ma-ellak');?> </a></li>
			</ul>
		</div>
	</div>
<?php
}

function ma_ellak_profile_search_page($limit){
	wp_reset_query();
	global $ma_prefix;

	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$args = array(
		'post_type' => 'profile',
		'post_status' => 'publish', 
		'paged' => $paged,
		'posts_per_page' => $limit,
		'suppress_filters' => false,
	);

	$args['meta_query'] = array();
	if (isset($_GET['submit'])){
		$args['tax_query'] = array();
		$args['tax_query']['relation'] = 'AND';
		
		foreach($_GET as $key=>$value){
			if($key=='submit') continue;
			if($key=='action' ) continue;
			if( $value == '' or $value == '0' ) continue;

			if ($key=='_ma_profile_type'){
				$args['meta_query']=array(
					'relation'=>'AND',
						array(
							'key'=>'_ma_profile_type',
							'value'=>$value,
							'compare' => '='
						)
				);
			}
			else{
				$args['tax_query'][] = array(
					'taxonomy' => $key,
					'field' => 'slug',
					'terms' => $value
				);
			}
		}
	}
	
	$wp_query=ma_ellak_yp4_get_results($args);
	
	
	
	
	//$posts = get_posts($args);
?>
	<div class="row-fluid">
	<div class="span8 char-list ">

	<?php
		if ($wp_query->found_posts>0 && isset($_GET) && isset($_GET['submit'])){
	?>
			<div class="row-fluid event">
			<div class="cols">
				<div class="span11 text col">
					
					<?php
						if ($_GET['type']!='0' || $_GET['package']!='0' || $_GET['jobtype']!='0' || $_GET['_ma_profile_type']!=''){
							?><h4><?php _e('Αποτελέσματα αναζήτησης', 'ma_ellak'); 
							_e(' με τα ακόλουθα κριτήρια: ', 'ma_ellak');
						echo "</h4>";
						if (isset($_GET['type']) && $_GET['type']!='0'){
							_e('<b>Κατηγορία λογισμικού:</b> ', 'ma_ellak');
							$term=get_term_by('slug', $_GET['type'], 'type');
							_e($term->name, 'ma_ellak');
						}
						if (isset($_GET['package']) && $_GET['package']!='0'){
							if ($_GET['type']!='0')
								_e('<br>', 'ma_ellak');
							_e('<b>Πακέτα λογισμικού:</b> ', 'ma_ellak');
							$term=get_term_by('slug', $_GET['package'], 'package');
							_e($term->name, 'ma_ellak');
						}
						if (isset($_GET['jobtype']) && $_GET['jobtype']!='0'){
							if ($_GET['type']!='0' || $_GET['package']!='0')
								_e('<br>', 'ma_ellak');
							_e('<b>Αντικείμενο παρεχόμενης υπηρεσίας:</b> ', 'ma_ellak');
							$term=get_term_by('slug', $_GET['jobtype'], 'jobtype');
							_e($term->name, 'ma_ellak');
						}
						if ($_GET['_ma_profile_type']!=''){
							if ($_GET['type']!='0' || $_GET['package']!='0' || $_GET['jobtype']!='0')
								_e('<br>', 'ma_ellak');
							_e('<b>Είδος παρεχόμενης υπηρεσίας:</b> ', 'ma_ellak');
							if ($_GET['_ma_profile_type']=='professional')
								_e('Επαγγελματίας', 'ma_ellak');
							if ($_GET['_ma_profile_type']=='volunteer')
								_e('Εθελοντική', 'ma_ellak');
						}
						}
					?>
				</div>
			</div>
		</div>
	<?php
		}
	?>
	<?php
	if ($wp_query->found_posts>0)
		profile_list_page($wp_query, 'search');
	else
		_e('Δεν έχουν καταχωρηθεί ακόμη προφίλ στην πλατφόρμα.', 'ma_ellak');
	?>
	</div><!-- span8 -->
	
  	<div class="span4">
		<h4><?php _e('Φίλτρα Αναζήτησης', 'ma_ellak'); ?></h4>
		<form action="<?php echo get_permalink(get_option_tree('ma_ellak_list_profiles')); ?>" method="get" class="span12" id="searchprofile">
			<ul>
				<li>
					<label for="type"><?php _e('Κατηγορία Λογισμικού', 'ma-ellak'); ?></label>
					<?php 
						wp_dropdown_categories(
							array(
								'walker' => new ma_ellak_Walker_TaxonomyDropdown,
								'show_option_all' => __('Όλες οι Κατηγορίες', 'ma-ellak'),
								'value'=>'slug',
								'show_count'=> 0,
								'orderby'=>'name',
								'name'=> 'type',
								'taxonomy'=> 'type',
								'selected' =>  $wp_query->query['type'],
							)	
						); 
					?>
				</li>
				<li>
					<label for="package"><?php _e('Πακέτα Λογισμικού', 'ma-ellak'); ?></label>
					<?php
						wp_dropdown_categories(
							array(
								'walker' => new ma_ellak_Walker_TaxonomyDropdown,
								'show_option_all' => __('Όλα τα Πακέτα', 'ma-ellak'),
								'value'=>'slug',
								'show_count'=> 0,
								'orderby'=>'name',
								'name'=> 'package',
								'taxonomy'=> 'package',
								'selected' =>  $wp_query->query['package'],
							)
						); 
					?>
				</li>
				<li>
					<label for="jobtype"><?php _e('Αντικείμενο παρεχόμενης υπηρεσίας', 'ma-ellak'); ?></label>
					<?php 
						wp_dropdown_categories(
							array(
								'walker' => new ma_ellak_Walker_TaxonomyDropdown,
								'show_option_all' => __('Όλα τα αντικείμενα', 'ma-ellak'),
								'value'=>'slug',
								'show_count'=> 0,
								'orderby'=>'name',
								'name'=> 'jobtype',
								'taxonomy'=> 'jobtype',
								'selected' =>  $wp_query->query['jobtype'],
							)
						); 
					?>
				</li>
				<li>
					<label for="_ma_profile_type"><?php _e('Είδος παρεχόμενης υπηρεσίας', 'ma-ellak'); ?></label>
					<select class="_ma_profile_type" name="_ma_profile_type" id="_ma_profile_type">
						<option value="" selected="">Επιλέξτε</option>
						<option value="professional">Εγγυημένη</option>
						<option value="volunteer">Εθελοντική</option>
					</select>
				</li>
				<li>
					<div class="span12">
						<input type="hidden" name="action" id="action" value="search"/>
						<input class="btn btn-primary btn-block" name="submit" id="submit" tabindex="5" value="<?php echo attribute_escape(__('Αναζήτηση', 'ma-ellak')); ?>" type="submit"></div>
				</li>
			</ul>
		</form>
	</div>

	<?php 
if ($wp_query->found_posts>$limit)
		pagination(false, false, $wp_query);
	?>
 </div>
 <?php 
 }

function ma_ellak_send_email_users($jobtype, $package, $profile_type){
	global $ma_prefix;

	$args = array (
		'post_type' => 'profile',
		'post_status'=>'publish',
		'ignore_sticky_posts'=> 1
	);

	/************profile_type****************/
	if ($profile_type=='professional' || $profile_type=='volunteer'){
		$args['meta_query']= array(
			'relation' => 'AND',
			array(
				'key' => '_ma_profile_type',
				'value' => $profile_type,
				'compare' => '='
			)
		);
	}
	else{
		$args['meta_query']= array(
			'key' => '_ma_profile_type',
			'compare' => '=',
			'relation' => 'OR',
			array('value'=>'professional'),
			array('value'=>'volunteer'),
		);
	}

	/****************jobtype*************/
	$args['tax_query']=array();
	$args['tax_query1']=array();
	$args['tax_query2']=array();

	if ($jobtype!=''){
		$args['tax_query1'][] = array(
			'taxonomy' => 'jobtype',
			'field' => 'taxonomy_id',
			'terms' => $jobtype,
		);
	}

	/**********package***************/
	if ($package!=''){
		foreach($package as $package_val){
			$args['tax_query2'][] = array(
				'taxonomy' => 'package',
				'field' => 'taxonomy_id',
				'terms' => $package_val
			);
		}
	}

	if ($jobtype!='' || $package!='')
		$args['tax_query']=array_merge($args['tax_query1'], $args['tax_query2']);

	if ($jobtype!='' && $package!='')
		$args['tax_query']['relation'] ='AND';
	$posts = get_posts($args);
	if(count($posts) > 0){
		foreach($posts as $profile){
			$user_mail[] = get_post_meta( $profile->ID, $ma_prefix . 'profile_email', true);
		}
		return $user_mail;
	} else { return false; }
}

?>