<?php
/**
* Αρχείο συναρτήσεων που αφορούν την οντότητα Μονάδες Αριστείας
*
* @licence GPL
* @author Fotis Routsis - fotis@routsis.gr
* 
* Project URL http://ma.ellak.gr
*/


global $unit_fields;
global $ma_prefix ;

// Ορίζονται τα Custom Post Meta για τις Μονάδες Αριστείας.
// Ορίζονται εξωτερικά για να είναι προσβάσιμες και απο άλλες μεθόδους.
$unit_fields = array(
	// Χρησιμοποιεί το πρόθεμα $ma_prefix
	// Κύρια Θεματική 	unit_main_thema
	// Λογότυπο 		unit_logo
	// Τίτλος Ιδρύματος	unit_title
	// Ιστοσελίδα		unit_web_url
	// email			unit_email
	// Τηλεφωνο 		unit_tel
	// Fax				unit_fax
	// Διεύθυνση		unit_address_street
	// Αριθμός			unit_address_num
	// ΤΚ				unit_address_ac
	array(
		'name' => __('Κύρια Θεματική', 'ma-ellak'),
		'desc' => __('Ορίστε την Κύρια Θεματική της Μονάδας Αριστείας', 'ma-ellak'),
		'id'   => $ma_prefix . 'unit_main_thema',
		'taxonomy' => 'thema', //Enter Taxonomy Slug
		'type' => 'ma_taxonomy_select_by_id',
	),
	array(
		'name' => __('Λογότυπο', 'ma-ellak'),
		'desc' => __('Ανεβάστε το λογότυπο της Μονάδας Αριστείας', 'ma-ellak'),
		'id'   => $ma_prefix . 'unit_logo',
		'type' => 'file',
	),
	array(
		'name' => __('Τίτλος Ιδρύματος', 'ma-ellak'),
		'desc' => __('Ο επίσημος Τίτλος του Ιδρύματος', 'ma-ellak'),
		'id'   => $ma_prefix . 'unit_title',
		'type' => 'text',
	),
	array(
		'name' => __('Ιστοσελίδα', 'ma-ellak'),
		'desc' => __('Ο επίσημος Δικτυακός Τόπος του Ιδρύματος', 'ma-ellak'),
		'id'   => $ma_prefix . 'unit_web_url',
		'type' => 'text',
	),
	array(
		'name' => __('eΜail', 'ma-ellak'),
		'desc' => __('Διεύθυνση Ηλ. Αλληλογραφίας του Ιδρύματος', 'ma-ellak'),
		'id'   => $ma_prefix . 'unit_email',
		'type' => 'text_medium',
	),
	array(
		'name' => __('Τηλέφωνο', 'ma-ellak'),
		'desc' => __('Τηλέφωνο/α Επικοινωνίας του Ιδρύματος (χωρισμένα με κόμα)', 'ma-ellak'),
		'id'   => $ma_prefix . 'unit_tel',
		'type' => 'text',
	),
	array(
		'name' => __('Φαξ', 'ma-ellak'),
		'desc' => __('Φαξ Επικοινωνίας του Ιδρύματος (χωρισμένα με κόμα)', 'ma-ellak'),
		'id'   => $ma_prefix . 'unit_fax',
		'type' => 'text',
	),
	array(
		'name' => __('Οδός', 'ma-ellak'),
		'desc' => __('Διεύθυνση - Οδός του Ιδρύματος', 'ma-ellak'),
		'id'   => $ma_prefix . 'unit_address_street',
		'type' => 'text_medium',
	),
	array(
		'name' => __('Αριθμός', 'ma-ellak'),
		'desc' => __('Διεύθυνση - Αριθμός του Ιδρύματος', 'ma-ellak'),
		'id'   => $ma_prefix . 'unit_address_num',
		'type' => 'text_medium',
	),
	array(
		'name' => __('ΤΚ', 'ma-ellak'),
		'desc' => __('ΤΚ του Ιδρύματος', 'ma-ellak'),
		'id'   => $ma_prefix . 'unit_address_ac',
		'type' => 'text_medium',
	),
	array(
		'name' => __('Πόλη', 'ma-ellak'),
		'desc' => __('Πόλη που βρίσκεται το Ίδρυμα', 'ma-ellak'),
		'id'   => $ma_prefix . 'unit_city',
		'type' => 'text_medium',
	),
);

