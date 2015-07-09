<?php
/*
Template Name: Events - List
*/
?>
<?php get_header(); ?>


<?php
/*
global $paged;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$type = 'events';
$pageType = (mysql_real_escape_string($_GET['pagetype'])) ? mysql_real_escape_string($_GET['pagetype']) : 1;
$compareTypeStart = '>=';
$compareTypeeNd='<';
if($pageType=='old') $compareTypeStart=$compareTypeeNd = '<';


$today=date('m/d/y');

$my_query="SELECT * FROM ma_posts  
INNER JOIN ma_postmeta AS mt ON (ma_posts.ID = mt.post_id)
WHERE ma_posts.post_type = 'events' 
AND (ma_posts.post_status = 'publish') 
AND (mt.meta_key = '_ma_event_startdate_timestamp' 
	AND STR_TO_DATE(mt.meta_value, '%m/%d/%Y') $compareTypeStart STR_TO_DATE('$today', '%m/%d/%Y'))
GROUP BY ma_posts.ID ORDER BY STR_TO_DATE(mt.meta_value, '%m/%d/%Y') DESC";
*/

global $paged;
global $pageType;
$pageType = (mysql_real_escape_string($_GET['pagetype'])) ? mysql_real_escape_string($_GET['pagetype']) : 1;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$args=array(
  'post_type' => 'events',
  'post_status' => 'publish',
  'posts_per_page' => 5,
  'paged'=>$paged,
);

add_filter('posts_join', 'ma_ellak_events_list_join' );
add_filter('posts_where','ma_ellak_events_list_where');
add_filter('posts_orderby','ma_ellak_events_list_order_by');
$my_query = new WP_Query($args);
/*/ ----------- Debug ---------------
	print_r($args);
	echo '<hr />';
	echo $my_query->request;
	echo '<hr />';
	echo count($postz);
	echo '<hr />';
//----------------------------------*/
remove_filter('posts_join','ma_ellak_events_list_join');
remove_filter('posts_where','ma_ellak_events_list_where');
remove_filter('posts_orderby','ma_ellak_events_list_order_by');
?>
<div class="row-fluid filters">
          <div class="span6">
            <?php if ($pageType=='old'){?>
            <a href="<?php echo get_permalink($postID); ?>">
            	<?php 
            		echo __('ΤΕΛΕΥΤΑΙΕΣ ΕΚΔΗΛΩΣΕΙΣ','ma-ellak');
            	?>
            </a>  
            <?php }?>
          </div>
          <div class="pull-right">
            <a href="<?php echo get_permalink($postID)."?pagetype=old"?>">
            	<?php 
            		echo __('ΠΑΛΑΙΟΤΕΡΕΣ ΕΚΔΗΛΩΣΕΙΣ','ma-ellak');
            	?>
            </a>
          </div>
   </div>
<?php 

ma_ellak_events_list($my_query);
wp_reset_query();  // Restore global post data stomped by the_post().

?>

        
<?php echo social_output();?>
<?php get_footer(); ?>