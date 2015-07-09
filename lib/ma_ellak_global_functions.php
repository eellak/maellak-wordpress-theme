<?php
/**
* Αρχείο συναρτήσεων συνολικά για την εγκατάσταση του Wordpress
*
* @licence GPL
* @author Fotis Routsis - fotis@routsis.gr
* 
* Project URL http://ma.ellak.gr
*/

// Εγγραφή της Ταξονομίας 'Θεματική' [1/2]
add_action( 'init', 'ma_ellak_register_thematic_taxonomy', 1 );

// Εγγραφή της Ταξονομίας 'Θεματική' [2/2]
function ma_ellak_register_thematic_taxonomy() {
	$labels = array(
		'name' 				=> _x( 'Θεματικές', 'γενικό όνομα', 'ma-ellak' ),
		'singular_name' 	=> _x( 'Θεματική', 'γενικό όνομα', 'ma-ellak' ),
		'search_items' 		=>  __( 'Αναζήτηση Θεματικής', 'ma-ellak' ),
		'all_items' 		=> __( 'Όλες οι Θεματικές', 'ma-ellak' ),
		'parent_item' 		=> __( 'Γονική Θεματική', 'ma-ellak' ),
		'parent_item_colon' => __( 'Γονική Θεματική:', 'ma-ellak' ),
		'edit_item' 		=> __( 'Επεξεργασία Θεματικής', 'ma-ellak' ),
		'update_item' 		=> __( 'Ενημέρωση Θεματικής', 'ma-ellak' ),
		'add_new_item' 		=> __( 'Προσθήκη Θεματικής', 'ma-ellak' ),
		'new_item_name' 	=> __( 'Προσθήκη Θεματικής', 'ma-ellak' ),
		'menu_name' 		=> __( 'Θεματικές', 'ma-ellak' ),
	);

	register_taxonomy( 'thema', array( 'post', 'software', 'unit','events','video','document' ), array(
		'hierarchical' 	=> true,
		'labels' 		=> $labels,
		'show_ui' 		=> true,
		'query_var' 	=> true,
		'rewrite' 		=> array( 'slug' => 'thema', 'with_front' => true, 'feeds' => true ) ,
	) );

}

// Εγγραφή του Custom Type 'Slider' [1/2]
add_action( 'init', 'ma_ellak_register_slider' );

// Εγγραφή του Custom Type 'Slider' [2/2]
function ma_ellak_register_slider() {
	$labels_slider= array(
		'name' => _x('Slider Entries', 'post type general name'),
		'singular_name' => _x('Slider Entry', 'post type singular name'),
		'add_new' => _x('Add New', 'databse'),
		'add_new_item' => __('Add New Slider Entry'),
		'edit_item' => __('Edit Slider Entry'),
		'new_item' => __('New Slider Entry'),
		'all_items' => __('All Slider Entries'),
		'view_item' => __('View Slider Entry'),
		'search_items' => __('Search Slider Entries'),
		'not_found' =>  __('No Slider Entries found'),
		'not_found_in_trash' => __('No Slider Entries found in Trash'), 
		'parent_item_colon' => '',
		'menu_name' => __('Slider')
	);
	
	$args_slider = array(
		'labels' => $labels_slider,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'show_in_menu' => true, 
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => true, 
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array( 'title', 'editor' ),
			
	); 
	register_post_type( 'slider' , $args_slider );
}


// Δηλώνουμε την εμφάνιση του metabox για τον τύπο αντικειμένου Slider [1/2]
add_filter( 'cmb_meta_boxes', 'ma_ellak_slider_metabox' );

// Δηλώνουμε την εμφάνιση του metabox για τον τύπο αντικειμένου Slider [2/2]
function ma_ellak_slider_metabox( array $meta_boxes ) {
	
	global $ma_prefix;

	$meta_boxes[] = array(
		'id'         => 'slider_link',
		'title'      => __('Εσωτερικός Σύνδεσμος', 'ma-ellak'),
		'pages'      => array( 'slider'), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
				array(
					'name' => __('Εσωτερικός Σύνδεσμος', 'ma-ellak'),
					'desc' => __('Ορίστε τον Εσωτερικό Σύνδεσμο που θα οδηγεί το Slider', 'ma-ellak'),
					'id'   => $ma_prefix . 'slider_link',
					'type' => 'text',
				),
				array(
					'name' => __('Τίτλος Συνδέσμου', 'ma-ellak'),
					'desc' => __('Ορίστε τον Τίτλο του Εσωτερικού Συνδέσμου που θα οδηγεί το Slider', 'ma-ellak'),
					'id'   => $ma_prefix . 'slider_link_title',
					'type' => 'text',
				),
				array(
					'name' => __('Εικόνα Slider', 'ma-ellak'),
					'desc' => __('Ορίστε την Εικόνα του Slider', 'ma-ellak'),
					'id'   => $ma_prefix . 'slider_image',
					'type' => 'file',
				)
			),
	);
	
	return $meta_boxes;
}


// Αφαιρεί τη δυνατότητα σε μη Administrators να έχουν πρόσβαση στο backend [1/2]
add_action( 'admin_init', 'redirect_non_admin_users' );