// Εγγραφή του Σύνθετου Τύπου Μονάδες Αριστείας (Unit) [1/2]
add_action( 'init', 'ma_ellak_register_unit_posttype', 0 );

// Εγγραφή του Σύνθετου Τύπου Μονάδες Αριστείας (Unit) [2/2]
function ma_ellak_register_unit_posttype() {

	$labels = array(
		'name' 					=> _x( 'Μονάδες Αριστείας', 'γενικό όνομα', 'ma-ellak' ),
		'singular_name' 		=> _x( 'Μονάδα Αριστείας', 'γενικό όνομα', 'ma-ellak' ),
		'add_new' 				=> _x( 'Προσθήκη Νέας', 'Μονάδας Αριστείας', 'ma-ellak' ),
		'add_new_item'			=> __( 'Προσθήκη Νέας Μονάδας Αριστείας', 'ma-ellak' ),
		'edit_item' 			=> __( 'Επεξεργασία Μονάδας Αριστείας', 'ma-ellak' ),
		'new_item' 				=> __( 'Νέα Μονάδας Αριστείας', 'ma-ellak' ),
		'all_items' 			=> __( 'Όλες οι Μονάδες Αριστείας', 'ma-ellak' ),
		'view_item' 			=> __( 'Προβολή Μονάδας Αριστείας', 'ma-ellak' ),
		'search_items' 			=> __( 'Αναζήτηση Μονάδων Αριστείας', 'ma-ellak' ),
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
		'rewrite' 				=> array( 'slug' => 'unit', 'with_front' => true, 'feeds' => true ) ,
		'capability_type' 		=> 'post',
		'hierarchical' 			=> false,
		'menu_position' 		=> null,
		'supports' 				=> array( 'title', 'author', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions', 'custom-fields' ),
	);

	register_post_type( 'unit' , $args  );
}


// Προσθέτει AJAX Validation κατά την επιλογή Θεματικής στην περίπτωση των Μονάδων Αριστείας [1/3]
function ma_ellak_unit_force_three_thema() {
	$template_dir =  get_bloginfo('template_directory');
	wp_enqueue_script( 'ma_validate_unit_force_three_thema', $template_dir . '/js/validate_unit_force_three_thema.js', array( 'jquery' ), '1.0', true );
}

// Προσθέτει AJAX Validation κατά την επιλογή Θεματικής στην περίπτωση των Μονάδων Αριστείας [2/3]
function ma_ellak_unit_edit_form(){
	global $typenow;
	if($typenow == 'unit')
		add_action('edit_form_advanced', 'ma_ellak_unit_force_three_thema');
}

// Προσθέτει AJAX Validation κατά την επιλογή Θεματικής στην περίπτωση των Μονάδων Αριστείας [3/3]
add_action( 'admin_enqueue_scripts', 'ma_ellak_unit_edit_form' );


// Προσθέτει javascripts και css styles στο front-end [1/2]
function ma_ellak_unit_scripts() {
	
	$template_dir =  get_bloginfo('template_directory');
	
	global $post;
	if(get_post_type($post->ID) == 'unit'){
		wp_enqueue_script( 'ajax_request_unit_membership', $template_dir . '/js/ajax_request_unit_membership.js', array( 'jquery' ), '1.0', true );
		wp_localize_script( 'ajax_request_unit_membership', 'ajax_request_unit_membership_settings', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'req_nonce' => wp_create_nonce("ma_ellak_request_unit_membership_nonce"),
			'success_msg' => __('Η αίτησή σας καταχωρήθηκε!', 'ma-ellak'),
			'error_msg' => __('Προέκυψε σφάλμα!', 'ma-ellak'),
			'success_msg_leave' => __('Επιτυχής Αποχώρηση απο τη Μονάδα Αριστείας!', 'ma-ellak'),
		) );
	}
}

