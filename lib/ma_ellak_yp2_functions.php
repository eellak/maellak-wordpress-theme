<?php
/**
* Αρχείο συναρτήσεων για την Υπηρεσία 1.
*
* @licence GPL
* @author Fotis Routsis - fotis@routsis.gr
* 
* Project URL http://ma.ellak.gr
*/

// Εγγραφή της Ταξονομίας 'Λογισμικού' [1/2]
add_action( 'init', 'ma_ellak_register_software_taxonomies', 1 );

// Εγγραφή της Ταξονομίας 'Λογισμικού' [2/2]
function ma_ellak_register_software_taxonomies() {
	$labels = array(
		'name' 				=> _x( 'Κατηγορία Λογισμικού', 'γενικό όνομα', 'ma-ellak' ),
		'singular_name' 	=> _x( 'Κατηγορία Λογισμικο', 'γενικό όνομα', 'ma-ellak' ),
		'search_items' 		=>  __( 'Αναζήτηση Τύπου', 'ma-ellak' ),
		'all_items' 		=> __( 'Όλοι οι Τύποι', 'ma-ellak' ),
		'parent_item' 		=> __( 'Γονικός Τύπος', 'ma-ellak' ),
		'parent_item_colon' => __( 'Γονικός Τύπος:', 'ma-ellak' ),
		'edit_item' 		=> __( 'Επεξεργασία Τύπου', 'ma-ellak' ),
		'update_item' 		=> __( 'Ενημέρωση Τύπου', 'ma-ellak' ),
		'add_new_item' 		=> __( 'Προσθήκη Τύπου', 'ma-ellak' ),
		'new_item_name' 	=> __( 'Προσθήκη Τύπου', 'ma-ellak' ),
		'menu_name' 		=> __( 'Κατηγορίες Λογισμικών', 'ma-ellak' ),
	);

	register_taxonomy( 'type', array( 'software', 'profile' ), array(
		'hierarchical' 	=> true,
		'labels' 		=> $labels,
		'show_ui' 		=> true,
		'query_var' 	=> true,
		'rewrite' 		=> array( 'slug' => 'type', 'with_front' => true, 'feeds' => true ) ,
	) );
	
	$labels = array(
		'name' 				=> _x( 'Άδεια Χρήσης', 'γενικό όνομα', 'ma-ellak' ),
		'singular_name' 	=> _x( 'Άδεια Χρήσης', 'γενικό όνομα', 'ma-ellak' ),
		'search_items' 		=>  __( 'Αναζήτηση Άδειας', 'ma-ellak' ),
		'all_items' 		=> __( 'Όλες οι Άδειες', 'ma-ellak' ),
		'parent_item' 		=> __( 'Γονική Άδεια', 'ma-ellak' ),
		'parent_item_colon' => __( 'Γονική Άδεια:', 'ma-ellak' ),
		'edit_item' 		=> __( 'Επεξεργασία Άδειας', 'ma-ellak' ),
		'update_item' 		=> __( 'Ενημέρωση Άδειας', 'ma-ellak' ),
		'add_new_item' 		=> __( 'Προσθήκη Άδειας', 'ma-ellak' ),
		'new_item_name' 	=> __( 'Προσθήκη Άδειας', 'ma-ellak' ),
		'menu_name' 		=> __( 'Άδειες Χρήσης', 'ma-ellak' ),
	);

	register_taxonomy( 'licence', array( 'software' ), array(
		'hierarchical' 	=> true,
		'labels' 		=> $labels,
		'show_ui' 		=> true,
		'query_var' 	=> true,
		'rewrite' 		=> array( 'slug' => 'licence', 'with_front' => true, 'feeds' => true ) ,
	) );

	$labels = array(
		'name' 				=> _x( 'Κατηγορία Εφαρμογής', 'γενικό όνομα', 'ma-ellak' ),
		'singular_name' 	=> _x( 'Κατηγορία Εφαρμογής', 'γενικό όνομα', 'ma-ellak' ),
		'search_items' 		=>  __( 'Αναζήτηση Κατηγορίας', 'ma-ellak' ),
		'all_items' 		=> __( 'Όλες οι Κατηγορίες', 'ma-ellak' ),
		'parent_item' 		=> __( 'Γονική Κατηγορία', 'ma-ellak' ),
		'parent_item_colon' => __( 'Γονική Κατηγορία:', 'ma-ellak' ),
		'edit_item' 		=> __( 'Επεξεργασία Κατηγορίας', 'ma-ellak' ),
		'update_item' 		=> __( 'Ενημέρωση Κατηγορίας', 'ma-ellak' ),
		'add_new_item' 		=> __( 'Προσθήκη Κατηγορίας', 'ma-ellak' ),
		'new_item_name' 	=> __( 'Προσθήκη Κατηγορία', 'ma-ellak' ),
		'menu_name' 		=> __( 'Κατηγορίες Εφαρμογών', 'ma-ellak' ),
	);

	register_taxonomy( 'nace', array( 'software' ), array(
		'hierarchical' 	=> true,
		'labels' 		=> $labels,
		'show_ui' 		=> true,
		'query_var' 	=> true,
		'rewrite' 		=> array( 'slug' => 'nace', 'with_front' => true, 'feeds' => true ) ,
	) );
	
	$labels = array(
		'name' 				=> _x( 'Επιστημονική Κατηγορία', 'γενικό όνομα', 'ma-ellak' ),
		'singular_name' 	=> _x( 'Επιστημονική Κατηγορία', 'γενικό όνομα', 'ma-ellak' ),
		'search_items' 		=>  __( 'Αναζήτηση Κατηγορίας', 'ma-ellak' ),
		'all_items' 		=> __( 'Όλες οι Κατηγορίες', 'ma-ellak' ),
		'parent_item' 		=> __( 'Γονική Κατηγορία', 'ma-ellak' ),
		'parent_item_colon' => __( 'Γονική Κατηγορία:', 'ma-ellak' ),
		'edit_item' 		=> __( 'Επεξεργασία Κατηγορίας', 'ma-ellak' ),
		'update_item' 		=> __( 'Ενημέρωση Κατηγορίας', 'ma-ellak' ),
		'add_new_item' 		=> __( 'Προσθήκη Κατηγορίας', 'ma-ellak' ),
		'new_item_name' 	=> __( 'Προσθήκη Κατηγορίας', 'ma-ellak' ),
		'menu_name' 		=> __( 'Επιστημονικές Κατηγορίες', 'ma-ellak' ),
	);

	register_taxonomy( 'frascati', array( 'software' ), array(
		'hierarchical' 	=> true,
		'labels' 		=> $labels,
		'show_ui' 		=> true,
		'query_var' 	=> true,
		'rewrite' 		=> array( 'slug' => 'frascati', 'with_front' => true, 'feeds' => true ) ,
	) );
	
	$labels = array(
		'name' 				=> _x( 'Πακέτα Λογισμικού', 'γενικό όνομα', 'ma-ellak' ),
		'singular_name' 	=> _x( 'Πακέτα Λογισμικού', 'γενικό όνομα', 'ma-ellak' ),
		'search_items' 		=>  __( 'Αναζήτηση Πακέτου', 'ma-ellak' ),
		'all_items' 		=> __( 'Όλα τα Πακέτα', 'ma-ellak' ),
		'parent_item' 		=> __( 'Γονικό Πακέτο', 'ma-ellak' ),
		'parent_item_colon' => __( 'Γονικό Πακέτο', 'ma-ellak' ),
		'edit_item' 		=> __( 'Επεξεργασία Πακέτου', 'ma-ellak' ),
		'update_item' 		=> __( 'Ενημέρωση Πακέτου', 'ma-ellak' ),
		'add_new_item' 		=> __( 'Προσθήκη Πακέτου', 'ma-ellak' ),
		'new_item_name' 	=> __( 'Προσθήκη Πακέτου', 'ma-ellak' ),
		'menu_name' 		=> __( 'Πακέτα Λογισμικού', 'ma-ellak' ),
	);

	register_taxonomy( 'package', array( 'software', 'job', 'profile'), array(
		'hierarchical' 	=> true,
		'labels' 		=> $labels,
		'show_ui' 		=> true,
		'query_var' 	=> true,
		'rewrite' 		=> array( 'slug' => 'package', 'with_front' => true, 'feeds' => true ) ,
	) );
	
}

