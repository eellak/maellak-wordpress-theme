<?php
/**
* Αρχείο Για την Προσθήκη Menu στο διαχειριστό το Wordpress
*
* @licence GPL
* @author Fotis Routsis - fotis@routsis.gr
* 
* Project URL http://ma.ellak.gr
*/

function register_ellak_menu() {
  register_nav_menu('top-menu', __( 'Top Menu' ));
  register_nav_menu('footer-menu', __( 'Footer Menu' ));
}
add_action( 'after_setup_theme', 'register_ellak_menu' );

function fallbackfmenu(){
	echo 'Go to Admin Panel > Appearance > Menus to create your menu';
}	

// Προσθέτει τη σελίδα Αντιστοίχισης BP Groups και Θεματικών [1/3]
function ma_ellak_thema_bp_match_page() {
	add_menu_page(__('BP Groups & Thema', 'ma-ellak'), __('BP Groups & Thema', 'ma-ellak'), 'activate_plugins', 'ma_ellak_thema_bp_match_page-handle', 'ma_ellak_thema_bp_match_page_options');
} 
// Προσθέτει τη σελίδα Αντιστοίχισης BP Groups και Θεματικών [2/3]
function ma_ellak_thema_bp_match_page_options() {
	require_once (TEMPLATEPATH . '/lib/ma_ellak_global_thema_bp_match.php');
}
// Προσθέτει τη σελίδα Αντιστοίχισης BP Groups και Θεματικών [3/3]
add_action('admin_menu', 'ma_ellak_thema_bp_match_page');


// Προσθέτει τη σελίδα Καταχώρισης Χρηστών στις Μονάδες Αριστείας [1/3]
function ma_ellak_unit_user_match() {
	if ( current_user_can('moderate_comments') ) {
		add_submenu_page(
			'edit.php?post_type=unit',
			__('Χρήστες', 'ma-ellak'), /*page title*/
			__('Χρήστες', 'ma-ellak'), /*menu title*/
			'edit_others_posts', /*roles and capabiliyt needed*/
			'ma_ellak_unit_user_match_page-handle',
			'ma_ellak_unit_user_match_page_options' /*replace with your own function*/
		);
	}
} 
// Προσθέτει τη σελίδα Καταχώρισης Χρηστών στις Μονάδες Αριστείας [1/3]
function ma_ellak_unit_user_match_page_options() {
	require_once (TEMPLATEPATH . '/lib/ma_ellak_global_unit_user_match.php');
}
// Προσθέτει τη σελίδα Καταχώρισης Χρηστών στις Μονάδες Αριστείας [1/3]
add_action('admin_menu', 'ma_ellak_unit_user_match');

?>