// Αφαιρεί τη δυνατότητα σε μη Administrators να έχουν πρόσβαση στο backend [2/2]
function redirect_non_admin_users() {
	global $pagenow;
	
	$valid_pages = array('admin-ajax.php', 'async-upload.php', 'media-upload.php');
	
	 if (!in_array( $pagenow, $valid_pages ) ) {
		 if (!current_user_can('activate_plugins') && !(defined('DOING_AJAX') && DOING_AJAX)) {
			wp_redirect( home_url() );
			exit;
		}
	}
}

// Επιστρέφει τον σύνδεσμο προς το Buddypress Group με βάση το ID της Θεματικής
// $thema_id: το ID της Θεματικής
// $clickable: αν true επιστρέφει πλήρη σύνδεσμο <a href=..> αλλιώς μόνο το URL
// $title: αν true επιστρέφει στον πλήρη σύνδεσμο το όνομα του Group ως το clickable κείμενο
function ma_ellak_get_thema_link($thema_id, $clickable = false, $title= false){
	global $bp;
	$options = get_option('ma_ellak_thema_bp_match');
	$options = (is_string($options)) ? @unserialize($options) : $options;
	$options = $options['ma_ellak_thema_bp'];
	
	$bp_id = 0;
	$bp_id = array_search($thema_id, $options); 
	
	if(!empty($bp_id) and $bp_id !=0){
		$group = groups_get_group( array( 'group_id' => $bp_id ) );
		$link = home_url( $bp->groups->slug . '/' . $group -> slug );
		if($clickable){
			$url = '<a href="'.$link.'" ';
			if($title)
				$url .= 'title="'.$group -> name.'" ';
			$url .= '>';
			if($title)
				$url .= $group -> name;
			else
				$url .= $link;
			$url .= '</a>';
			return $url;
		} else {
			return $link;
		}
	}
	wp_reset_query();
}

// Προσθέτει Κλάσεις στο <body class> [1/2]
add_filter('body_class','ma_ellak_class_names');

// Προσθέτει Κλάσεις στο <body class> [2/2]
function ma_ellak_class_names($classes) {
	global $post;
	
	$classes = array();
	if(is_home())
		$classes[] = 'home';
	else if(get_post_type($post->ID) == 'unit')
		$classes[] = 'partner';
	else if(is_page_template('ma_ellak_yp6_live_streaming.php'))
			$classes[] = 'livestreaming';
	else if(get_post_type($post->ID) == 'video')
		$classes[] = 'video';
	else if(bp_current_component() !== false){
		$classes[] = 'partner';
	}else
		$classes[] = 'events';
		
	return $classes;
}

function ma_body_id(){
	if(bp_current_component() !== false)
		return 'id="buddypress"';
}

// Προβάλλει σε μορφή type n search τα δεδομένα μιας ταξονομίας
// Είσοδος: 
// 1. Το αντικείμενο μιας ταξονομίας (παράγεται απο το $tax = get_taxonomy('__taxonomy_slug__'); - Object
// 2. To όνομα της μεταβλητής του select - String
// 3. Αν θα δίνει το id ή το slug στο option value - Boolean: true:id, false:slug (default)
// Απαιτεί τα ακόλουθα στοιεία να γίνουν enqueue:
// 1. /scripts/tagselect/chosen/chosen.jquery.min.js
// 2. /scripts/tagselect/chosen/chosen.css
// 3. /scripts/tagselect/tagselect.js
// 4. /scripts/tagselect/tagselect.css
function ma_ellak_add_term_chosebox($tax, $name, $id = false,$post_terms=null){
	$terms = get_terms(
		$tax->name,
		array( 'hide_empty' => false )
	);
	
	if(empty($post_terms)) $post_terms = array();
	
	$output = '<div class="tagselect-wrap"><div id="thema-all" class="tagselect-select-wrap">';
	$output .= '<select class="tagselect-select" name="'.$name.'[]" multiple="multiple" data-placeholder=" '.__('Επιλέξτε', 'ma-ellak').' '.$tax->label.'&hellip;">';
	$output .= '<option value=""></option>';
	foreach ( (array) $terms as $term ) {
		if($id)
			$output .= "<option value=\"{$term->term_id}\"" . ( in_array( $term->term_id, $post_terms ) ? ' selected="selected"' : '' ) . '>' . __( $term->name ) . '</option>';
		else
			$output .= "<option value=\"{$term->slug}\"" . ( in_array( $term->slug, $post_terms ) ? ' selected="selected"' : '' ) . '>' . __( $term->name ) . '</option>';
	}
	$output .= '</select></div></div>';
	
	return $output;
}

