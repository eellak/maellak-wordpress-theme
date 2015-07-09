<?php
/**
* Functions for Service 7 -  Manage video on demand files and archiving audiovisual material
*
* @licence GPL
* @author Zoi Politopoulou - politopz@gmail.com
* 
* Project URL http://ma.ellak.gr
*/

// The new video custom post type [1/2]
add_action( 'init', 'ma_ellak_register_video_posttype', 0 );

// Registration of the new custom type 
function ma_ellak_register_video_posttype() {
	$labels = array(
		'name' 					=> _x( 'Βίντεο', 'γενικό όνομα', 'ma-ellak' ),
		'singular_name' 		=> _x( 'Βίντεο', 'γενικό όνομα', 'ma-ellak' ),
		'add_new' 				=> _x( 'Προσθήκη Νέου', 'Βίντεο', 'ma-ellak' ),
		'add_new_item'			=> __( 'Προσθήκη Νέου Βίντεο', 'ma-ellak' ),
		'edit_item' 			=> __( 'Επεξεργασία Βίντεο', 'ma-ellak' ),
		'new_item' 				=> __( 'Νέο Βίντεο', 'ma-ellak' ),
		'all_items' 			=> __( 'Όλα τα Βίντεο', 'ma-ellak' ),
		'view_item' 			=> __( 'Προβολή Βίντεο', 'ma-ellak' ),
		'search_items' 			=> __( 'Αναζήτηση Βίντεο', 'ma-ellak' ),
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
		'rewrite' 				=> array( 'slug' => 'video', 'with_front' => true, 'feeds' => true ) ,
		'capability_type' 		=> 'post',
		'hierarchical' 			=> false,
		'menu_position' 		=> null,
		'supports' 				=> array( 'title', 'author', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions', 'custom_fields', 'tags' ),
		'taxonomies' 			=> array('post_tag')
	);

	register_post_type( 'video' , $args  );
}

// render post select
add_action( 'cmb_render_post_select', 'sm_cmb_render_post_select', 10, 2 );

function sm_cmb_render_post_select( $field, $meta ) {
	$post_type = 'events';
	$limit = ($field['limit'] ? $field['limit'] : '-1');
	echo '<select name="', $field['id'], '" id="', $field['id'], '">';
	$posts = get_posts('post_type='.$post_type.'&numberposts='.$limit.'&posts_per_page='.$limit);
	echo '<option value="">-- -- ---</option>';
	foreach ( $posts as $art ) {
		if ($art->ID == $meta ) {
			echo '<option value="'. $art->ID .'" selected>' . get_the_title($art->ID) . '</option>';
		} else {
			echo '<option value="'. $art->ID .'">' . get_the_title($art->ID) . '</option>';
		}
	}
	echo '</select>';
	echo '<p class="cmb_metabox_description">', $field['desc'], '</p>';
}

function ma_ellak_render_events( $meta ) {
	 $prefix='_ma_';
	
	$field['limit']=-1;
	$field['id']=$prefix . 'video_events_stream';
	$post_type = 'events';
	$limit = ($field['limit'] ? $field['limit'] : '-1');
	echo '<select name="', $field['id'], '" id="', $field['id'], '">';
	$posts = get_posts('post_type='.$post_type.'&numberposts='.$limit.'&posts_per_page='.$limit);
	echo '<option value="">-- -- ---</option>';
	foreach ( $posts as $art ) {
		if ($art->ID == $meta ) {
			echo '<option value="'. $art->ID .'" selected>' . get_the_title($art->ID) . '</option>';
		} else {
			echo '<option value="'. $art->ID .'">' . get_the_title($art->ID) . '</option>';
		}
	}
	echo '</select>';
}

// the field doesnt really need any validation, but just in case
add_filter( 'cmb_validate_post_select', 'rrh_cmb_validate_post_select' );
function rrh_cmb_validate_post_select( $new ) {
	return $new;
}
/**
 * Change the permalink for the video posts.
 */
function ma_ellak_video_rewrite_permalink ( $post_link, $post) {
    if ( ! in_array( $post->post_type, array( 'video' ) ) || 'publish' != $post->post_status )
		return $post_link;

	$id=$post->ID;

	$plink=explode('?', $post_link);
	$post_link=$plink[0]."?mavideo=". $id;
    return $post_link;
}
add_filter( 'post_type_link', 'ma_ellak_video_rewrite_permalink', 10, 3 );

// metaboxes for the post type of video
add_filter( 'cmb_meta_boxes', 'ma_ellak_video_metabox' );

// The metaboxes for video custom post type are: link of video, duration of a media file - HH:MM:SS and the date
function ma_ellak_video_metabox( array $meta_boxes ) {

	$prefix = '_ma_'; // Underscore για να μη φαίνονται στη default λίστα

	$meta_boxes[] = array(
		'id'         => 'video_metabox',
		'title'      => __('Πληροφορίες Βίντεο', 'ma-ellak'),
		'pages'      => array( 'video'), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name' => __('Ημερομηνία προβολής', 'ma-ellak'),
				'desc' => __('Καταχώρηση ημερομηνίας προβολής στη μορφή MM/HH/EEEE', 'ma-ellak'),
				'id'   => $prefix . 'video_date',
				'type' => 'text_date',
			),
			array(
				'name' => __('Εξωτερικός σύνδεσμος βίντεο', 'ma-ellak'),
				'desc' => __('Προσθήκη βίντεο από youtube, vimeo ή google', 'ma-ellak'),
				'id'   => $prefix . 'video_url',
				'type' => 'video_url',
			),
			array(
				'name' => __('Χρονική διάρκεια', 'ma-ellak'),
				'desc' => __('Καταχώρηση χρονικής διάρκειας στη μορφή HH:MM:SS', 'ma-ellak'),
				'id'   => $prefix . 'video_duration',
				'type' => 'duration',
			),
			array(
				'name' => __('Έχω γνώση του περιεχομένου που αναρτώ', 'ma-ellak'),
				'desc' => __('', 'ma-ellak'),
				'id'   => $prefix . 'video_know',
				'type' => 'checkbox',
			),
				array(
						'name' => __('Σχετική εκδήλωση', 'ma-ellak'),
						'desc' => __('Αν το video αποτελεί μέρος μίας εκδήλωσης των Μονάδων Αριστείας, επιλέξτε την εκδήλωση', 'ma-ellak'),
						'id'   => $prefix . 'video_events_stream',
						'type' => 'post_select',
				),
				post_select
		),
	);
	return $meta_boxes;
}

