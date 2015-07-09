<?php
/**
* Functions for Service 6 -  Manage live streaming material
*
* @licence GPL
* @author Zoi Politopoulou - politopz@gmail.com
* 
* Project URL http://ma.ellak.gr
*/

// Δημιουργία του query για τη λίστα με τα live streaming που είναι προγραμματισμένα
// Είσοδος: 
// 1. $limit ο χρήστης μπορεί να περιορίσει τα αποτελέσματα που θα του επιστραφούν, εάν η τιμή είναι -1 επιστρέφονται όλα τα αποτελέσματα
function ma_ellak_streaming_get_list_query($limit){
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$today=date('m/d/Y');

	$args = array(
        'post_type' => 'events',
		'paged' => $paged,
		'posts_per_page' => $limit,
		'ignore_sticky_posts'=> 1,
        'post_status' => 'publish',
        'meta_key' => '_ma_event_startdate_timestamp',
        'orderby' => '_ma_event_startdate_timestamp',
        'order' => 'ASC',
        'meta_query' => array(
			'relation' => 'AND',
			array(
				'key' => '_ma_event_startdate_timestamp',
				'value'=>$today,
				'compare' => '>='
			),
        	
		)
	);
	
	return $args;
}

function ma_ellak_streaming_get_live_query($limit){
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$today=date('m/d/Y');

	$args = array(
        'post_type' => 'events',
		'paged' => $paged,
		'posts_per_page' => $limit,
		'ignore_sticky_posts'=> 1,
        'post_status' => 'publish',
        'meta_key' => '_ma_event_startdate_timestamp',
        'orderby' => '_ma_event_startdate_timestamp',
        'order' => 'ASC',
        'meta_query' => array(
			'relation' => 'AND',
			array(
				'key' => '_ma_event_startdate_timestamp',
				'value'=>$today,
				'compare' => '>='
			),
			array(
				'key' => '_ma_event_live',
				'value'=>'on',
				'compare' => '='
			)
		)
	);
	return $args;
}

//Επιστρέφει το αποτέλεσμα ενός query
function ma_ellak_streaming_get_result($args){
	global $wpdb;
	$wp_query=null;
	$wp_query = new WP_Query( $args );
	$today=date('m/d/Y');
	
	$my_query="SELECT * FROM ma_posts
	INNER JOIN ma_postmeta ON (ma_posts.ID = ma_postmeta.post_id)
	WHERE ma_posts.post_type = 'events'
	AND (ma_posts.post_status = 'publish')
	AND (ma_postmeta.meta_key = '_ma_event_startdate_timestamp'
	AND STR_TO_DATE(ma_postmeta.meta_value, '%m/%d/%Y') >= STR_TO_DATE('".$today."', '%m/%d/%Y'))
	GROUP BY ma_posts.ID ORDER BY STR_TO_DATE(ma_postmeta.meta_value, '%m/%d/%Y') DESC LIMIT 0, 30";
	
	
	return $my_query;
}

function ma_ellak_streaming_get_list_page($limit){
	global $paged;
	$pageType = (mysql_real_escape_string($_GET['pagetype'])) ? mysql_real_escape_string($_GET['pagetype']) : 1;
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	
	// $args=ma_ellak_streaming_get_live_query($limit);
	//$wp_query=ma_ellak_streaming_get_result($args);

	$args=array(
		'post_type' => 'events',
		'post_status' => 'publish',
		'posts_per_page' => $limit,
		'paged'=>$paged,
	);
	
	add_filter('posts_join', 'ma_ellak_streaming_list_join');
	add_filter('posts_where','ma_ellak_streaming_list_where');
	add_filter('posts_orderby','ma_ellak_streaming_list_order_by');
	$my_query = new WP_Query($args);
	/*/ ----------- Debug ---------------
	 print_r($args);
	echo '<hr />';
	echo $my_query->request;
	echo '<hr />';
	echo count($postz);
	echo '<hr />';
	//----------------------------------*/
	remove_filter('posts_join','ma_ellak_streaming_list_join');
	remove_filter('posts_where','ma_ellak_streaming_list_where');
	remove_filter('posts_orderby','ma_ellak_streaming_list_order_by');
	
	if ($my_query->have_posts())
			ma_ellak_events_list($my_query,'streaming');
	else
		_e('Δεν υπάρχουν προγραμματισμένες μεταδόσεις.', 'ma_ellak');
	
	echo social_output();
}

function ma_ellak_streaming_array($limit){
	$args=ma_ellak_streaming_get_list_query($limit);
	$my_query=ma_ellak_streaming_get_result($args);
	$data=array();
	if ($my_query->post_count>0)
		$data=ma_ellak_streaming_return_data_day($my_query);
	return $data;
}