// Εγγραφή του Σύνθετου Τύπου Λογισμικό (Software) [1/2]
add_action( 'init', 'ma_ellak_register_software_posttype', 0 );

// Εγγραφή του Σύνθετου Τύπου Λογισμικό (Software) [2/2]
function ma_ellak_register_software_posttype() {
	$labels = array(
		'name' 					=> _x( 'Λογισμικά', 'γενικό όνομα', 'ma-ellak' ),
		'singular_name' 		=> _x( 'Λογισμικό', 'γενικό όνομα', 'ma-ellak' ),
		'add_new' 				=> _x( 'Προσθήκη Νέου', 'Λογισμικού', 'ma-ellak' ),
		'add_new_item'			=> __( 'Προσθήκη Νέου Λογισμικού', 'ma-ellak' ),
		'edit_item' 			=> __( 'Επεξεργασία Λογισμικού', 'ma-ellak' ),
		'new_item' 				=> __( 'Νέο Λογισμικό', 'ma-ellak' ),
		'all_items' 			=> __( 'Όλα τα Λογισμικά', 'ma-ellak' ),
		'view_item' 			=> __( 'Προβολή Λογισμικών', 'ma-ellak' ),
		'search_items' 			=> __( 'Αναζήτηση Λογισμικού', 'ma-ellak' ),
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
		'rewrite' 				=> array( 'slug' => 'software', 'with_front' => true, 'feeds' => true ) ,
		'capability_type' 		=> 'post',
		'hierarchical' 			=> false,
		'menu_position' 		=> null,
		'supports' 				=> array( 'title', 'author', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions', 'custom-fields' ),
		'taxonomies' 			=> array('post_tag')
	);

	register_post_type( 'software' , $args  );
}

global $ma_prefix;
global $software_fields;

$software_fields = array(
	array(
		'name' => __('Λογότυπο', 'ma-ellak'),
		'desc' => __('Ανεβάστε το λογότυπο του Λογισμικού', 'ma-ellak'),
		'id'   => $ma_prefix . 'software_logo',
		'type' => 'file',
	),
	array(
		'name' => __('Δικτυακός Τόπος', 'ma-ellak'),
		'desc' => __('Σύνδεσμος πρός το δικτυακό τόπο του Λογισμικού', 'ma-ellak'),
		'id'   => $ma_prefix . 'software_website_url',
		'type' => 'text',
	),
	array(
		'name' => __('Σύνδεσμος Αποθετηρίου', 'ma-ellak'),
		'desc' => __('Σύνδεσμος πρός το αποθετήριο που φιλοξενείται το λογισμικό', 'ma-ellak'),
		'id'   => $ma_prefix . 'software_repository_url',
		'type' => 'text',
	),
	array(
		'name' => __('Υπεύθυνος', 'ma-ellak'),
		'desc' => __('Τα στοιχεία του Υπεύθυνου επικοινωνίας για το Λογισμικό', 'ma-ellak'),
		'id'   => $ma_prefix . 'software_contact',
		'type' => 'textarea_small',
	),
	array(
		'name' => __('Τεχνικά Χαρακτηριστικά', 'ma-ellak'),
		'desc' => __('Τα τεχνικά χαρακτηριστικά του Λογισμικού', 'ma-ellak'),
		'id'   => $ma_prefix . 'software_specifications',
		'type' => 'textarea',
	),
		array(
				'name' => __('Πηγή λογισμικού', 'ma-ellak'),
				'desc' => __('Από που προστέθηκε το λογισμικό (με το χέρι, sourceforge,github)', 'ma-ellak'),
				'id'   => $ma_prefix . 'software_repository_source',
				'type' => 'text',
		),
);

// Δηλώνουμε την εμφάνιση του metabox για τον τύπο αντικειμένου Λογισμικό [1/2]
add_filter( 'cmb_meta_boxes', 'ma_ellak_software_metabox' );

// Δηλώνουμε την εμφάνιση του metabox για τον τύπο αντικειμένου Λογισμικό [2/2]
function ma_ellak_software_metabox( array $meta_boxes ) {

	global $software_fields;
	
	$meta_boxes[] = array(
		'id'         => 'software_metabox',
		'title'      => __('Πληροφορίες Λογισμικού', 'ma-ellak'),
		'pages'      => array( 'software'), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => $software_fields,
	);
	
	return $meta_boxes;
}

// Αρχικοποιεί εφόσον δεν έχει γίνει ήδη τη βιβλιοθήκη των MetaBoxes [1/2]
add_action( 'init', 'ma_ellak_yp2_meta_boxes', 9999 );

// Αρχικοποιεί εφόσον δεν έχει γίνει ήδη τη βιβλιοθήκη των MetaBoxes [2/2]
function ma_ellak_yp2_meta_boxes() {
	if ( ! class_exists( 'cmb_Meta_Box' ) ) require_once (TEMPLATEPATH . '/scripts/metabox/init.php');
}


// Προσθέτει javascripts και css styles [1/2]
function ma_ellak_yp2_scripts() {
	
	$template_dir =  get_bloginfo('template_directory');
	
	// Το θέλουμε στην ακόλουθη σελίδα (template: Δημόσια φόρμα Προσθήκης Λογισμικού)
	if ( is_page_template('ma_ellak_yp2_tmpl_add_software.php') or is_page_template('ma_ellak_yp2_tmpl_edit_software.php')) {
		wp_enqueue_style( 'ma_ellak_chosen_css', $template_dir . '/scripts/tagselect/chosen/chosen.css' );
		wp_enqueue_style( 'ma_ellak_tagselect_css',  $template_dir . '/scripts/tagselect/tagselect.css');
			
		wp_enqueue_script( 'ma_ellak_chosen_js', $template_dir . '/scripts/tagselect/chosen/chosen.jquery.min.js', array('jquery'), '1.0', true );
		wp_enqueue_script( 'ma_ellak_tagselect_js',  $template_dir . '/scripts/tagselect/tagselect.js',  array('jquery'), '1.0', true );
	
		wp_enqueue_script( 'ma_ellak_validate',  $template_dir . '/js/jquery.validate.min.js',  array('jquery'), '1.0', true );
		wp_enqueue_script( 'ma_ellak_validate_yp2',  $template_dir . '/js/validate_yp2_tmpl_add_software.js',  array('jquery'), '1.0', true );
	}
	
	if ( is_page_template('ma_ellak_yp2_tmpl_add_software.php')){
		wp_enqueue_script( 'ma_ellak_fetch_data_yp2',  $template_dir . '/js/validate_yp2_tmpl_add_software_fetcher.js',  array('jquery'), '1.0', true );
		wp_localize_script( 'ma_ellak_fetch_data_yp2', 'ma_ellak_fetch_settings', array(
			'fetcher_url' => get_permalink(get_option_tree('ma_ellak_json_sourceforge_fetch'))
		) );
	}
	
	if ( is_page_template('ma_ellak_yp2_tmpl_edit_software.php')) {
		wp_enqueue_script( 'ma_ellak_edit_yp2',  $template_dir . '/js/validate_yp2_tmpl_edit_software.js',  array('jquery'), '1.0', true );
	}
	
	global $post;
	if(get_post_type($post->ID) == 'software'){
		wp_enqueue_script( 'ma_ellak_single_yp2',  $template_dir . '/js/validate_yp2_tmpl_list_software.js',  array('jquery'), '1.0', true );
		wp_enqueue_script( 'ajax_state_used_it', $template_dir . '/js/ajax_state_used_seftware.js', array( 'jquery' ), '1.0', true );
		wp_localize_script( 'ajax_state_used_it', 'ajax_state_used_it_settings', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'req_nonce' => wp_create_nonce("ma_ellak_state_used_it_nonce"),
			'success_msg' => __('Η ψήφος σας καταχωρήθηκε!', 'ma-ellak'),
			'error_msg' => __('Προέκυψε σφάλμα!', 'ma-ellak'),
		) );
	}
}

