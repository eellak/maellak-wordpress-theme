<?php

function ma_ellak_get_calendar( $var_monthnum = null, $var_year = null, $initial = true, $echo = true) {
	global $wpdb, $m, $wp_locale, $posts;
	
	if(empty($var_monthnum))
		$monthnum = date('m');
	else
		$monthnum = $var_monthnum;
		
	if(empty($var_year))
		$year = date('Y');
	else
		$year = $var_year;
	
	/*
	$cache = array();
	$key = md5( $m . $monthnum . $year );
	if ( $cache = wp_cache_get( 'get_calendar', 'calendar' ) ) {
		if ( is_array($cache) && isset( $cache[ $key ] ) ) {
			if ( $echo ) {
				echo apply_filters( 'get_calendar',  $cache[$key] );
				return;
			} else {
				return apply_filters( 'get_calendar',  $cache[$key] );
			}
		}
	}

	if ( !is_array($cache) )
		$cache = array();

	//Quick check. If we have no posts at all, abort!
	if ( !$posts ) {
		$gotsome = $wpdb->get_var("SELECT 1 as test FROM $wpdb->posts WHERE post_type = 'events' AND post_status = 'publish' LIMIT 1");
		if ( !$gotsome ) {
			$cache[ $key ] = '';
			wp_cache_set( 'get_calendar', $cache, 'calendar' );
			return;
		}
	} */

	if ( isset($_GET['w']) )
		$w = ''.intval($_GET['w']);

	// week_begins = 0 stands for Sunday
	$week_begins = intval(get_option('start_of_week'));

	// Let's figure out when we are
	if ( !empty($monthnum) && !empty($year) ) {
		$thismonth = ''.zeroise(intval($monthnum), 2);
		$thisyear = ''.intval($year);
	} elseif ( !empty($w) ) {
		// We need to get the month from MySQL
		$thisyear = ''.intval(substr($m, 0, 4));
		$d = (($w - 1) * 7) + 6; //it seems MySQL's weeks disagree with PHP's
		$thismonth = $wpdb->get_var("SELECT DATE_FORMAT((DATE_ADD('{$thisyear}0101', INTERVAL $d DAY) ), '%m')");
	} elseif ( !empty($m) ) {
		$thisyear = ''.intval(substr($m, 0, 4));
		if ( strlen($m) < 6 )
				$thismonth = '01';
		else
				$thismonth = ''.zeroise(intval(substr($m, 4, 2)), 2);
	} else {
		$thisyear = gmdate('Y', current_time('timestamp'));
		$thismonth = gmdate('m', current_time('timestamp'));
	}

	$unixmonth = mktime(0, 0 , 0, $thismonth, 1, $thisyear);
	$last_day = date('t', $unixmonth);
	
	$month_day = "$thismonth/01/$thisyear";

	/* Get the next and previous month and year with at least one post
	$previous = $wpdb->get_row("SELECT MONTH(post_date) AS month, YEAR(post_date) AS year
		FROM $wpdb->posts
		WHERE post_date < '$thisyear-$thismonth-01'
		AND post_type = 'events' AND post_status = 'publish'
			ORDER BY post_date DESC
			LIMIT 1");
	$next = $wpdb->get_row("SELECT MONTH(post_date) AS month, YEAR(post_date) AS year
		FROM $wpdb->posts
		WHERE post_date > '$thisyear-$thismonth-{$last_day} 23:59:59'
		AND post_type = 'events' AND post_status = 'publish'
			ORDER BY post_date ASC
			LIMIT 1");
	*/
	
	$next = arrayToObject(array('month'=> date("m", strtotime("$month_day  +1 month")), 'year'=> date("Y", strtotime("$month_day +1 month"))));	
	$previous = arrayToObject(array('month'=> date("m", strtotime("$month_day  -1 month")), 'year'=> date("Y", strtotime("$month_day -1 month"))));
	
	/* translators: Calendar caption: 1: month name, 2: 4-digit year */
	$calendar_caption = _x('%1$s %2$s', 'calendar caption');
	$calendar_output = '<table class=" table-condensed">
	<caption>' . sprintf($calendar_caption, $wp_locale->get_month($thismonth), date('Y', $unixmonth)) . '</caption>
	<thead>
	<tr>';

	$myweek = array();

	for ( $wdcount=0; $wdcount<=6; $wdcount++ ) {
		$myweek[] = $wp_locale->get_weekday(($wdcount+$week_begins)%7);
	}

	foreach ( $myweek as $wd ) {
		$day_name = (true == $initial) ? $wp_locale->get_weekday_initial($wd) : $wp_locale->get_weekday_abbrev($wd);
		$wd = esc_attr($wd);
		$calendar_output .= "\n\t\t<th scope=\"col\" title=\"$wd\">$day_name</th>";
	}

	$calendar_output .= '
	</tr>
	</thead>

	<tfoot>
	<tr>';

	if ( $previous ) {
		$calendar_output .= "\n\t\t".'<td colspan="3" id="prev"><a class="changecal" href="#" data="'.$previous->year.'-'.$previous->month.'" title="' . esc_attr( sprintf(__('View posts for %1$s %2$s'), $wp_locale->get_month($previous->month), date('Y', mktime(0, 0 , 0, $previous->month, 1, $previous->year)))) . '">&laquo; ' . $wp_locale->get_month_abbrev($wp_locale->get_month($previous->month)) . '</a></td>';
	} else {
		$calendar_output .= "\n\t\t".'<td colspan="3" id="prev" class="pad">&nbsp;</td>';
	}

	$calendar_output .= "\n\t\t".'<td class="pad">&nbsp;</td>';

	if ( $next ) {
		$calendar_output .= "\n\t\t".'<td colspan="3" id="next"><a class="changecal" href="#" data="'.$next->year.'-'.$next->month.'" title="' . esc_attr( sprintf(__('View posts for %1$s %2$s'), $wp_locale->get_month($next->month), date('Y', mktime(0, 0 , 0, $next->month, 1, $next->year))) ) . '">' . $wp_locale->get_month_abbrev($wp_locale->get_month($next->month)) . ' &raquo;</a></td>';
	} else {
		$calendar_output .= "\n\t\t".'<td colspan="3" id="next" class="pad">&nbsp;</td>';
	}

	$calendar_output .= '
	</tr>
	</tfoot>

	<tbody>
	<tr>';

	/* Get days with posts
	$dayswithposts = $wpdb->get_results("SELECT DISTINCT DAYOFMONTH(post_date)
		FROM $wpdb->posts WHERE post_date >= '{$thisyear}-{$thismonth}-01 00:00:00'
		AND post_type = 'events' AND post_status = 'publish'
		AND post_date <= '{$thisyear}-{$thismonth}-{$last_day} 23:59:59'", ARRAY_N);
	if ( $dayswithposts ) {
		foreach ( (array) $dayswithposts as $daywith ) {
			$daywithpost[] = $daywith[0];
		}
	} else {
		$daywithpost = array();
	}
*/
	if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false || stripos($_SERVER['HTTP_USER_AGENT'], 'camino') !== false || stripos($_SERVER['HTTP_USER_AGENT'], 'safari') !== false)
		$ak_title_separator = "\n";
	else
		$ak_title_separator = ', ';

	$ak_titles_for_day = array();
	$content_for_day = array();
	$daywithpost = array();
	/*
	$ak_post_titles = $wpdb->get_results("SELECT ID, post_title, DAYOFMONTH(post_date) as dom "
		."FROM $wpdb->posts "
		."WHERE post_date >= '{$thisyear}-{$thismonth}-01 00:00:00' "
		."AND post_date <= '{$thisyear}-{$thismonth}-{$last_day} 23:59:59' "
		."AND post_type = 'events' AND post_status = 'publish'"
	); */
	
	$month_day_next = $next->month."/01/$thisyear";
	/*
	$args=array(
	  'post_type' => 'events',
	  'post_status' => 'publish',
	  'posts_per_page' => 30,
	  'caller_get_posts'=> 1,
	  'meta_key' => '_ma_event_startdate_timestamp',
	  'orderby' => 'meta_value',
	  'order' => 'ASC',
			'meta_query' => array(
					'relation' => 'AND',
					'type' => 'DATE',
					array(
							'key' => '_ma_event_startdate_timestamp',
							'value'=>$month_day,
							'compare' => '>='
					),
					array(
							'key' => '_ma_event_startdate_timestamp',
							'value'=>$month_day_next,
							'compare' => '<'
					)
			)
			
	  );

	*/
	
	global $wpdb;
	
	$cal_post_ids = $wpdb->get_col("SELECT   ma_posts.ID FROM ma_posts  INNER JOIN ma_postmeta ON (ma_posts.ID = ma_postmeta.post_id)
INNER JOIN ma_postmeta AS mt1 ON (ma_posts.ID = mt1.post_id)
INNER JOIN ma_postmeta AS mt2 ON (ma_posts.ID = mt2.post_id) WHERE ma_posts.post_type = 'events' AND (ma_posts.post_status = 'publish') AND (ma_postmeta.meta_key = '_ma_event_startdate_timestamp'
AND  (mt1.meta_key = '_ma_event_startdate_timestamp' AND STR_TO_DATE(mt1.meta_value, '%m/%d/%Y') >= STR_TO_DATE('$month_day', '%m/%d/%Y'))
AND  (mt2.meta_key = '_ma_event_startdate_timestamp' AND STR_TO_DATE(mt2.meta_value, '%m/%d/%Y') < STR_TO_DATE('$month_day_next', '%m/%d/%Y')) ) GROUP BY ma_posts.ID ORDER BY STR_TO_DATE(ma_postmeta.meta_value, '%m/%d/%Y') ASC LIMIT 0, 30");
	
		
	//echo "<pre>";
	//print_r($cal_post_ids);
    //print_r( $wpdb->queries );
    //echo "</pre>";
	

	if ( $cal_post_ids ) {
		foreach ( (array) $cal_post_ids as $cal_post_id ) {
				
				$ak_post_title = get_post( intval( $cal_post_id ) );
				
				$post_title = esc_attr( apply_filters( 'the_title', $ak_post_title->post_title, $ak_post_title->ID ) );
				
				$start = get_post_meta($ak_post_title->ID, '_ma_event_startdate_timestamp', true);
				$day_of_month = date('j', strtotime($start));
				$daywithpost[] = $day_of_month;
				//echo $day_of_month;
				
				if ( empty($ak_titles_for_day['day_'.$day_of_month]) )
					$ak_titles_for_day['day_'.$day_of_month] = '';
					
				if ( empty($ak_titles_for_day["$day_of_month"]) ) {	// first one
					$ak_titles_for_day["$day_of_month"] = $post_title;
					$content_for_day["$day_of_month"] = 
						'<a id="popoverData-'.$ak_post_title->ID.'" 
						href="#" 
						data-href='.get_permalink($ak_post_title->ID).'
						data-original-title="'.$post_title.'" 
						data-trigger="hover" 
						rel="popover" 
						data-content=" '.date(MA_DATE_FORMAT,strtotime($start)).'"
						>'.$day_of_month.'</a>';
				} else{
					// Εν δυνάμει bug : Δείχνει μονο την τελευταία εκδήλωση μιας ημέρας
					$ak_titles_for_day["$day_of_month"] .= $ak_title_separator . $post_title;
					$content_for_day["$day_of_month"] = 
						'<a id="popoverData-'.$ak_post_title->ID.'" 
						href="#" 
						data-href='.get_permalink($ak_post_title->ID).'
						data-original-title="'.$post_title.'" 
						data-trigger="hover" 
						rel="popover" 
						data-content=" '.date(MA_DATE_FORMAT,strtotime($start)).'"
						>'.$day_of_month.'</a>';
				}
		}
	}

	// See how much we should pad in the beginning
	$pad = calendar_week_mod(date('w', $unixmonth)-$week_begins);
	if ( 0 != $pad )
		$calendar_output .= "\n\t\t".'<td colspan="'. esc_attr($pad) .'" class="pad">&nbsp;</td>';

	$daysinmonth = intval(date('t', $unixmonth));
	for ( $day = 1; $day <= $daysinmonth; ++$day ) {
		if ( isset($newrow) && $newrow )
			$calendar_output .= "\n\t</tr>\n\t<tr>\n\t\t";
		$newrow = false;

		if ( $day == gmdate('j', current_time('timestamp')) && $thismonth == gmdate('m', current_time('timestamp')) && $thisyear == gmdate('Y', current_time('timestamp')) )
			$calendar_output .= '<td id="today">';
		else if ( in_array($day, $daywithpost) ) 
			$calendar_output .= '<td class="active day">';
		else
			$calendar_output .= '<td>';
		
		if ( in_array($day, $daywithpost) ) { // any posts today?
				//$calendar_output .= '<a href="' . get_day_link( $thisyear, $thismonth, $day ) . '" title="' . esc_attr( $ak_titles_for_day[ $day ] ) . "\">$day</a>";
				$calendar_output .= $content_for_day[$day] ;
		} else if ( $day == gmdate('j', current_time('timestamp')) && $thismonth == gmdate('m', current_time('timestamp')) && $thisyear == gmdate('Y', current_time('timestamp')) )
			$calendar_output .= '<strong>'.$day.'</strong>';
		else
			$calendar_output .= $day;
		
		$calendar_output .= '</td>';

		if ( 6 == calendar_week_mod(date('w', mktime(0, 0 , 0, $thismonth, $day, $thisyear))-$week_begins) )
			$newrow = true;
	}

	$pad = 7 - calendar_week_mod(date('w', mktime(0, 0 , 0, $thismonth, $day, $thisyear))-$week_begins);
	if ( $pad != 0 && $pad != 7 )
		$calendar_output .= "\n\t\t".'<td class="pad" colspan="'. esc_attr($pad) .'">&nbsp;</td>';

	$calendar_output .= "\n\t</tr>\n\t</tbody>\n\t</table>";

	$cache[ $key ] = $calendar_output;
	wp_cache_set( 'get_calendar', $cache, 'calendar' );

	if ( $echo )
		echo apply_filters( 'get_calendar',  $calendar_output );
	else
		return apply_filters( 'get_calendar',  $calendar_output );

}

?>