function ma_ellak_add_thema_term_chosebox( $name, $id = false, $post_terms=null){

	$terms = get_terms(
		'thema',
		array( 'hide_empty' => false )
	);
	
	if(empty($post_terms)) $post_terms = array();
	
	// Get current User ID
	$cur_user = wp_get_current_user();	
	$groups = BP_Groups_Member::get_group_ids( $cur_user->ID );	
	$themaz = array();
	foreach($groups['groups'] as $group_id){
		$themaz[] = intval(ma_ellak_get_thema_id_by_bp_groups_id($group_id));
	}
	//print_r($groups['groups'] );
	//print_r($themaz);
	
	$output = '<div class="tagselect-wrap"><div id="thema-all" class="tagselect-select-wrap">';
	$output .= '<select class="tagselect-select" name="'.$name.'[]" multiple="multiple" data-placeholder=" '.__('Επιλέξτε', 'ma-ellak').' '.__('Θεματική', 'ma-ellak').'&hellip;">';
	$output .= '<option value=""></option>';
	foreach ( (array) $terms as $term ) {
		if(!in_array(intval($term->term_id), $themaz)) { continue; }
		if($id)
			$output .= "<option value=\"{$term->term_id}\"" . ( in_array( $term->term_id, $post_terms ) ? ' selected="selected"' : '' ) . '>' . __( $term->name ) . '</option>';
		else
			$output .= "<option value=\"{$term->slug}\"" . ( in_array( $term->slug, $post_terms ) ? ' selected="selected"' : '' ) . '>' . __( $term->name ) . '</option>';
	}
	$output .= '</select></div></div>';
	
	return $output;
}

function the_excerpt_max_charlength($charlength) {
	
	$excerpt = get_the_excerpt();
	$charlength++;

	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			echo mb_substr( $subex, 0, $excut );
		} else {
			echo $subex;
		}
		echo ' ... ';
	} else {
		echo $excerpt;
	}
}


// Είσοδος: 
// 1. Το αντικείμενο μιας ταξονομίας (παράγεται απο το $tax = get_taxonomy('__taxonomy_slug__'); - Object
// 2. To όνομα της μεταβλητής του select - String
// 3. Αν θα δίνει το id ή το slug στο option value - Boolean: true:id, false:slug (default)
// 4. Πίνακας που κρατάει την επιλογή του χρήστη $post_terms: array
// Απαιτεί τα ακόλουθα στοιεία να γίνουν enqueue:
// 1. /scripts/tagselect/chosen/chosen.jquery.min.js
// 2. /scripts/tagselect/chosen/chosen.css
// 3. /scripts/tagselect/tagselect.js
// 4. /scripts/tagselect/tagselect.css
function ma_ellak_choose_one_term($tax, $name, $id = false, $post_terms=false){
	$terms = get_terms(
		$tax->name,
		array( 'hide_empty' => false )
	);
	if(empty($post_terms)) $post_terms = array();
	$output = '<p><div class="tagselect-wrap"><div class="tagselect-select-wrap">';
	$output .= '<select class="tagselect-select" name="'.$name.'" data-placeholder=" '.__('Επιλέξτε', 'ma-ellak').' '.$tax->label.'&hellip;">';
	$output .= '<option value=""></option>';

	foreach ( (array) $terms as $term ) {
		if($id)
			$output .= "<option value=\"{$term->term_id}\"" . ( in_array( $term->term_id, $post_terms ) ? ' selected="selected"' : '' ) . '>' . __( $term->name ) . '</option>';
		else
			$output .= "<option value=\"{$term->slug}\"" . ( in_array( $term->slug, $post_terms ) ? ' selected="selected"' : '' ) . '>' . __( $term->name ) . '</option>';
	}
	$output .= '</select></div></div></p>';
	
	return $output;
}