// Προσθέτει javascripts και css styles στο front-end [2/2]
add_action( 'wp_enqueue_scripts', 'ma_ellak_unit_scripts', 11 );


// Προσθέτει javascripts και css styles για τη Σελίδα Επεξεργασίας [1/2]
function ma_ellak_unit_edit_scripts() {
	
	$template_dir =  get_bloginfo('template_directory');
	
	if ( is_page_template('ma_ellak_tmpl_edit_unit.php') ) {
		wp_enqueue_script( 'ma_ellak_validate_edit_unit',  $template_dir . '/js/validate_unit_tmpl_edit_unit.js',  array('jquery'), '1.0', true );
	}
}
// Προσθέτει javascripts και css styles για τη Σελίδα Επεξεργασίας [2/2]
add_action( 'wp_enqueue_scripts', 'ma_ellak_unit_edit_scripts', 11 );


// Δηλώνουμε την εμφάνιση του metabox για τον τύπο αντικειμένου Λογισμικό [1/2]
add_filter( 'cmb_meta_boxes', 'ma_ellak_units_metabox' );

// Δηλώνουμε την εμφάνιση του metabox για τον τύπο αντικειμένου Λογισμικό [2/2]
function ma_ellak_units_metabox( array $meta_boxes ) {
	
	global $unit_fields;

	$meta_boxes[] = array(
		'id'         => 'unit_main_thema',
		'title'      => __('Κύρια Θεματική', 'ma-ellak'),
		'pages'      => array( 'unit'), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => $unit_fields,
	);
	
	return $meta_boxes;
}

// Επιστρέφει την Κύρια Θεματική της Μονάδας Αριστείας ως Object ή False αν δεν την εντοπίσει.
// Παράμετροι: To ID της Μονάδας Αριστείας της οποίας αναζητάμε την Κύρια Θεματική. Το αφήνουμε κενό όταν καλείται μέσα στο loop.
function ma_ellak_unit_get_main_thema( $unit_id = 0 ) {
	
	global $ma_prefix ;
	
	if($unit_id == 0){
		global $post;
		$unit_id = $post->ID;
	}

	$main_unit_id  = 0 ;
	$main_unit_id = get_post_meta( $unit_id, $ma_prefix.'unit_main_thema', true );
	
	if($main_unit_id > 0){ 
		
		$main_unit = get_term_by('id', $main_unit_id, 'thema');
		if ( is_wp_error( $main_unit ) )
			return false;
		else
			return $main_unit;
	} else 
		return false;
	
}

// Επιστρέφει όλα τα πρόσθετα στοιχεία (Custom Post Fields) της Μονάδας Αριστείας σε μορφή πίνακα.
// Παράμετροι: 
// $unit_id: To ID της Μονάδας Αριστείας της οποίας θέλουμε τα στοιχεία. Το αφήνουμε κενό όταν καλείται μέσα στο loop.
// $label: Τι είδους key θα φέρει ο πίνακας. Προεπιλεγμένα είναι ο Τίτλος του Custom Post Field
// $label = 'name' (default) -> ο Τίτλος του Custom Post Field
// $label = 'id' -> το ID (name) Custom Post Field
function ma_ellak_get_unit_details( $unit_id = 0, $label = 'name' ) {
	
	global $unit_fields;
	global $ma_prefix ;
	
	if($unit_id == 0){
		global $post;
		$unit_id = $post->ID;
	}

	// Κύρια Θεματική 	unit_main_thema
	// Λογότυπο 		unit_logo
	// Τίτλος Ιδρύματος	unit_title
	// Ιστοσελίδα		unit_web_url
	// email			unit_email
	// Τηλέφωνο 		unit_tel
	// Fax				unit_fax
	// Διεύθυνση		unit_address_street
	// Αριθμός			unit_address_num
	// ΤΚ				unit_address_ac
	
	$all_fields = array();
	
	foreach($unit_fields as $field){
		
		switch($field['id']){
			case( $ma_prefix . 'unit_main_thema'): 
				//echo $field['id'];
				$all_fields[$field[$label]] = ma_ellak_unit_get_main_thema($unit_id)->name;
				break;
			default:
				$all_fields[$field[$label]] =  get_post_meta( $unit_id, $field['id'], true );
				break;
		}
	}
	
	return $all_fields;
}

