<?php
/**
* Αρχείο συναρτήσεων για την Υπηρεσία 1.
*
* @licence GPL
* @author Fotis Routsis - fotis@routsis.gr
* 
* Project URL http://ma.ellak.gr
*/
/*
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
	);

	register_post_type( 'software' , $args  );
}
*/
?>