// Προσθέτει τα Global CSS και JS αρχεία
function ma_ellak_global_theme_scripts_css(){
	$template_dir =  get_bloginfo('template_directory');
	//css
	wp_enqueue_style( 'ma_ellak_bootstrap_css', $template_dir . '/css/bootstrap.min.css' );
	wp_enqueue_style( 'ma_ellak_bootstrap_responsive_css', $template_dir . '/css/bootstrap-responsive.min.css' );
	wp_enqueue_style( 'ma_ellak_datepicker_css', $template_dir . '/css/datepicker.css' );
	wp_enqueue_style( 'ma_ellak_main_css', $template_dir . '/css/main.css' );
/*	wp_enqueue_style( 'ma_ellak_tooltip_css', $template_dir . '/css/tooltip.css' );
	wp_enqueue_style( 'ma_ellak_prettify_css', $template_dir . '/js/vendor/google-code-prettify/prettify.css' );
	
	wp_enqueue_script( 'ma_ellak_carousel_js', $template_dir . '/js/vendor/bootstrap/bootstrap-carousel.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'ma_ellak_transition_js', $template_dir . '/js/vendor/bootstrap/bootstrap-transition.js', array('jquery'), '1.0', true );
	//for menu
	wp_enqueue_script( 'ma_ellak_modal_js', $template_dir . '/js/vendor/bootstrap/bootstrap-modal.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'ma_ellak_dropdown_js', $template_dir . '/js/vendor/bootstrap/bootstrap-dropdown.js', array('jquery'), '1.0', true );
	//for tabs
	wp_enqueue_script( 'ma_ellak_tab_js', $template_dir . '/js/vendor/bootstrap/bootstrap-tab.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'ma_ellak_alert_js', $template_dir . '/js/vendor/bootstrap/bootstrap-alert.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'ma_ellak_scrollspy_js', $template_dir . '/js/vendor/bootstrap/bootstrap-scrollspy.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'ma_ellak_tooltip_js', $template_dir . '/js/vendor/bootstrap/bootstrap-tooltip.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'ma_ellak_popover_js', $template_dir . '/js/vendor/bootstrap/bootstrap-popover.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'ma_ellak_button_js', $template_dir . '/js/vendor/bootstrap/bootstrap-button.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'ma_ellak_collapse_js', $template_dir . '/js/vendor/bootstrap/bootstrap-collapse.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'ma_ellak_typeahead_js', $template_dir . '/js/vendor/bootstrap/bootstrap-typeahead.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'ma_ellak_datepicker_js', $template_dir . '/js/vendor/bootstrap/bootstrap-datepicker.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'ma_ellak_prettify_js', $template_dir . '/js/vendor/google-code-prettify/prettify.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'ma_ellak_modernizer_js', $template_dir . '/js/vendor/modernizr-2.6.2.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'ma_ellak_html5shiv_js', $template_dir . '/js/vendor/html5shiv.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'ma_ellak_holder_js', $template_dir . '/js/vendor/holder/holder.js', array('jquery'), '1.0', true );
*/	
	wp_enqueue_script( 'ma_ellak_validator_js', $template_dir . '/js/jquery.validate.min.js', array('jquery'), '1.0', true );	
	wp_enqueue_script( 'ma_ellak_bootstrap_js', $template_dir . '/js/vendor/bootstrap/bootstrap.min.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'ma_ellak_plugins_js', $template_dir . '/js/plugins.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'ma_ellak_main_js', $template_dir . '/js/main.js', array('jquery'), '1.0', true );
	
	if(is_home()){
		wp_enqueue_script( 'ma_ellak_newsletter_js', $template_dir . '/js/validate_newsletter.js', array('jquery'), '1.0', true );
		wp_localize_script( 'ma_ellak_newsletter_js', 'ma_ellak_newsletter_settings', array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'req_nonce' => wp_create_nonce("ma_ellak_register_newsletter_nonce"),
				'need_email'=> __('Το πεδίο είναι υποχρεωτικό!', 'ma-ellak'),
				'valid_email'=> __('Πρέπει να προσθέσετε ένα έγκυρο email.', 'ma-ellak'),
			) );
		wp_enqueue_script( 'ma_ellak_calendar_js', $template_dir . '/js/change_calendar.js', array('jquery'), '1.0', true );
		wp_localize_script( 'ma_ellak_calendar_js', 'ma_ellak_calendar_settings', array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'req_nonce' => wp_create_nonce("ma_ellak_change_calendar_nonce"),
			) );
	}
	
	wp_enqueue_script( 'ma_ellak_remove_upper_js', $template_dir . '/js/jquery.remove-upcase-accents.js', array('jquery'), '1.0', true );
	
	if(!is_edit_page()){
		wp_enqueue_script( 'ma_ellak_social', $template_dir . '/js/social_count.js', array('jquery'), '1.0', true );
	}
	
}
add_action( 'wp_enqueue_scripts', 'ma_ellak_global_theme_scripts_css', 111 );

// Function to see if it is edit page template
function is_edit_page(){
	
	$template_list = array(
		'ma_ellak_tmpl_edit_unit.php',
		'ma_ellak_yp2_tmpl_add_software.php',
		'ma_ellak_yp2_tmpl_edit_software.php',
		'ma_ellak_yp3_tmpl_add_characteristic.php',
		'ma_ellak_yp3_tmpl_edit_characteristic.php',
		'ma_ellak_yp4_tmpl_add_job.php',
		'ma_ellak_yp4_tmpl_edit_job.php',
		'ma_ellak_yp4_tmpl_add_profile.php',
		'ma_ellak_yp4_tmpl_edit_profile.php',
		'ma_ellak_yp7_tmpl_add_video.php',
		'ma_ellak_yp7_tmpl_update_video.php',
		'ma_ellak_yp9_tmpl_add_document.php',
		'ma_ellak_yp9_tmpl_update_document.php',
		'ma_ellak_events_tmpl_add_event.php',
		'ma_ellak_events_tmpl_update_event.php'
	);
	
	$template_name = get_page_template_slug();
	if( in_array($template_name, $template_list))
		return true;
	
	return false;
}

/**
 * Function that prints the thema of a post type
 * @param integer $cid the post type id 
 * @param string $slug the thema name
 */
function ma_ellak_print_thema($cid,$slug){
	
	$terms = get_the_terms( $cid, $slug );
	if ( $terms && ! is_wp_error( $terms ) ) :
	
	$draught_links = array();
	
	foreach ( $terms as $term ) {
		//$draught_links[] = '<a href="'.ma_ellak_get_thema_link($term->term_id).'">'.$term->name.'</a>';
		$draught_links[] = ma_ellak_get_thema_link($term->term_id, true, true);
		
		
	}
	
	$on_draught = join( ", ", $draught_links );
	echo "&nbsp;".__( 'ΣΕ', 'ma-ellak' );
	echo' <strong class="petrol">';
	echo $on_draught;
	echo "</strong>";
	endif;
}

/**
 * Function that returns all thema of a post type without links
 * @param integer $cid the post type id
 * @param string $slug the thema name
 */