// Προσθέτει javascripts και css styles [2/2]
add_action( 'wp_enqueue_scripts', 'ma_ellak_yp2_scripts', 11 );

// Αποθηκεύει τα έξτρα πεδία (post meta) απο τη φόρμα front-end υποβολής
function ma_ellak_software_save_details( $post_id ){
	global $software_fields;
	
	foreach($software_fields as $field){		
		if ( isset( $_POST[$field['id']]) )
			update_post_meta( $post_id, $field['id'],  $_POST[$field['id']] );
	}
}

function insert_attachment($file_handler, $post_id, $meta_name) {

  if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();

  require_once(ABSPATH . "wp-admin" . '/includes/image.php');
  require_once(ABSPATH . "wp-admin" . '/includes/file.php');
  require_once(ABSPATH . "wp-admin" . '/includes/media.php');

  $attach_id = media_handle_upload( $file_handler, $post_id );

  $attach_url = wp_get_attachment_url( $attach_id );
  
  update_post_meta($post_id, $meta_name, $attach_url);
  
}

function ma_ellak_get_used_by($user_id = 0, $software_id = 0, $print_details = true){
	
	global $post;
	
	 if (! is_user_logged_in()) // Μόνο εγγεγραμμένοι χρήστες έχουν αυτό το δικαίωμα
		return __('Πρέπει να είστε Εγγεγραμμένοι χρήστες για να δηλώσετε οτι το έχετε χρησιμοποιήσει.','ma-ellak');
		
	if($user_id == 0){
		$cur_user = wp_get_current_user();
		$user_id = $cur_user->ID; 
	}
	
	if($software_id == 0){
		$software_id = $post->ID; 
	}
	
	$software_voted = get_user_meta($user_id, 'all_software_used_by', true );  
	if (in_array($software_id, $software_voted)) {
		if($print_details){
				return __('Έχετε ήδη δηλώσει οτι έχετε χρησιμοποιήσει το Λογισμικό αυτό','ma-ellak');
			} else {
				return true;
			}
	}
	
	if($print_details){
		$form = '<a href="#" class="btn used-it" usr="'.$user_id.'" sid="'.$software_id .'">'.__('Δηλώστε οτι έχετε χρησιμοποιήσει το Λογισμικό','ma-ellak').'</a>';		
		return $form;
	} else {
		return false;
	}
	
}


