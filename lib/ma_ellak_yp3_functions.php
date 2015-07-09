<?php
/**
* Αρχείο συναρτήσεων για την Υπηρεσία 2.
*
* @licence GPL
* @author Fotis Routsis - fotis@routsis.gr
* 
* Project URL http://ma.ellak.gr
*/

global $unit_fields;


// Εγγραφή του Σύνθετου Τύπου Γνώρισμα (characteristic) [1/2]
add_action( 'init', 'ma_ellak_register_characteristic_posttype', 0 );

// Εγγραφή του Σύνθετου Τύπου Γνώρισμα (characteristic) [2/2]
function ma_ellak_register_characteristic_posttype() {
	$labels = array(
		'name' 					=> _x( 'Γνώρισμα', 'γενικό όνομα', 'ma-ellak' ),
		'singular_name' 		=> _x( 'Γνώρισμα', 'γενικό όνομα', 'ma-ellak' ),
		'add_new' 				=> _x( 'Προσθήκη Νέου', 'Γνωρίσματος', 'ma-ellak' ),
		'add_new_item'			=> __( 'Προσθήκη Νέου Γνωρίσματος', 'ma-ellak' ),
		'edit_item' 			=> __( 'Επεξεργασία Γνωρίσματος', 'ma-ellak' ),
		'new_item' 				=> __( 'Νέο Γνωρίσματα', 'ma-ellak' ),
		'all_items' 			=> __( 'Όλα τα Γνωρίσματα', 'ma-ellak' ),
		'view_item' 			=> __( 'Προβολή Γνωρισμάτων', 'ma-ellak' ),
		'search_items' 			=> __( 'Αναζήτηση Γνωρίσματος', 'ma-ellak' ),
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
		'rewrite' 				=> array( 'slug' => 'characteristic', 'with_front' => true, 'feeds' => true ) ,
		'capability_type' 		=> 'page',
		'hierarchical' 			=> false,
		'menu_position' 		=> null,
		'supports' 				=> array( 'title', 'author', 'editor', 'comments', 'custom-fields' ),
	);

	register_post_type( 'characteristic' , $args  );
}

// Δηλώνουμε την εμφάνιση του metabox για τον τύπο αντικειμένου Γνώρισμα [1/2]
add_filter( 'cmb_meta_boxes', 'ma_ellak_characteristic_metabox' );

// Δηλώνουμε την εμφάνιση του metabox για τον τύπο αντικειμένου Γνώρισμα [2/2]
function ma_ellak_characteristic_metabox( array $meta_boxes ) {

	global $ma_prefix ;

	$meta_boxes[] = array(
		'id'         => 'characteristic_metabox',
		'title'      => __('Γνώρισμα/Λειτουργικό Χαρακτηριστικό', 'ma-ellak'),
		'pages'      => array( 'characteristic'), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name' => __('Γνώρισμα/Λειτουργικό Χαρακτηριστικό', 'ma-ellak'),
				'desc' => __('To είδος της Καταχώρισης', 'ma-ellak'),
				'id'   => $ma_prefix . 'characteristic_type',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Γνώρισμα', 'ma-ellak'), 'value' => 'gnorisma', ),
					array( 'name' => __('Χαρακτηριστικό', 'ma-ellak'), 'value' => 'characteristic', ),
				),
			),
			array(
				'name' => __('Κατάσταση', 'ma-ellak'),
				'desc' => __('Η κατάσταση του Γνωρίσματος/Λειτουργικού Χαρακτηριστικού', 'ma-ellak'),
				'id'   => $ma_prefix . 'stage_status',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Επιλέξτε', 'ma-ellak'), 'value' => '', ),
					array( 'name' => __('Ανάληψη', 'ma-ellak'), 'value' => 'selected', ),
					array( 'name' => __('Σε εξέλιξη', 'ma-ellak'), 'value' => 'processed', ),
					array( 'name' => __('Ολοκληρωμένο', 'ma-ellak'), 'value' => 'done', ),
				),
			),
			array(
				'name' => __('Περιγραφή Ενσωμάτωσης/Αποδοχής', 'ma-ellak'),
				'desc' => __('Σύντομη περιγραφή ως προς την Αποδοχή/Ολοκλήρωση ή Ενσωμάτωση της πρότασης.', 'ma-ellak'),
				'id'   => $ma_prefix . 'characteristic_acceptance',
				'type' => 'textarea',
			),
			array(
				'name' => __('Σύνδεσμος Αποθετηρίου', 'ma-ellak'),
				'desc' => __('Σύνδεσμος προς το Ticketing σύστημα/Αποθετήριο οπού πραγματοποιείται η αλλαγή/προσθήκη του Γνωρίσματος.', 'ma-ellak'),
				'id'   => $ma_prefix . 'track_change_url',
				'type' => 'text',
			),
			
			
		),
	);
	
	return $meta_boxes;
}