function ma_ellak_return_thema_rss($cid,$slug){
	$terms = get_the_terms( $cid, $slug );
	if ( $terms && ! is_wp_error( $terms ) ) :
		$draught_links = array();
		foreach ( $terms as $term ) {
			$obj=get_term_by('id', $term->term_id, 'thema');
			$draught_names[]=$obj->name;
		}
	endif;
	return $draught_names;
}


/**
 * Function that prints the unit title of a post type
 * @param integer $post_id the post type id 
 */
function ma_ellak_print_unit_title($post_id){
	$data=ma_ellak_return_unit_title($post_id);
	if ($data!='')
		echo $data;
}

/**
 * Function that returns the unit title of a post type (with stylesheet)
 * @param integer $post_id the post type id 
 */
function ma_ellak_return_unit_title($post_id){
	$unit_id = get_post_meta($post_id, '_ma_ellak_belongs_to_unit', true);
	$data="";
	if ($unit_id!=''){
		$unit_title=get_the_title($unit_id);
		$data.= __( 'ΑΠΟ', 'ma-ellak' );
		$data.=' <a href="'.get_permalink($unit_id).'"><strong class="magenta">';
		$data.= $unit_title;
		$data.="</strong></a>";
	}
	return $data;
}

/**
 * Create an array with the number of custom types
 */

function ma_ellak_get_number_of_custom_types(){
	
	$data =  array();
	global $bp;
	$i=0;
	if(get_option_tree('ma_ellak_list_event_option_id')!=''){
	$data[$i]['type']='events';
	$count_posts = wp_count_posts('events');
	$data[$i]['num']=$count_posts->publish;
	$data[$i]['title'] =__('Εκδηλώσεις','ma_ellak');
	$EventsListId = get_option_tree('ma_ellak_list_event_option_id');
	$data[$i]['url']=get_permalink($EventsListId) ;
	$i++;
	}
	if(get_option_tree('ma_ellak_list_video_option_id')!=''){
		$data[$i]['type']='video';
		$count_posts = wp_count_posts('video');
		$data[$i]['num']=$count_posts->publish;
		$data[$i]['title'] =__('Βίντεο','ma_ellak');
		$VideoId = get_option_tree('ma_ellak_list_video_option_id');
		$data[$i]['url']=get_permalink($VideoId) ;
		$i++;
	}	
	$data[$i]['type']='units';
	$count_posts = wp_count_posts('unit');
	$data[$i]['num']=$count_posts->publish;
	$data[$i]['title'] =__('Μονάδες','ma_ellak');
	$data[$i]['url']='#';
	$i++;
	$data[$i]['type']='members';
	/* manolis: get the total number of wordpress users
	            instead. buddypress has no api docs

	$data[$i]['num']=bp_core_get_active_member_count();
	*/
	$total_wp_users = count_users();
	$data[$i]['num'] = $total_wp_users['total_users'];
	$data[$i]['title']=__('Μέλη','ma_ellak');
	$data[$i]['url']=$bp->root_domain . '/members/';
	$i++;
	if(get_option_tree('ma_ellak_list_profiles')!=''){
	$data[$i]['type']='profile';
	$count_prof = wp_count_posts('profile');
	$data[$i]['num']=$count_prof->publish;
	$data[$i]['title']=__('Προφιλ','ma_ellak');
	$profid = get_option_tree('ma_ellak_list_profiles');
	$data[$i]['url']= get_permalink($profid) ;
	$i++;
	}
	if(get_option_tree('ma_ellak_list_jobs')!=''){
	
		$data[$i]['type']='job';
		$count_job = wp_count_posts('job');
		$data[$i]['num']=$count_job->publish;
		$data[$i]['title']=__('Εργασίες','ma_ellak');
		$jobid = get_option_tree('ma_ellak_list_jobs');
		$data[$i]['url']= get_permalink($jobid) ;
		$i++;
	}
	return $data;
}

/**
 * Creates a filter for the post_date. It is used for a query
 */
function post_date_filter( $where){
    global $wpdb;
	$today=date('Y-m-d');
	$where .= " AND (". $wpdb->posts .".post_date>='". $today ."')";

	return $where;
}

/**
 * Returns an array with data (title, link, type, post_id) for the posts that have publishing date >=today
 * $limit the number of posts
 */
function ma_ellak_posts_array($limit){
	$args = array(
        'post_type' => 'post',
        'posts_per_page' => $limit,
        'post_status' => 'publish',
		'orderby' => 'post_date',
        'order' => 'DESC'
	);
	add_filter( 'posts_where', 'post_date_filter', 10, 1);
	$wp_query=new WP_Query($args);

	$data=array();
	if ( $wp_query->have_posts() ) :
		$i=0;
		while ( $wp_query->have_posts() ) : $wp_query->the_post();
			$post_id=get_the_ID();
			$title=get_the_title();
			$link=get_permalink();
			$type='post';
			$date=get_the_date();
			$data[$i]['title']=$title;
			$data[$i]['link']=$link;
			$data[$i]['type']=$type;
			$data[$i]['id']=$post_id;
			$data[$i]['date']=$date;
			$i++;
		endwhile;
	endif;
	return $data;
}

function ma_ellak_latest_array($limit){
	
	$posts = ma_ellak_posts_array($limit);
	$Streams = ma_ellak_streaming_array($limit);
	$newArray = array_merge($posts,$Streams);
	
	return $newArray;
}

