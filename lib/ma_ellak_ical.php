<?php

function ical_feed()
{
	global $wpdb;
	$eid = 0;
	$events = '';
	$space = '      ';
	$blog_name = get_bloginfo('name');
	$blog_url = get_bloginfo('home');
	$format	=	'Ymd\THis' ;
	
	if (isset($_GET['debug']))
		define('DEBUG', true);
	
	if (isset($_GET['eid']))
		$eid = intval(trim($_GET['eid']));
	
	if ( 0 != $eid) {
		$post =  get_post($eid);
		$start_time = get_post_meta( $post->ID, '_ma_event_startdate_timestamp', true ). ' '.get_post_meta( $post->ID, '_ma_event_startdate_time', true ) ;
		$start_time = date_i18n($format ,strtotime($start_time));
		$end_time =  get_post_meta( $post->ID, '_ma_event_enddate_timestamp', true );
		
		if(!empty($end_time) and $end_time != ''){
			$endTimestamp = get_post_meta( $post->ID, '_ma_event_enddate_time', true );
			if(!empty($endTimestamp) and $endTimestamp != '')
				$end_time .= ' '. $endTimestamp;
			else 
				$end_time .= ' 11:59 PM';
		}else {
			$end_time = date_i18n($format, strtotime(get_post_meta( $post->ID, '_ma_event_startdate_timestamp', true ).' 11:59 PM'));
		}
		$end_time = date_i18n($format ,strtotime($end_time));
		
		//echo $start_time . '<br />';
		//echo $end_time ;
		//exit();
		
		$summary = $post->post_title;
		$permalink = get_permalink($post->ID);
		//$content = str_replace(',', '\,', str_replace('\\', '\\\\', str_replace("\n", "\n" . $space, strip_tags($post->post_excerpt))));
			//$content = $permalink . "\n" . $space . "\n" . $space . $content;
		$content =  addslashes(strip_tags($post->post_content));
		// Fotis Plus
		$uuid= md5($post->post_title) ;
		$tstamp = time();
		$location =  addslashes(get_post_meta( $post->ID, '_ma_event_place', true ));
		$events .= '
BEGIN:VEVENT
UID:'. $uuid .'
DTSTAMP:'. $tstamp .'
DTSTART:'. $start_time .'
DTEND:'. $end_time .'
SUMMARY:'. $summary .'
DESCRIPTION:'. $content .'
LOCATION:'. $location .'
URL;VALUE=URI:'. $permalink .'
END:VEVENT';

	} else {
		// This is for the Archive
		$today=date('m/d/Y');
		$args = array(
				'post_type' => 'events',
				'posts_per_page' => 10,
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
		global $wpdb;
	
		$wp_query = new WP_Query( $args );
		//query_posts(array('post_type'   => 'events'));
		while ( $wp_query->have_posts() ) : $wp_query->the_post();
			global $post;

			
			$start_time = get_post_meta( $post->ID, '_ma_event_startdate_timestamp', true ). ' '.get_post_meta( $post->ID, '_ma_event_startdate_time', true ) ;
			$start_time = date_i18n($format ,strtotime($start_time));
			$end_time =  get_post_meta( $post->ID, '_ma_event_enddate_timestamp', true );
				
			if(!empty($end_time) and $end_time != ''){
				$endTimestamp = get_post_meta( $post->ID, '_ma_event_enddate_time', true );
				if(!empty($endTimestamp) and $endTimestamp != '')
					$end_time .= ' '. $endTimestamp;
				else 
					$end_time .= ' 11:59 PM';
			}else {
					$end_time = date_i18n($format, strtotime(get_post_meta( $post->ID, '_ma_event_startdate_timestamp', true ).' 11:59 PM'));
			}
			$end_time = date_i18n($format ,strtotime($end_time));
			
			$summary = addslashes($post->post_title);
			$permalink = get_permalink($post->ID);
			//$content = str_replace(',', '\,', str_replace('\\', '\\\\', str_replace("\n", "\n" . $space, strip_tags($post->post_excerpt))));
			//$content = $permalink . "\n" . $space . "\n" . $space . $content;
			$content =  addslashes(strip_tags($post->post_excerpt));
			// Fotis Plus
			$uuid= md5($post->post_title) ;
			$tstamp = time();
			$location =  addslashes(get_post_meta( $post->ID, '_ma_event_place', true ));
			$events .= '
BEGIN:VEVENT
UID:'. $uuid .'
DTSTAMP:'. $tstamp .'
DTSTART:'. $start_time .'
DTEND:'. $end_time .'
SUMMARY:'. $summary .'
DESCRIPTION:'. $content .'
LOCATION:'. $location .'
URL;VALUE=URI:'. $permalink .'
END:VEVENT';
		endwhile;
	}
	
	if (!defined('DEBUG'))
	{
		header('Content-type: text/calendar');
		header('Content-Disposition: attachment; filename="maellak.ics"');
	}
	
	$content = 'BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//'.$blog_name.'//NONSGML v1.0//EN
X-WR-CALNAME:'.$blog_name.'
X-WR-TIMEZONE:US/Eastern
X-ORIGINAL-URL:'.$blog_url.'
X-WR-CALDESC:Events from '.$blog_name.'
CALSCALE:GREGORIAN
METHOD:PUBLISH'.$events.'
END:VCALENDAR';
	
	echo $content;
	exit;
}

if (isset($_GET['ical'])) { add_action('init', 'ical_feed'); }

?>