class ma_ellak_Walker_TaxonomyDropdown extends Walker_CategoryDropdown{
 
    function start_el(&$output, $category, $depth, $args) {
        $pad = str_repeat('&nbsp;', $depth * 3);
        $cat_name = apply_filters('list_cats', $category->name, $category);
 
        if( !isset($args['value']) ){
            $args['value'] = ( $category->taxonomy != 'category' ? 'slug' : 'id' );
        }
 
        $value = ($args['value']=='slug' ? $category->slug : $category->term_id );
 
        $output .= "\t<option class=\"level-$depth\" value=\"".$value."\"";
        if ( $value === (string) $args['selected'] ){ 
            $output .= ' selected="selected"';
        }
        $output .= '>';
        $output .= $pad.$cat_name;
        if ( $args['show_count'] )
            $output .= '&nbsp;&nbsp;('. $category->count .')';
 
        $output .= "</option>\n";
        }
 
}

function software_keyword_search( $where, &$wp_query ){
    global $wpdb;

	$where .= ' AND (' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( like_escape( $_GET['keyword'] ) ) . '%\'';
	$where .= ' OR ' . $wpdb->posts . '.post_content LIKE \'%' . esc_sql( like_escape( $_GET['keyword'] ) ) . '%\')';

	return $where;
}


function ma_ella_add_special_comment_fields( $comment_id ) {
	if(isset($_POST['ctitle']) and $_POST['ctitle'] != '')
		add_comment_meta( $comment_id, 'title', $_POST['ctitle'] );
	if(isset($_POST['corganisation']) and $_POST['corganisation'] != '')
		add_comment_meta( $comment_id, 'organisation', $_POST['corganisation'] );
	if(isset($_POST['ctype']) and $_POST['ctype'] != '')
		add_comment_meta( $comment_id, 'type', $_POST['ctype'] );
}
add_action( 'comment_post', 'ma_ella_add_special_comment_fields' );

?>