// Αρχικοποιεί εφόσον δεν έχει γίνει ήδη τη βιβλιοθήκη των MetaBoxes [1/2]
add_action( 'init', 'ma_ellak_yp7_meta_boxes', 9999 );

// Αρχικοποιεί εφόσον δεν έχει γίνει ήδη τη βιβλιοθήκη των MetaBoxes [2/2]
function ma_ellak_yp7_meta_boxes() {
	if ( ! class_exists( 'cmb_Meta_Box' ) ) require_once (TEMPLATEPATH . '/scripts/metabox/init.php');
}

//Create the new post type columns in the front end array
//Unset the existing columns
function ma_ellak_yp7_edit_columns( $columns ) {
	unset($columns['author']);
	unset($columns['tags']);
	unset($columns['comments']);

	$columns['title']="Τίτλος";
	$columns['date']="Καταχώρηση";

	$new_columns = array(
		'_ma_video_date' => __('Ημερομηνία προβολής', 'ma-ellak'),
	);
	$columns=array_merge($columns, $new_columns);
	return $columns;
}

// Filter pages
add_filter( 'manage_edit-page_columns', 'ma_ellak_yp7_edit_columns',10, 1 );
// Filter Posts
add_filter( 'manage_edit-post_columns', 'ma_ellak_yp7_edit_columns',10, 1 );
// Custom Post Type
add_filter( 'manage_edit-video_columns', 'ma_ellak_yp7_edit_columns',10, 1 );