function ma_ellak_unit_save_details($unit_id){
	global $unit_fields;
	
	foreach($unit_fields as $field){
		if($field['type'] != 'text' and $field['type'] != 'text_medium') continue;
		
		if ( isset( $_POST[$field['id']]) and $field['id'] != $ma_prefix . 'unit_logo')
			update_post_meta( $unit_id, $field['id'],  $_POST[$field['id']] );
	}
}

// Επιστρέφει αν το μέλος (user_id) ανήκει στη Μονάδα (unit_id) και στην περίπτωση που είναι επιλεγμένο εκτυπώνει και το αντίστοιχο μήνυμα η κουμπί συμμετοχής
function ma_ellak_is_member_on_unit($user_id = 0, $unit_id = 0, $print_details = true){
	
	global $post;
	
	 if (! is_user_logged_in()) // Μόνο εγγεγραμμένοι χρήστες έχουν αυτό το δικαίωμα
		return __('Πρέπει να είστε Εγγεγραμμένοι χρήστες για να συμμετέχετε σε μια Μονάδα Αριστείας','ma-ellak');
	
	if(current_user_can('administrator'))
		return __('Είστε Υπερδιαχειριστής!','ma-ellak');
		
	// Αφορά τον logged in χρήστη
	if($user_id == 0){
		$cur_user = wp_get_current_user();
		$user_id = $cur_user->ID; 
	}
	
	// Αφορά στο single-unit για έλεγχο στη σελίδα της Μονάδας
	if($unit_id == 0){
		$unit_id = $post->ID; 
	}
	
	// Ελεγχος Πρωτα αν ειναι Διαχειριστής Αυτής ή άλλης Μονάδας Αριστείας
	$user_unit_id = get_user_meta( $cur_user->ID , '_ma_ellak_admin_unit', true ); 
	if(!empty($user_unit_id ) and $user_unit_id > 0){
		if($unit_id == $user_unit_id){
			if($print_details){
				return __('Είστε Διαχειριστής της Συγκεκριμένης Μονάδας Αριστείας','ma-ellak');
			} else {
				return true;
			}
		} else {
			if($print_details){
				return __('Είστε Διαχειριστής άλλης Μονάδας Αριστείας','ma-ellak');
			} else {
				return false;
			}
		}
	}
	
	// Είναι δηλωμένος σε κάποια Μονάδα ;
	$user_unit_id = get_user_meta( $user_id, '_ma_ellak_member_unit', true ); 
	
	// Είναι δηλωμένος σε Μονάδα
	if(!empty($user_unit_id ) and $user_unit_id > 0){
		if($unit_id == $user_unit_id){
			if($print_details){
				$message =  __('Είστε μέλος της Συγκεκριμένης Μονάδας Αριστείας','ma-ellak');
				$message .= '<br /><a href="#" class="btn leave-membership" usr="'.$user_id.'" unt="'.$unit_id .'">'.__('Αποχώρηση απο τη Μονάδα Αριστείας','ma-ellak').'</a>';
				return $message;
			} else {
				return true;
			}
		} else {
			if($print_details){
				return __('Είστε μέλος άλλης Μονάδας Αριστείας','ma-ellak');
			} else {
				return false;
			}
		}
	} 
	
	// Έχει κάνει αίτηση σε κάποια Μονάδα ;
	$user_unit_id = get_user_meta( $user_id, '_ma_ellak_member_unit_request', true ); 
	
	// Έχει κάνει αίτηση στη Μονάδα
	if(!empty($user_unit_id ) and $user_unit_id > 0){
		if($unit_id == $user_unit_id){
			if($print_details){
				$message =  __('Έχετε ήδη καταχωρημένη αίτηση συμμετοχής γι αυτή τη Μονάδα','ma-ellak');
				$message .= '<br /><a href="#" class="btn leave-membership" usr="'.$user_id.'" unt="'.$unit_id .'">'.__('Ανάκληση της Αίτησης/Αποχώρηση','ma-ellak').'</a>';
				return $message;
			} else {
				return false;
			}
		} else {
			// Έχει κάνει αίτηση αλλού, οπότε δεν μπορεί να κάνει και αλλού μέχρι να επεξεργαστεί το αίτημά του σε αυτή.
			if($print_details){
				return __('Έχετε ήδη καταχωρημένη αίτηση συμμετοχής σε άλλη Μονάδα','ma-ellak');
			} else {
				return false;
			}
		}
	} 
	// Δεν είναι δηλωμένος
	if($print_details){
		$form = '<a href="#" class="btn request-membership" usr="'.$user_id.'" unt="'.$unit_id .'">'.__('Συμμετοχή στην Μονάδα Αριστείας','ma-ellak').'</a>';		
		return $form;
	} else {
		return false;
	}
	
}