// Εκτυπώνει όλες τις Θεματικές ως Buddypress Groups
function ma_ellak_list_all_thema_as_groups($before = '', $after = '', $with_icons = false , $width = 50, $height = 50){
	
	global $bp;
	
	$groups = groups_get_groups() ;
	
	foreach($groups['groups'] as $group){
		//print_r($group);
		
		echo $before;
		if($with_icons){
			echo '<span class="accordion-graphic">';
			$avatar_options = array ( 'item_id' => $group -> id, 'object' => 'group', 'type' => 'full', 'avatar_dir' => 'group-avatars', 'alt' => 'Group avatar', 'css_id' => '', 'class' =>'avatar', 'width' => $width, 'height' => $height, 'html' => true );
			echo bp_core_fetch_avatar($avatar_options);
			echo '</span>';
		}?>
		<a href="<?php echo home_url( $bp->groups->slug . '/' . $group -> slug ); ?>"><?php echo $group -> name; ?></a>
		<?php
		echo  $after;
	}	

}

function is_current_user_admin($unit_id){
	
	global $post;
	$is_current_admin = true;
	
	if($unit_id == null or empty($unit_id )){
		global $post;
		if($post->post_type != 'unit')
			$unit_id = get_post_meta( $post->ID, '_ma_ellak_belongs_to_unit', true );
		else	
			$unit_id= $post->ID;
	}
	if(!is_user_logged_in())
		$is_current_admin = false;
	else{
		$cur_user = wp_get_current_user();
		$user_unit_id = 0;
		$user_unit_id = get_user_meta( $cur_user->ID , '_ma_ellak_admin_unit', true ); 
		if($user_unit_id == 0 or $user_unit_id == '' or empty($user_unit_id) or $user_unit_id != $unit_id)
			$is_current_admin = false;
	}
	
	return $is_current_admin;
}

function ma_ellak_user_is_post_admin($post_item){
	
	global $post;

	if($post_item == null or empty($post_item )){
		$post_item = $post;
	} 
	
	$can_edit = false;
	
	$unit_id = get_post_meta( $post_item->ID, '_ma_ellak_belongs_to_unit', true );
		
	// Είναι διαχειριστής της ΜΑ στο οποίο ανήκει το άρθρο ;
	if(is_current_user_admin($unit_id))
		$can_edit = true;

	// Είναι Υπερδιαχειριστής ;
	if(current_user_can( 'activate_plugins'))
		$can_edit = true;
		
	return $can_edit;
}

function ma_ellak_user_can_edit_post($post_item){
	global $post;

	if($post_item == null or empty($post_item )){
		$post_item = $post;
	} 
	
	$can_edit = false;
	
	$unit_id = get_post_meta( $post_item->ID, '_ma_ellak_belongs_to_unit', true );
	
	// Είναι συγγραφέας του Άρθρου ;
	$cur_user = wp_get_current_user();
	if($post_item->post_author == $cur_user->ID)
		$can_edit = true;
		
	// Είναι διαχειριστής της ΜΑ στο οποίο ανήκει το άρθρο ;
	if(is_current_user_admin($unit_id))
		$can_edit = true;

	// Είναι Υπερδιαχειριστής ;
	if(current_user_can( 'activate_plugins'))
		$can_edit = true;
		
	return $can_edit;
}

function ma_ellak_single_edit_permalink($post_item){
	global $post;
	if($post_item == null or empty($post_item )){
		$post_item = $post;
	} 
	
	$print_link = false;
	
	$unit_id = get_post_meta( $post_item->ID, '_ma_ellak_belongs_to_unit', true );
	
	// Είναι συγγραφέας του Άρθρου ;
	$cur_user = wp_get_current_user();
	if($post_item->post_author == $cur_user->ID)
		$print_link = true;
		
	// Είναι διαχειριστής της ΜΑ στο οποίο ανήκει το άρθρο ;
	if(is_current_user_admin($unit_id))
		$print_link = true;

	// Είναι Υπερδιαχειριστής ;
	if(current_user_can( 'activate_plugins'))
		$print_link = true;
		
	if($print_link)
		echo '<a href="'.ma_ellak_edit_permalink($post_item->ID, $post_item->post_type).'" class="btn btn-success btn-medium ma_ellak_edit">'.__('Επεξεργασία','ma-ellak').'</a>';
}

function ma_ellak_edit_permalink($post_id = 0, $post_type = null){
	global $post;
	if($post_type == null or empty($post_type )){
		$type = $post->post_type;
	} else {
		$type = $post_type;
	}
	
	if($post_id == 0 or empty($post_id )){
		$the_id = $post->ID;
	} else {
		$the_id = $post_id;
	}
	
	switch($post_type){
		case('events'):
			return get_permalink(get_option_tree('ma_ellak_update_event'))."?id=".$the_id ;
			break;
		case('video'):
			return get_permalink(get_option_tree('ma_ellak_update_video'))."?id=".$the_id ;
			break;
		case('document'):
			return get_permalink(get_option_tree('ma_ellak_update_document'))."?doc_id=".$the_id ;
			break;
		case('characteristic'):
			return get_permalink(get_option_tree('ma_ellak_edit_characteristic'))."?gid=".$the_id ;
			break;
		case('unit'):
			return get_permalink(get_option_tree('ma_ellak_edit_unit'))."?uid=".$the_id ;
			break;
		case('software'):
			return get_permalink(get_option_tree('ma_ellak_edit_software'))."?sid=".$the_id ;
			break;
		case('profile'):
			return get_permalink(get_option_tree('ma_ellak_edit_profile'))."?pid=".$the_id ;
			break;
		case('job'):
			return get_permalink(get_option_tree('ma_ellak_edit_job'))."?jid=".$the_id ;
			break;
		default:
			return get_bloginfo('url');
	}
}

