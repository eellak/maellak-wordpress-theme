<?php
/*
Template Name: Personal Content Page
*/

if(!is_user_logged_in())
	wp_redirect(get_bloginfo('url'));

get_header(); 

$cur_user = wp_get_current_user();	

$shown_content_types = array('events', 'video', 'software', 'document', 'bp_doc', 'characteristic', 'job');

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$arguments = array(
	'posts_per_page' => -1,
	'post_status' => 'publish',
	'post_type' =>  $shown_content_types,
	'author' => $cur_user -> ID,
	'paged'=>$paged,
);
$user_posts = get_posts($arguments); 

foreach( $user_posts as $post ) { 
	setup_postdata($post); 
?>

	<div class="row-fluid event">
		<div class="cols">
			<div class="span10 offset2 col">
				<p><a href="<?php the_permalink(); ?>" class="btn btn-large btn-link"><?php the_title(); ?></a> <?php echo ma_ellak_single_edit_permalink($post); ?></p>
				<p class="meta"><span>
				<?php if($post->post_type=='events'){
                            $data = get_post_meta($post->ID,'_ma_events_type', true);
                                
                                    echo get_posttype_label($post->post_type,$data);
                                    
                            }else 
                                echo get_posttype_label($post->post_type);
                            echo " ";?>
				
				<?php echo ma_ellak_print_thema($post->ID,'thema');?></span> <span><?php the_date(); ?></span></p>
			</div>
		</div>
	</div>
	
<?php	
}
wp_reset_query();

if(count($user_posts)<1){ ?>
	<div class="row-fluid event">
		<div class="cols">
			<div class="span10 offset2 col">
				<p><?php _e('Δεν έχετε ακόμα καταχωρίσεις.','ma-ellak'); ?></p>
			</div>
		</div>
	</div>
<?php
}
get_footer(); 
?>