// Επιστρέφει το Id της Μονάδας Αριστείας στην οποία Ανήκει ο Χρήστης (user_id)
// Αν ο χρήστης δεν ανήκει σε ΜΑ τότε επιστρέφει 0
function ma_ellak_get_unit_id($user_id =0 ){

	// Αφορά τον logged in χρήστη
	if($user_id == 0){
		$cur_user = wp_get_current_user();
		$user_id = $cur_user->ID; 
	}
	
	$user_unit_id = get_user_meta( $user_id, '_ma_ellak_member_unit', true ); 
	
	if(!empty($user_unit_id ) and $user_unit_id > 0)
		return $user_unit_id ;
	else{
		// Έλεγχος αν είναι Διαχειριστής (αφού είδαμε οτι δεν είναι ορισμένος ως Χρήστης.
		$user_unit_id = get_user_meta( $user_id, '_ma_ellak_admin_unit', true ); 
		if(!empty($user_unit_id ) and $user_unit_id > 0)
		return $user_unit_id ;
	}	
	
	return 0;
	 
}

// Αποθηκεύσει σε οποιοδήποτε αντικείμενο περιεχομένου το ID της Μονάδας Αριστείας στο οποίο ανήκει ο χρήστης που το καταχωρεί [1/2]
add_action( 'publish_post', 'ma_ellak_set_unit_on_object',10,2 );

// Αποθηκεύσει σε οποιοδήποτε αντικείμενο περιεχομένου το ID της Μονάδας Αριστείας στο οποίο ανήκει ο χρήστης που το καταχωρεί [2/2]
function ma_ellak_set_unit_on_object($post_id){
	
	$slugz = array('unit'); 	// Εδώ εξαιρούμε ορισμένα αντικείμενα περιεχομένου (ορίζουμε τα slug τους) 
	
	if ( in_array($_POST['post_type'], $slugz) ) 
        return;
		
	if ( wp_is_post_revision( $post_id ) ) // Αν είναι revision αγνόησε το
		return;

	// Έχει ήδη δηλωθεί σε κάποια Μονάδα Αριστείας ;
	$unit_set = get_post_meta( $post_id, '_ma_ellak_belongs_to_unit', true );
	
	// Αν όχι πάρε το ID της Μονάδας Αριστείας του χρήστη που έφτιαξε το αντικείμενο και όρισέ ως meta σε αυτό
	if(empty($unit_set ) or $unit_set == 0)
		update_post_meta( $post_id, '_ma_ellak_belongs_to_unit', ma_ellak_get_unit_id() );
}


// Επιστρέφει το ID της ΜΑ το οποίο έχει χρεωθεί σε ένα Αντικείμενο
// Αν δεν έχει οριστεί επιστρέφει 0
function ma_ellak_get_object_unit_id($object_id = 0){
	
	if($object_id == 0){
		global $post;
		$object_id = $post->ID;
	}

	$unit_set = get_post_meta( $object_id, '_ma_ellak_belongs_to_unit', true );
	
	if(empty($unit_set ) or $unit_set == 0)
		return 0;
	else
		return $unit_set ;
}