function ma_ellak_yp7_custom_columns( $column ) {
	$custom = get_post_custom();
	switch ( $column ) {
		case '_ma_video_date' :
			echo $custom[_ma_video_date][0];
		break;
	}
}
add_action ("manage_posts_custom_column", "ma_ellak_yp7_custom_columns", 10, 2);
/*********** END *********************/
add_action( 'publish_post', 'ma_ellak_set_unit_on_object',10,2 );
/** Validates the user input in the admin dashboard.**/
function ma_ellak_yp7_scripts_admin(){
	$template_dir =  get_bloginfo('template_directory');
	global $typenow;
	if($typenow == 'video'){
		wp_enqueue_script( 'ma_ellak_validate',  $template_dir . '/js/jquery.validate.min.js',  array('jquery'), '1.0', true );
		wp_enqueue_script( 'ma_ellak_validate_fields_submit',  $template_dir . '/js/validate_yp7_tmpl_add_video_val_submit.js',  array('jquery'), '1.0', true );
		wp_enqueue_script( 'ma_ellak_validate_fields_front', $template_dir . '/js/validate_yp7_tmpl_add_video_val_front.js',  array('jquery'), '1.0', true );
		
	}
	}
add_action('admin_enqueue_scripts', 'ma_ellak_yp7_scripts_admin');
/*********** END ************/

// Προσθέτει javascripts και css styles [1/2]
function ma_ellak_yp7_scripts() {
	global $typenow;
	
	$template_dir =  get_bloginfo('template_directory');
	
	// Το θέλουμε στην ακόλουθη σελίδα (template: Δημόσια φόρμα Προσθήκης Λογισμικού)
	if ( is_page_template('ma_ellak_yp7_tmpl_add_video.php') || is_page_template('ma_ellak_yp7_tmpl_update_video.php')) {
		wp_enqueue_style( 'ma_ellak_chosen_css', $template_dir . '/scripts/tagselect/chosen/chosen.css' );
		wp_enqueue_style( 'ma_ellak_tagselect_css',  $template_dir . '/scripts/tagselect/tagselect.css');
			
		wp_enqueue_script( 'ma_ellak_chosen_js', $template_dir . '/scripts/tagselect/chosen/chosen.jquery.min.js', array('jquery'), '1.0', true );
		wp_enqueue_script( 'ma_ellak_tagselect_js', $template_dir . '/scripts/tagselect/tagselect.js',  array('jquery'), '1.0', true );
	
		wp_enqueue_script( 'ma_ellak_validate',  $template_dir . '/js/jquery.validate.min.js',  array('jquery'), '1.0', true );

		$cmb_script_array = array( 'jquery-ui-datepicker');
		wp_register_script( 'cmb-scripts', $template_dir .'/scripts/metabox/js/cmb.js', $cmb_script_array, '0.9.1' );
		wp_enqueue_script( 'cmb-scripts' );
		
		$cmb_style_array = array( 'thickbox' );
		wp_register_style( 'cmb-styles', $template_dir .'/scripts/metabox/style.css', $cmb_style_array );
		wp_enqueue_style( 'cmb-styles' );

		wp_enqueue_script( 'ma_ellak_validate_fields_submit', $template_dir . '/js/validate_yp7_tmpl_add_video_val_submit.js',  array('jquery'), '1.0', true );
		wp_enqueue_script( 'ma_ellak_validate_fields_front',  $template_dir . '/js/validate_yp7_tmpl_add_video_val_front.js',  array('jquery'), '1.0', true );
		
	}
	wp_enqueue_script( 'ma_ellak_video_embed',  $template_dir . '/js/embed_video.js',  array('jquery'), '1.0', true );
	
}

// Προσθέτει javascripts και css styles [2/2]
add_action( 'wp_enqueue_scripts', 'ma_ellak_yp7_scripts', 11 );

