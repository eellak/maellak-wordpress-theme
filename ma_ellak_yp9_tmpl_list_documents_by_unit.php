<?php
/*
Template Name: Documents Unit
*/

get_header();
if (! is_user_logged_in()) // Μόνο εγγεγραμμένοι χρήστες μπορούν να είναι εδώ.
	header('Location: '.URL.'');
$cur_user = wp_get_current_user();
$unitid=$cur_user->ID;

ma_ellak_document_upper_bar();
ma_ellak_documents_by_unit($unitid, $limit);
get_footer();

?>