// Hook into WordPress add_meta_boxes action
add_action( 'add_meta_boxes', 'add_char_software_custom_metabox' );
function add_char_software_custom_metabox() {
	add_meta_box( 'custom-metabox', __( 'Λογισμικό' ), 'Software_custom_metabox', 'characteristic', 'side', 'low' );
}
/**
 * Display the metabox
 */
function Software_custom_metabox() {
	global $post,$current_user,$ma_prefix;
	//remember the current $post object
	$real_post = $post;
	//get curent user info (we need the ID)
	get_currentuserinfo();
	//create nonce
	echo '<input type="hidden" name="Software_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	
	//get saved meta
	if($post->ID)
	$selected = get_post_meta( $post->ID, $ma_prefix.'for_software', true );
	
	//create a query for all of the user businesses posts
	$Businesses_query = new WP_Query();
	$Businesses_query->query(array(
			'post_type' => 'software',
			'posts_per_page' => -1,
			));
	if ($Businesses_query->have_posts()){
		echo '<select name="'.$ma_prefix.'for_software" id="'.$ma_prefix.'for_software">';
		//loop over all post and add them to the select dropdown
		while ($Businesses_query->have_posts()){
			$Businesses_query->the_post();
			echo '<option value="'.$post->ID.'" ';
			if ( $post->ID == $selected){
				echo 'selected="selected"';
			}
			echo '>'.$post->post_title .'</option>';
		}
		echo '<select>';
	}
	//reset the query and the $post to its real value
	wp_reset_query();
	$post = $real_post;
}
//hook to save the post meta
add_action( 'save_post', 'save_Software_custom_metabox' );
/**
 * Process the custom metabox fields
 */
function save_Software_custom_metabox( $post_id ) {
	global $post,$ma_prefix;
	// verify nonce
	if (!wp_verify_nonce($_POST['Software_meta_box_nonce'], basename(__FILE__))) {
		return $post_id;
	}
	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}
	// check permissions
	if ('characteristic' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}

	if( $_POST ) {
		$old = get_post_meta($post_id, $ma_prefix."for_software", true);
		$new = $_POST[$ma_prefix."for_software"];
		if ($new && $new != $old){
			update_post_meta($post_id, $ma_prefix."for_software", $new);
		}
	}
}
// Αρχικοποιεί εφόσον δεν έχει γίνει ήδη τη βιβλιοθήκη των MetaBoxes [1/2]
add_action( 'init', 'ma_ellak_yp3_meta_boxes', 9999 );

// Αρχικοποιεί εφόσον δεν έχει γίνει ήδη τη βιβλιοθήκη των MetaBoxes [2/2]
function ma_ellak_yp3_meta_boxes() {
	if ( ! class_exists( 'cmb_Meta_Box' ) ) require_once (TEMPLATEPATH . '/scripts/metabox/init.php');
}

// Προσθέτει javascripts και css styles [1/2]
function ma_ellak_yp3_scripts() {
	
	$template_dir =  get_bloginfo('template_directory');
	
	if ( is_page_template('ma_ellak_yp3_tmpl_add_characteristic.php') ) {
		wp_enqueue_script( 'ma_ellak_validate_yp3',  $template_dir . '/js/validate_yp3_tmpl_add_characteristic.js',  array('jquery'), '1.0', true );
	}
	if ( is_page_template('ma_ellak_yp3_tmpl_edit_characteristic.php') ) {
		wp_enqueue_script( 'ma_ellak_validate_yp3',  $template_dir . '/js/validate_yp3_tmpl_edit_characteristic.js',  array('jquery'), '1.0', true );
	}
}

// Προσθέτει javascripts και css styles [2/2]
add_action( 'wp_enqueue_scripts', 'ma_ellak_yp3_scripts', 11 );

// Αποθηκεύει τα έξτρα πεδία (post meta) απο τη φόρμα front-end υποβολής
function ma_ellak_characteristic_save_details( $post_id ){
	
	global $ma_prefix ; 
	
	if ( isset( $_POST[$ma_prefix.'characteristic_type'] ) )
		update_post_meta( $post_id, $ma_prefix.'characteristic_type',  $_POST[$ma_prefix.'characteristic_type'] );
	else
		delete_post_meta( $post_id, $ma_prefix.'characteristic_type' );
		
	if ( isset( $_POST['software_id'] ) )
		update_post_meta( $post_id, $ma_prefix.'for_software',  $_POST['software_id'] );
	//else
		//delete_post_meta( $post_id, $ma_prefix.'for_software' );
	
	if ( isset( $_POST[$ma_prefix.'stage_status'] ) )
		update_post_meta( $post_id, $ma_prefix.'stage_status',  $_POST[$ma_prefix.'stage_status'] );
	//else
		//delete_post_meta( $post_id, $ma_prefix.'for_software' );
	
	if ( isset( $_POST[$ma_prefix.'characteristic_acceptance'] ) )
		update_post_meta( $post_id, $ma_prefix.'characteristic_acceptance',  $_POST[$ma_prefix.'characteristic_acceptance'] );
	else
		delete_post_meta( $post_id, $ma_prefix.'characteristic_acceptance' );
		
	if ( isset( $_POST[$ma_prefix.'track_change_url'] ) )
		update_post_meta( $post_id, $ma_prefix.'track_change_url',  $_POST[$ma_prefix.'track_change_url'] );
	else
		delete_post_meta( $post_id, $ma_prefix.'track_change_url' );
		
	$unit_id =  ma_ellak_get_unit_id();
		if( $unit_id != 0)
			update_post_meta( $post_id, '_ma_ellak_belongs_to_unit',$unit_id );
}