function ma_ellak_streaming_return_data_day($my_query){
	if( $my_query->have_posts() ){
		$i=0;
		while ($my_query->have_posts()) : $my_query->the_post(); 
			$eventid=get_the_ID();
			$meta=get_post_meta($eventid);
			$type='events';
			$link=get_permalink();
			$date=$meta['_ma_event_startdate_timestamp'][0];
			$title=get_the_title();
			$data[$i]['title']=$title;
			$data[$i]['link']=$link;
			$data[$i]['date']=$date;
			$data[$i]['type']=$type;
			$data[$i]['id']=$eventid;
			$i++;
		endwhile;
	}
	return $data;
}

function ma_ellak_get_events_day($day, $month, $year){
	$args=ma_ellak_get_event_day_query($day, $month, $year);
	$wp_query=ma_ellak_streaming_get_result($args);
	$data=ma_ellak_get_event_data($wp_query);
	return $data;
}

function ma_ellak_get_event_data($wp_query){
	$data=array();
	if ( $wp_query->have_posts() ) :
		while ( $wp_query->have_posts() ) : $wp_query->the_post();
			$post_id=get_the_ID();
			$meta=get_post_meta($post_id);
			$data['title']=get_the_title();
			$data['link']=get_permalink();
			$content=ma_ellak_return_unit_title($post_id);
			$content.=" ". date(MA_DATE_FORMAT, strtotime($meta['_ma_event_startdate_timestamp'][0]));
			$data['content']=$content;
		endwhile;
	endif;
	return $data;
}

function ma_ellak_get_event_day_query($day, $month, $year){
	$current_day=$month ."/". $day ."/". $year;
	$args = array(
        'post_type' => 'events',
		'posts_per_page' => 5,
		'ignore_sticky_posts'=> 1,
        'post_status' => 'publish',
        'meta_key' => '_ma_event_startdate_timestamp',
        'orderby' => '_ma_event_startdate_timestamp',
        'order' => 'DESC',
        'meta_query' => array(
			'relation' => 'AND',
			array(
				'key' => '_ma_event_startdate_timestamp',
				'value'=>$current_day,
				'compare' => '='
			)
		)
	);
	return $args;
}
/**
 * function that redirects to ma_ellak_live_streaming page.
 * it checks if it is the page templates
 * it also checks if it is a single event
 */
/*****************************************************************/
function ma_ellak_streaming_redirect(){
	
	$RedirectUrl = get_option_tree('ma_ellak_view_event_streaming');
	
	if(isset($RedirectUrl) && $RedirectUrl!=''){
		
		if(get_post_type()=='events' && is_singular()){
			global $post;
			$metaData = get_post_meta($post->ID);
			$Urls = get_post_meta($post->ID,'eventslive');
			
			$today = strtotime(date('d/m/y'));
			$start_time =  strtotime(get_post_meta( $post->ID, '_ma_event_startdate_timestamp', true ));
			$end_time =  strtotime(get_post_meta( $post->ID, '_ma_event_enddate_timestamp', true ));
			
			$today= strtotime(date('m/d/y'));
			$isLive = $metaData['_ma_event_live'][0];
			if($isLive=='on' && count($Urls[0])>0){
				
				if(!empty($end_time)){
					if($today >= $start_time && $today<=$end_time){
						wp_redirect(get_permalink($RedirectUrl)."?eventId=".$post->ID);
					}
				}else{
					$SdateD = date('d',$start_time);
					$SdateM = date('m',$start_time);
					$SdateY = date('Y',$start_time);
					$tomorrow = mktime(0,0,0,$SdateM,$SdateD+1,$SdateY);
					if($today>=$start_time && $today<$tomorrow)
						wp_redirect(get_permalink($RedirectUrl)."?eventId=".$post->ID);
				}
			}
		}else if (is_page_template('ma_ellak_tmpl_live_streaming.php')){
			$eventID = sanitize_text_field($_GET['eventId']);
			$metaData = get_post_meta($eventID);
			$Urls = get_post_meta($eventID,'eventslive');
			
			$today = strtotime(date('d/m/y'));
			//echo get_post_meta( $post->ID, '_ma_event_enddate_timestamp', true );
			$start_time =  strtotime(get_post_meta($eventID, '_ma_event_startdate_timestamp', true ));
			$end_time =  strtotime(get_post_meta($eventID, '_ma_event_enddate_timestamp', true ));
			$today= strtotime(date('m/d/y'));
			
			$isLive = $metaData['_ma_event_live'][0];
			if($isLive=='on' ){
				if(count($Urls[0])==0) wp_redirect(get_permalink($eventID));
				if(!empty($end_time)){
					if($today>$end_time){
						wp_redirect(get_permalink($eventID));
					}
				}else{
					$SdateD = date('d',$start_time);
					$SdateM = date('m',$start_time);
					$SdateY = date('Y',$start_time);
					$tomorrow = mktime(0,0,0,$SdateM,$SdateD+1,$SdateY);
					if($today>=$tomorrow)
						wp_redirect(get_permalink($eventID));
				}
			}
				
		}
	}
}

add_action("init","ma_ellak_streaming_redirect");
?>