/**
 * Checks if a post has tags
 * and print them
 */

function ma_ellak_print_tags($post_id=''){
	if ($post_id!=''){
		global $post;
		$tmp=$post->ID;
		$post->ID=$post_id;
	}

	if(has_tag()){
		echo'<div class="tags">';
	  		the_tags('<ul class="inline unstyled magenta"><li class="bigger">(tags)</li><li>','</li><li>, ','</li></ul>');
	 	echo'</div>';
	}
	if ($post_id!='')
		$post->ID=$tmp;
}
 
 function ma_ellak_print_categories(){
		echo'<div class="tags">';
		echo'<span class="bigger magenta">(κατηγορίες):</span>';
		the_category(' , ');
		echo'</div>';
	
}

function array_to_obj($array, &$obj) {
    foreach ($array as $key => $value){
		if (is_array($value)){
			$obj->$key = new stdClass();
			array_to_obj($value, $obj->$key);
		} else {
			$obj->$key = $value;
		}
    }
	return $obj;
}

function arrayToObject($array){
	$object= new stdClass();
	return array_to_obj($array,$object);
}

/**
 * Function that returns PostType label
 * array('post','events','video','software', 'document', 'bp_doc');
 */
function get_posttype_label($posttypename,$eventtype=''){
	
	switch ($posttypename){
		case "post":
			return _e('ΑΡΘΡO','ma-ellak');
		case "events":
            if($eventtype!='')
                return get_event_type_label($eventtype);
                else
            return _e('ΕΚΔΗΛΩΣΗ','ma-ellak');
		case "video":
			return _e('ΒΙΝΤΕΟ','ma-ellak');
		case "software":
			return _e('ΛΟΓΙΣΜΙΚΟ','ma-ellak');
		case "document":
			return _e('ΑΡΧΕΙΟ','ma-ellak');
		case "bp_doc":
			return _e('WIKI','ma-ellak');
		case "characteristic":
			return _e('ΓΝΩΡΙΣΜΑ','ma-ellak');
		case "job":
			return _e('ΕΡΓΑΣΙΑ','ma-ellak');
		case "bp_group":
			return _e('ΘΕΜΑΤΙΚΗ','ma-ellak');
			case "unit":
				return _e('ΜΟΝΑΔΑ ΑΡΙΣΤΕΙΑΣ','ma-ellak');
		default:
			return $posttypename;
	}
	
}

function return_posttype_label($posttypename){

	switch ($posttypename){
		case "post":
			return __('ΑΡΘΡO','ma-ellak');
		case "events":
			return __('ΕΚΔΗΛΩΣΗ','ma-ellak');
		case "video":
			return __('ΒΙΝΤΕΟ','ma-ellak');
		case "software":
			return __('ΛΟΓΙΣΜΙΚΟ','ma-ellak');
		case "document":
			return __('ΑΡΧΕΙΟ','ma-ellak');
		case "bp_doc":
			return __('WIKI','ma-ellak');
		case "characteristic":
			return __('ΓΝΩΡΙΣΜΑ','ma-ellak');
		case "job":
			return __('ΕΡΓΑΣΙΑ','ma-ellak');
		case "bp_group":
			return __('ΘΕΜΑΤΙΚΗ','ma-ellak');
		case "unit":
			return __('ΜΟΝΑΔΑ ΑΡΙΣΤΕΙΑΣ','ma-ellak');
		default:
			return '';
	}

}
function is_anonymous_author($post_id = 0){
	$post_author = 0;
	
	if ($post_id == 0){
		global $post;
		$post_author = $post->post_author;
	} else {
		$data_post = get_post($post_id);
		$post_author = $data_post->post_author;
	}
	$user = ot_get_option('ma_ellak_anonymous_user');
	$user_data = get_user_by('email', $user );

	if($user_data->ID == $post_author)
		return true;
	return false;
}

function get_current_url() {
	 $pageURL = 'http';
	 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	 $pageURL .= "://";
	 if ($_SERVER["SERVER_PORT"] != "80") {
	  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	 } else {
	  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	 }
	 return $pageURL;
}