// Αποθηκεύει τα έξτρα πεδία (post meta) απο τη φόρμα front-end υποβολής
function ma_ellak_video_save_details( $post_id ){
	$prefix = '_ma_'; // Underscore για να μη φαίνονται στη default λίστα. Το ίδιο που χρησιμοποιούμε και στη δήλωση των εσωτερικών metaboxes.
	
	if ( isset( $_POST['_ma_video_duration_hours'] ) || isset( $_POST['_ma_video_duration_minutes'] ) || isset( $_POST['_ma_video_duration_seconds'] )){
		$_ma_video_duration=$_POST['_ma_video_duration_hours'] .":". $_POST['_ma_video_duration_minutes'] .":". $_POST['_ma_video_duration_seconds'];
		update_post_meta( $post_id, $prefix.'video_duration',  $_ma_video_duration );
	}
	else
		delete_post_meta( $post_id, $prefix.'video_duration' );

	if ( isset( $_POST['_ma_video_date'] ) )
		update_post_meta( $post_id, $prefix.'video_date',  $_POST['_ma_video_date'] );
	else
		delete_post_meta( $post_id, $prefix.'video_date' );

	if ( isset( $_POST['_ma_video_url'] ) ){ 
		$video = str_replace('https:', 'http:',  $_POST['_ma_video_url'] );
		update_post_meta( $post_id, $prefix.'video_url',  $video);
	} else
		delete_post_meta( $post_id, $prefix.'video_url' );

	if (isset($_POST['_ma_video_know']))
		update_post_meta( $post_id, $prefix.'video_know',  $_POST['_ma_video_know'] );
	else
		delete_post_meta( $post_id, $prefix.'video_events_stream' );
	if (isset($_POST['_ma_video_events_stream']))
		update_post_meta( $post_id, $prefix.'video_events_stream',  $_POST['_ma_video_events_stream'] );
	else
		delete_post_meta( $post_id, $prefix.'video_events_stream' );
}