// Επιστρέφει τα ID (array) των BP Groups που αντιστοιχίζονται σε μια Μονάδα Αριστείας (unit_id)
function ma_ellak_get_bp_groups_thema_ids( $unit_id = 0 ) {

	global $ma_prefix ;
	
	if($unit_id == 0){
		global $post;
		$unit_id = $post->ID;
	}

	// Πάρε όλες τις αντιστοιχίσεις Θεματικών και BP Group IDs
	$options = get_option('ma_ellak_thema_bp_match');
	$options = (is_string($options)) ? @unserialize($options) : $options;
	$options = $options['ma_ellak_thema_bp'];
	
	$bp_group_idz = array();
	
	// Πάρε τις Θεματικές που αντιστοιχίζονται στην εν λόγω ΜΑ
	$terms = get_the_terms( $unit_id, 'thema' ); 
	if ( $terms && ! is_wp_error( $terms ) ) 
		foreach ( $terms as $term ) {
			$tmp_id = array_search($term->term_id, $options);
			if($tmp_id === false){} else {
				$bp_group_idz[] = $tmp_id ;
			}
		}
		
	return $bp_group_idz;	
}

// Επιστρέφει Αντιστοίχιση Group ID απο το Thema
function ma_ellak_get_bp_groups_id_by_thema( $thema_id ) {

	$options = get_option('ma_ellak_thema_bp_match');
	$options = (is_string($options)) ? @unserialize($options) : $options;
	$options = $options['ma_ellak_thema_bp'];
	
	$tmp_id = array_search($thema_id, $options);
	
	if(!empty($tmp_id) and $tmp_id != 0)
		return $tmp_id;
	else
		return 0;
	
}

// Επιστρέφει Αντιστοίχιση Thema απο το BP Group ID
function ma_ellak_get_thema_id_by_bp_groups_id( $group_id ) {

	$options = get_option('ma_ellak_thema_bp_match');
	$options = (is_string($options)) ? @unserialize($options) : $options;
	$options = $options['ma_ellak_thema_bp'];
	
	if(array_key_exists($group_id, $options))
		return $options[$group_id];
	else
		return 0;
}

// Εκτυπώνει όλες τις Μονάδες Αριστείας
function ma_ellak_list_all_units($before = '', $after = '', $with_icons = false , $width = 50, $height = 50){
	global $ma_prefix;
	$args = array( 'posts_per_page' => -1, 'post_type'=>'unit' );
	$unitz = get_posts( $args );
	foreach ( $unitz as $unit ){
		echo $before;
		if($with_icons){
			$img = get_post_meta($unit->ID, $ma_prefix . 'unit_logo', true);
			if(!empty($img) and strlen($img)>5)
				echo '<span class="accordion-logo logo-'.$unit->ID.'"><img src="'.$img.'" width="'.$width.'" alt="'.$unit->post_title.'"/></span>';
		}
		echo '<a href="'.get_permalink($unit->ID).'">'.$unit->post_title.'</a>';
		echo  $after;
	}
}

function ma_ellak_get_unit_per_thema_by_bp($bp_id, $before = '', $after = '', $with_icons = true , $width = 50, $height = 50){
	
	$thema_id = ma_ellak_get_thema_id_by_bp_groups_id($bp_id);
	ma_ellak_get_unit_per_thema($thema_id);
}

function ma_ellak_get_unit_per_thema($thema_id, $before = '', $after = '', $with_icons = true , $width = 50, $height = 50){
	global $ma_prefix;
	$args = array( 
		'posts_per_page' => -1, 
		'post_type'=>'unit', 
		'tax_query' => array(
			array(
				'taxonomy' => 'thema',
				'terms' => $thema_id,
				'field' => 'term_id',
			)
		)
	);
	
	$unitz = get_posts( $args );
	foreach ( $unitz as $unit ){
		echo $before;
		echo '<a href="'.get_permalink($unit->ID).'" title="'.$unit->post_title.'">';
		if($with_icons){
			$img = get_post_meta($unit->ID, $ma_prefix . 'unit_logo', true);
			if(!empty($img) and strlen($img)>5)
				echo '<img src="'.$img.'" width="'.$width.'" alt="'.$unit->post_title.'"/>';
		} else {
			echo $unit->post_title;
		}
		echo '</a>&nbsp; &nbsp;';
		echo  $after;
	}
}

?>