function get_about_software($post_id){
	if(empty($post_id) or $post_id = ''){
		global $post;
		$post_id =  $post->ID;
	}
	
	global $ma_prefix;
	$software_id = get_post_meta($post_id, $ma_prefix.'for_software', true);
	return '<a href="'.get_permalink($software_id).'" rel="bookmark" title="'.get_the_title($software_id).'" >'.get_the_title($software_id).'</a>';
}

function get_all_about_software($post_id){
	if(empty($post_id) or $post_id = ''){
		global $post;
		$post_id =  $post->ID;
	}
	global $ma_prefix;
	$software_id = get_post_meta($post_id, $ma_prefix.'for_software', true);

	return '<p><span>'.ma_ellak_print_unit_title($software_id).'</span><span>'.ma_ellak_print_thema($software_id,'thema').'</span></p>';
}


function get_status_name($status){
	
	$details = '<span class="'.$status.'">';
	if($status == 'selected') $details .= __('Ανάληψη', 'ma-ellak'); 
	if($status == 'processed') $details .= __('Σε εξέλιξη', 'ma-ellak'); 
	if($status == 'done') $details .= __('Ολοκληρωμένο', 'ma-ellak');
	$details .='</span>';
	return $details ;
}

function show_latest_characteristics($software_id = 0, $limit = 5, $title = '', $sort_by = 'latest', $echo = false){
	
	global $ma_prefix;
	
	if($software_id != 0){
		$software_post = get_post($software_id);
		if(!empty($software_post) and 'software' == $software_post->post_type) 
			$software_id = $software_id;
		else
			return; // This is not a Software
	}
	
	$args = array(
		'post_per_page' => $limit,
		'post_type' => 'characteristic',
		'post_status' => 'publish', 
	);
	
	$args['meta_query'] = array();
	
	if($software_id != 0){
		$args['meta_query'] = array(
			array(
				'key' => $ma_prefix.'for_software',
				'value' => $software_id,
			)
		);
	}
	
	if ($sort_by !='latest'){
		$args['meta_key'] = 'ratings_average';
		$args['orderby']  = 'meta_value';
        $args['order']    = 'DESC';
	}
	
	$posts = get_posts($args);
	if(count($posts)<1){
	
	} else {
		if($title != '')
			$content = '<div class="widget"><h4 class="widget-title characteristics-widget">'.$title.'</h4><ul>';
		else
			$content = '<div class="widget"><ul>';
			
		foreach($posts as $post){ setup_postdata($post);
			
			$meta=get_post_meta($post->ID);
			$stars=$meta['ratings_average'][0];
			if (!isset($stars))
				$stars=0;
				
			$content .= '<li>(<i class="icon-star"></i> '.$stars.') <a href="'.get_permalink($post->ID).'">'.get_the_title($post->ID).'</a></li>';
		}
		$content .= '</ul></div>';
	}
	
	if( $echo)
		echo $content;
	else
		return $content;
}

function get_all_unique_software(){
	global $ma_prefix;
	
		$type = 'characteristic';
		$argsAll=array(
				'posts_per_page' =>-1,
				'post_type' => $type,
				'post_status' => 'publish',
		);
		
		
		$my_queryAll = null;
		$my_queryAll = new WP_Query($argsAll);
		$software = array();
		if( $my_queryAll->have_posts() ) {
		  while ($my_queryAll->have_posts()) : $my_queryAll->the_post(); 
		  	$gnorisma_id = get_the_ID();
		  	$Allsoftware[] = get_post_meta($gnorisma_id, $ma_prefix.'for_software', true);
		   endwhile;
		  }
		  $Allsoftware = array_unique($Allsoftware);
		  $i=0;
		  foreach ($Allsoftware as $one):
		  	$software[$i]['id']=$one;
		  	$software[$i]['title']=get_post($one)->post_title;
		    $i++;
		  endforeach;
		  wp_reset_query();  // Restore global post data stomped by the_post().
		 
	return $software;
}
?>