/*** FUNCTIONS TO DISPLAY RESULTS ***/
// Δημιουργία του query για τα πιο δημοφιλή βίντεο
// Είσοδος: $limit ο χρήστης μπορεί να περιορίσει τα αποτελέσματα που θα του επιστραφούν, εάν η τιμή είναι -1 επιστρέφονται όλα τα αποτελέσματα
function ma_ellak_video_get_popular_query($limit){
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$args = array(
        'post_type' => 'video',
		'paged' => $paged,
		'posts_per_page' => $limit,
		'ignore_sticky_posts'=> 1,
        'post_status' => 'publish',
        'meta_key' => 'ratings_average',
        'orderby' => 'meta_value',
        'order' => 'DESC',
		//'caller_get_posts' => 1,
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

// Δημιουργία του query για τη λίστα των βίντεο με βάση την ημερομηνία
// Είσοδος: $limit ο χρήστης μπορεί να περιορίσει τα αποτελέσματα που θα του επιστραφούν, εάν η τιμή είναι -1 επιστρέφονται όλα τα αποτελέσματα
function ma_ellak_video_get_list_query($limit){
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$args = array (
		'post_type' => 'video',
		'post_status' => 'publish',
		'paged' => $paged,
		'posts_per_page' => $limit,
		'ignore_sticky_posts'=> 1,
		'orderby' => 'post_date',
		'order' =>  'ASC'
	);
	return $args;
}

// Δημιουργία του query για τα βίντεο που ανήκουν σε μια κατηγορία
// Είσοδος: 
// 1. $thema το αναγνωριστικό (id) της θεματικής κατηγορίας στην οποία ανήκουν τα βίντεο
// 2. $limit ο χρήστης μπορεί να περιορίσει τα αποτελέσματα που θα του επιστραφούν, εάν η τιμή είναι -1 επιστρέφονται όλα τα αποτελέσματα
function ma_ellak_video_get_listvideo_thema_query($thema, $limit){
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$args = array(
        'post_type' => 'video',
		'paged'=>$paged,
        'posts_per_page' => $limit,
        'post_status' => 'publish',
        'orderby' => 'post_date',
        'order' => 'ASC',
        'tax_query' => array(
            'relation' => 'and',
            array(
                'taxonomy' => 'thema',
                'field' => 'taxonomy_id',
                'terms' => $thema
                )
        )
    );
	return $args;
}

// Δημιουργία του query για τα πιο δημοφιλή βίντεο που ανήκουν σε μια κατηγορία
// Είσοδος: 
// 1. $thema το αναγνωριστικό (id) της θεματικής κατηγορίας στην οποία ανήκουν τα βίντεο
// 2. $limit ο χρήστης μπορεί να περιορίσει τα αποτελέσματα που θα του επιστραφούν, εάν η τιμή είναι -1 επιστρέφονται όλα τα αποτελέσματα
function ma_ellak_video_get_popular_thema_query($thema, $limit){
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$args = array(
        'post_type' => 'video',
        'posts_per_page' => $limit,
        'post_status' => 'publish',
        'meta_key' => 'ratings_average',
		'orderby' => 'meta_value',
		'paged'=>$paged,
        'order' => 'DESC',
			'meta_query' => array(
			'relation' => 'AND',
			array(
				'key' => 'ratings_average',
				'compare' => '='
			)
		),
		'tax_query' => array(
            'relation' => 'and',
            array(
                'taxonomy' => 'thema',
                'field' => 'taxonomy_id',
                'terms' => $thema
			)
		)
	);
	return $args;
}

//Επιστρέφει το αποτέλεσμα ενός query
function ma_ellak_video_get_result($args){
	global $wpdb;
	$wp_query=null;
	$wp_query = new WP_Query( $args );
	return $wp_query;
}

/*************FUNCTIONS FOR WIDGETS***************/
//Εκτυπώνει τα βίντεο που ανήκουν σε μια θεματική κατηγορία για χρήση σε widget
//Είσοδος:
// 1. $thema_name το όνομα της θεματικής κατηγορίας στην οποία ανήκουν τα βίντεο
// 2. $limit ο χρήστης μπορεί να περιορίσει τα αποτελέσματα που θα του επιστραφούν, εάν η τιμή είναι '' επιστρέφονται όλα τα αποτελέσματα
function ma_ellak_video_get_list_thema_widget($thema_name, $limit){
	//find the term id provided the taxonomy term
	$obj=get_term_by('name', $thema_name, 'thema');
	$term_id=$obj->term_id;

	$args=ma_ellak_video_get_listvideo_thema_query($term_id, $limit);
	$wp_query=ma_ellak_video_get_result($args);

	if ($wp_query->found_posts>0)
		video_list_widget($wp_query);
	else
		_e('Δεν υπάρχουν βίντεο για αυτή τη θεματική κατηγορία.', 'ma_ellak');
}

//Εκτυπώνει τα πιο δημοφιλή βίντεο όλου του δικτυακού τόπου για χρήση σε widget
//Είσοδος:
// 1. $limit ο χρήστης μπορεί να περιορίσει τα αποτελέσματα που θα του επιστραφούν
function ma_ellak_video_get_popular_widget($limit){
	$args=ma_ellak_video_get_popular_query($limit);
	$query=ma_ellak_video_get_result($args);

	if ($query->found_posts>0)
		video_list_widget($query);
	else
		_e('Δεν έχουν αξιολογηθεί ακόμη τα βίντεο που βρίσκονται στην πλατφόρμα.', 'ma_ellak');
}

//Εκτυπώνει τη λίστα με τα βίντεο όλου του δικτυακού τόπου για χρήση σε widget
//Είσοδος:
// 1. $thema το ID της θεματικής ενότητας για την οποία θα επιστραφούν τα πιο δημοφιλή βίντεο
// 2. $limit το όριο των αποτελεσμάτων ανά σελίδα
function ma_ellak_video_get_popular_thema_widget($thema, $limit){
	$args=ma_ellak_video_get_popular_thema_query($thema, $limit);
	$wp_query=ma_ellak_video_get_result($args);

	if ($wp_query->found_posts>0)
		video_list_widget($wp_query);
	else
		_e('Δεν έχουν αξιολογηθεί ακόμη τα βίντεο που βρίσκονται σε αυτή την κατηγορία.', 'ma_ellak');
}

//Εκτυπώνει λίστα με τα τελευταία βίντεο όλου του δικτυακού τόπου για χρήση σε widget
//Είσοδος:
// 1. $limit ο χρήστης μπορεί να περιορίσει τα αποτελέσματα που θα του επιστραφούν
function ma_ellak_video_get_list_widget($limit){
	$args=ma_ellak_video_get_list_query($limit);
	$wp_query=ma_ellak_video_get_result($args);

	if ($wp_query->found_posts>0)
		video_list_widget($wp_query);
	else
		_e('Δεν έχουν καταχωρηθεί βίντεο ακόμη.', 'ma_ellak');
}

/*** PAGES***/
//Εκτυπώνει τα βίντεο που ανήκουν σε μια θεματική κατηγορία για χρήση σε σελίδα
//Είσοδος:
// 1. $term_id το αναγνωριστικό της θεματικής κατηγορίας που επέλεξε ο χρήστης κατά την αναζήτησή του
// 2. $limit το όριο των αποτελεσμάτων ανά σελίδα
function ma_ellak_video_get_list_thema_page($term_id, $limit){
	$args=ma_ellak_video_get_listvideo_thema_query($term_id, $limit);
	$wp_query=ma_ellak_video_get_result($args);

	if ($wp_query->found_posts>0){
		$obj=get_term_by('id', $term_id, 'thema');
		$term_name=$obj->name;
		$message="<b>Αποτελέσματα αναζήτησης για την κατηγορία: ". $term_name ."</b><br><br>";
		_e($message, 'ma-ellak');
		video_list_page($wp_query);
	}
	if ($wp_query->found_posts==0 || $term_id=='')
		_e('Δεν έχουν καταχωρηθεί ακόμη βίντεο σε αυτή τη θεματική κατηγορία.', 'ma_ellak');

	if ($wp_query->found_posts>$limit)
		pagination(false, false, $wp_query);
	echo social_output();
}

//Εκτυπώνει τα πιο δημοφιλή βίντεο όλου του δικτυακού τόπου για χρήση σε σελίδα
//Είσοδος:
// 1. $limit το όριο των αποτελεσμάτων ανά σελίδα
function ma_ellak_video_get_popular_page($limit){
	$args=ma_ellak_video_get_popular_query($limit);
	$wp_query=ma_ellak_video_get_result($args);

	if ($wp_query->found_posts>0)
		video_list_page($wp_query);
	else
		_e('Δεν έχουν αξιολογηθεί ακόμη τα βίντεο που βρίσκονται στην πλατφόρμα.', 'ma_ellak');

	if ($wp_query->found_posts>$limit)
		pagination(false, false, $wp_query);
	echo social_output();
}

//Εκτυπώνει τη λίστα με τα πιο δημοφιλή βίντεο που ανήκουν σε μια κατηγορία για χρήση σε σελίδα
//Είσοδος:
// 1. $thema το ID της θεματικής ενότητας για την οποία θα επιστραφούν τα πιο δημοφιλή βίντεο
// 2. $limit το όριο των αποτελεσμάτων ανά σελίδα
function ma_ellak_video_get_popular_thema_page($thema, $limit){
	$args=ma_ellak_video_get_popular_thema_query($thema, $limit);
	$wp_query=ma_ellak_video_get_result($args);

	if ($wp_query->found_posts>0)
		video_list_page($wp_query);
	if ($wp_query->found_posts>0 && $thema=='')
		_e('Δεν έχουν αξιολογηθεί ακόμη τα βίντεο που βρίσκονται στη θεματική κατηγορία.', 'ma_ellak');
	if ($wp_query->found_posts>$limit)
		pagination(false, false, $wp_query);
	echo social_output();
}

//Εκτυπώνει τη λίστα με τα βίντεο όλου του δικτυακού τόπου για χρήση σε σελίδα
// 1. $limit το όριο των αποτελεσμάτων ανά σελίδα
function ma_ellak_video_get_list_page($limit){
	$args=ma_ellak_video_get_list_query($limit);
	$wp_query=ma_ellak_video_get_result($args);

	if ($wp_query->found_posts>0)
		video_list_page($wp_query);
	else
		_e('Δεν έχουν καταχωρηθεί ακόμη βίντεο στην πλατφόρμα.', 'ma_ellak');

	if ($wp_query->found_posts>$limit)
		pagination(false, false, $wp_query);
	echo social_output();
}

// Συνάρτηση που καλείται από το φίλτρο "posts_where" όπου γίνεται τροποποίηση του WHERE
// Είσοδος:
// 1. $where το where clause που έχει δημιουργηθεί μέχρι εκείνη τη στιγμή
// 2. $wp_query οι παράμετροι που εισάγονται
function keyword_search( $where, &$wp_query ){
    global $wpdb;

	$where .= ' AND (' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( like_escape( $_GET['keyword'] ) ) . '%\'';
	$where .= ' OR ' . $wpdb->posts . '.post_content LIKE \'%' . esc_sql( like_escape( $_GET['keyword'] ) ) . '%\')';

	return $where;
}

// Εκτύπωση αποτελεσμάτων για την αναζήτηση σε βίντεο
// Είσοδος: 
// 1. $thema το αναγνωριστικό (id) της θεματικής κατηγορίας στην οποία ανήκουν τα βίντεο
// 2. $keyword η λέξη κλειδί που εισάγει ο χρήστης κατά την αναζήτηση
// 3. $limit ο χρήστης μπορεί να περιορίσει τα αποτελέσματα που θα του επιστραφούν, εάν η τιμή είναι -1 επιστρέφονται όλα τα αποτελέσματα
function ma_ellak_video_search_results($thema, $keyword, $limit){
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	global $wpdb;

	$args=$args_k=$args_t=array();
	$args = array(
        'post_type' => 'video',
		'paged'=>$paged,
        'posts_per_page' => $limit,
        'post_status' => 'publish',
		'orderby' => 'post_date',
        'order' => 'DESC'
		);
	if ($thema!='')
		$args_t=array(
			'tax_query' => array(
				'relation' => 'and',
				array(
					'taxonomy' => 'thema',
					'field' => 'taxonomy_id',
					'terms' => $thema
				)
			)	
		);
	$nargs=array_merge($args, $args_k, $args_t);
	if ($keyword!='')
		add_filter( 'posts_where', 'keyword_search', 10, 2 );
	$wp_query=ma_ellak_video_get_result($nargs);

	if ($wp_query->found_posts>0){
		$message="Αποτελέσματα αναζήτησης για τον όρο: ". $keyword ."<br><br>";
		_e($message, 'ma-ellak');
		video_list_page($wp_query);	
	}
	else
		_e('Δεν βρέθηκαν αποτελέσματα για τη συγκεκριμένη αναζήτηση.', 'ma_ellak');

	if ($wp_query->found_posts>$limit)
		pagination(false, false, $wp_query);
	echo social_output();
}


// Εκτυπώνει τη λίστα με τα βίντεο με βάση τα αποτελέσματα που επιστρέφονται από κάποιο query
// Είσοδος:
// 1. $wp_query ο πίνακας των αποτελεσμάτων που επιστρέφονται από κάποιο query
function video_list_page($wp_query){
?>
	<?php
	if ( $wp_query->have_posts() ) :
		$count=0;
		while ( $wp_query->have_posts() ) : $wp_query->the_post();
			if ($count==0){?>
				<div class="row-fluid">
				<div class="cols padded clearfix">		
			<?php
			}
			$post_id=get_the_ID();
			$meta=get_post_meta($post_id);
			$link=get_permalink();
			$title=get_the_title();
			$video_url=$meta['_ma_video_url'][0];
			if ($meta['_ma_video_date'][0]!='')
				$date_m=date(MA_DATE_FORMAT, strtotime($meta['_ma_video_date'][0]));
			else
				$date_m='';
			?>
			<div class="span4 square col">
				<div class="preview VideoImage" style="background-image:url('<?php echo social_return_video_url( '370', '200', $post_id );?>');">
					<a href="<?php echo $link;?>" style="width:370px;height:200px;">&nbsp;
						<div class="overlay absolute-center" ></div>
					</a>
				</div>
				<div class="meta">
					<h3><a href=<?php echo $link; ?>><?php echo $title; ?></a></h3>
					<ul class="unstyled purple">
						<li>
							<?php ma_ellak_print_unit_title($post_id);?>
							<?php echo ma_ellak_print_thema($post_id,'thema');?> 
							<?php echo $date_m; ?>
						</li>
					</ul>
				</div>
				<?php ma_ellak_social_print_data ($post_id, 'mavideo', 'list');?>
			</div>
			<?php
			$count++;
			if ($count==3){
				echo"</div></div>";
				$count=0;
			}
		endwhile;
	else :
		echo '<h2>Not Found</h2>';
	endif;
	?>
    </div></div><!-- #row-fluid -->
	<?php
	wp_reset_query();
}

function ma_ellak_upper_bar(){
?>
	<div class="row-fluid">&nbsp;</div>
	<div class="row-fluid">
		<div class="span6">
			<ul class="unstyled inline filters">
				<?php $link_page=get_permalink(get_option_tree('ma_ellak_list_video_option_id'));?>
				<?php if (isset($_GET['action']) && $_GET['action']!=''){?>
				<li><a href="<?php echo $link_page; ?>"><?php _e('ΠΙΣΩ ΣΤΗ ΛΙΣΤΑ', 'ma-ellak');?></a></li>
				<li>|</li>
				<?php }?>
				<li><a href="<?php echo $link_page; ?>?action=recent" class="<?php if (isset($_GET['action']) && $_GET['action']=='recent') echo'active-menu';?>">
					<?php _e('ΠΡΟΣΦΑΤΑ', 'ma-ellak');?></a></li>
				<li>|</li>
				<li><a href="<?php echo $link_page; ?>?action=popular" class="<?php if (isset($_GET['action']) && $_GET['action']=='popular') echo'active-menu';?>">
					<?php _e('ΔΗΜΟΦΙΛΗ', 'ma-ellak'); ?></a></li>
				<li>|</li>
				<li>
					<div class="dropdown">
						<a href="<?php echo $link_page; ?>?action=search_by_thema" 
						class="dropdown-toggle <?php if (isset($_GET['action']) && $_GET['action']=='listthema') echo'active-menu';?>"
						 data-toggle="dropdown"><?php _e('ΚΑΤΗΓΟΡΙΕΣ', 'ma-ellak');?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<?php
								$terms = get_terms('thema',array( 'hide_empty' => false ));
								foreach ( $terms as $term ){
									if(isset($_GET['term']) && $_GET['term']==$term->term_id) 
									echo "<li><a href=\"". $link_page ."?action=listthema&term=". $term->term_id ."\" class='active-menu' >" . $term->name . "</a></li>";
									else 
									echo "<li><a href=\"". $link_page ."?action=listthema&term=". $term->term_id ."\" >" . $term->name . "</a></li>";
								}
							?>
						</ul>
					</div>
				</li>
			</ul>
			
		</div>
		<?php ma_ellak_video_print_search_form();?>
	</div>
<?php
}

// Εκτυπώνει το κουτί της αναζήτησης της μπάρας σε κάθε σελίδα που είναι απαραίτητο
function ma_ellak_video_print_search_form(){
?>
	<div class="span4 pull-right videolist-search">
		<script type="text/javascript">
			function submitOnEnter(inputElement, event) {  
				if (event.keyCode == 13) { // No need to do browser specific checks. It is always 13.  
					inputElement.form.submit();  
				}
			}
		</script>
		<form class="form-search form-inverse" action="">
			<input type="text" name="keyword" onkeypress="submitOnEnter(this, event);" class="input-block-level search-query" placeholder="<?php _e('ΑΝΑΖΗΤΗΣΗ', 'ma-ellak');?>">
		</form>
	</div>
<?php
}

// Εκτυπώνει τη λίστα με τα βίντεο (τίτλος, link) με βάση τα αποτελέσματα που επιστρέφονται από κάποιο query για χρήση σε widget
// Είσοδος:
// 1. $wp_query ο πίνακας των αποτελεσμάτων που επιστρέφονται από κάποιο query
function video_list_widget($wp_query){
	?>
	 <?php
	        if ( $wp_query->have_posts() ) :
	 		echo"<ul class=\"unstyled\">";
	         while ( $wp_query->have_posts() ) : $wp_query->the_post();
				$post_id=get_the_ID();
				$meta=get_post_meta($post_id);
				echo"<li>";
				echo "<p class=\"heading\"><a href=\"". get_permalink() ."\" class=\"btn btn-large btn-link\">". get_the_title() ."</a></p>";
				echo"<p class=\"meta\">";
				echo "<span>";
				ma_ellak_print_unit_title($post_id);
				echo"</span>";
				echo "<span>";
				echo ma_ellak_print_thema($post_id,'thema');
				echo"</span>";
				echo"<span>";
				echo " ". date(MA_DATE_FORMAT, strtotime($meta['_ma_video_date'][0]));
				echo"</span></p>";
				echo"</li>";
            endwhile;
            echo"</ul>";
        else :
            echo '<h2>Not Found</h2>';
            get_search_form();
        endif;
        ?>
	 
	<?php
}

?>