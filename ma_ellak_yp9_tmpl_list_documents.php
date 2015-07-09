<?php
/*
Template Name: Documents list
*/

get_header();
ma_ellak_document_upper_bar();
if (isset($_GET['action']) && !isset($_GET['keyword'])){
	switch ($_GET['action']){
		case "list":
			ma_ellak_documents_library(6);
			break;
		case "popular":
			ma_ellak_documents_popular_page(6);
			break;
		case "listthema":
			ma_ellak_documents_by_category($_GET['term'],6);
			break;
		default:
			ma_ellak_documents_library(6);
	}
}
else if (isset($_GET['keyword']) && !isset($_GET['action'])){
	$key=$_GET['keyword'];
	ma_ellak_documents_search_results($key, 6);
}
else
	ma_ellak_documents_library(6);
get_footer();

?>