<?php
/*
Template Name: Profile - List
*/

get_header();
	
ma_ellak_profiles_upper_bar();
	if (isset($_GET['action']) && !isset($_GET['keyword'])){
		switch ($_GET['action']){
			case "list":
				ma_ellak_profile_get_list_page(6);
				break;
			case "active":
				ma_ellak_profile_get_active_page(6);
				break;
			case "popular":
				ma_ellak_profile_get_popular_page(6);
				break;
			case "search":
				ma_ellak_profile_search_page(6);
				break;
			default:
				ma_ellak_profile_get_list_page(6);
		}
	}
	else
		ma_ellak_profile_get_list_page(6);
	
	echo social_output();
	get_footer();
?>