//Εκτυπώνει τα νούμερα των σελίδων ανάλογα με τον αριθμό των αποτελεσμάτων για κάθε αντικείμενο και εκτελεί το pagination
// Είσοδος:
// 1. $max_page ο αριθμός των σελίδων που προκύπτουν ανάλογα με τον αριθμό των αποτελεσμάτων
// 2. $paged ο αριθμός της εκάστοτε σελίδας
// 3. $wp_query το query που τρέχει για κάθε σελίδα
function pagination($max_page, $paged, $wp_query){
	?>
	<div class="row-fluid">
		<div class="pagination pagination-centered">
			<ul>
			<?php
				if ( !$max_page )
					$max_page = $wp_query->max_num_pages;
				if ( !$paged )
					$paged = 1;
				$paged = (intval(get_query_var('paged'))) ? intval(get_query_var('paged')) : 1;

				$nextpage = intval($paged) + 1;
				$current_page = max( 1, get_query_var('paged') );
				
				echo'<li><a class="first page button" href="'.get_pagenum_link(1).'">&laquo;</a></li>';
				echo'<li><a class="previous page button" href="'.get_pagenum_link(($current_page-1 > 0 ? $current_page-1 : 1)).'">&lsaquo;</a></li>';
				for ($i=1; $i<=$max_page; $i++){
					if ($i==$current_page)
						echo"<li class=\"active\">";
					else
						echo"<li>";
					echo"<a href=". get_pagenum_link($i) .">";
					echo $i ." ";
					echo"</a></li>";
				}
				echo "<li><a class='next page button' 
				href=".get_pagenum_link(($current_page+1 <= $wp_query->max_num_pages ? $current_page+1 : $wp_query->max_num_pages)).">&rsaquo;</a></li>";
				echo"<li><a class='last page button' href=".get_pagenum_link($wp_query->max_num_pages).">&raquo;</a></li>";
				
			?>
			
			</ul>
		</div> <!--closing links_of_posts div -->
	</div>
<?php

}

/**
 * function that returns the event type label
 * @param string $type the type of the event
 */
function get_event_type_label($event_type){
	if($event_type=='event')
		echo  __('ΕΚΔΗΛΩΣΗ','ma-ellak');
	if($event_type=='seminar')
		echo __('ΣΕΜΙΝΑΡΙΟ','ma-ellak');
	if($event_type=='seminar1')
		echo __('ΚΥΚΛΟΣ ΕΚΠΑΙΔΕΥΣΗΣ','ma-ellak');
	if($event_type=='school')
		echo __('ΣΧΟΛΕΙΟ ΑΝΑΠΤΥΞΗΣ ΚΩΔΙΚΑ','ma-ellak');
	if($event_type=='meeting')
		echo __('ΗΜΕΡΙΔΑ','ma-ellak');
	if($event_type=='summerschool')
		echo __('ΘΕΡΙΝΟ ΣΧΟΛΕΙΟ','ma-ellak');
	 
}

// Removes the More Button @http://wpengineer.com/1963/customize-wordpress-wysiwyg-editor/
function ma_ellak_change_mce_options($initArray) {
	if(!is_admin()){
		$ext = 'bold,italic,strikethrough,|,bullist,numlist,blockquote,|,justifyleft,justifycenter,justifyright,|,link,unlink,|,spellchecker,fullscreen,wp_adv';
		if ( isset( $initArray['theme_advanced_buttons1'] ) ) {
			$initArray['theme_advanced_buttons1'] = $ext;
		} 
	}
    return $initArray;
}
add_filter( 'tiny_mce_before_init', 'ma_ellak_change_mce_options' );

// Removes the More Button in HTML @http://www.onextrapixel.com/2012/10/08/10-tips-for-a-deeply-customised-wordpress-admin-area/
function ma_ellak_remove_quicktags( $qtInit , $editor_id){
	// 'strong,em,link,block,del,img,ul,ol,li,code,more,spell,close,fullscreen';
	$qtInit['buttons'] = 'strong,em,link,block,del,img,ul,ol,li,code,spell,close,fullscreen';
    return $qtInit;
}
add_filter('quicktags_settings', 'ma_ellak_remove_quicktags',2, 2);

/**
 * Filter the link query arguments to change the post types. 
 *
 * @param array $query An array of WP_Query arguments. 
 * @return array $query
 */
function my_custom_link_query( $query ){
	global $ma_ellak_content_types;
	$cur_user = wp_get_current_user();
	$user_unit_id = 0;
	$user_unit_id = get_user_meta( $cur_user->ID, '_ma_ellak_member_unit', true ); 
	
	if($user_unit_id != 0 or $user_unit_id =='' or empty($user_unit_id)) 
		$user_unit_id = get_user_meta( $cur_user->ID , '_ma_ellak_admin_unit', true ); 
	
	if($user_unit_id != 0)
		$query = array(
			'post_type' =>  $ma_ellak_content_types,
			'meta_key' => '_ma_ellak_belongs_to_unit',
			'meta_value' => $user_unit_id,
		);
	else
		$query = array(
			'post_type' =>  'nothing_to_show'
		);
		
	return $query ;
}

add_filter( 'wp_link_query_args', 'my_custom_link_query' );

// Προσθέτει τα Custom Post Types στη σελίδα των Tags
function query_post_type($query) {
	global  $ma_ellak_content_types; 
	$temp_types = $ma_ellak_content_types;
	$temp_types[] = 'post';
	if ( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {
		$post_type = get_query_var('post_type');
		if($post_type)
			$post_type = $post_type;
		else
			$post_type = $temp_types; // replace cpt to your custom post type
		$query->set('post_type',$post_type);
		return $query;
    }
}
add_filter('pre_get_posts', 'query_post_type');

?>
