<?php
/*
Template Name: Characteristic - List Unapproved
*/

get_header();

	if (have_posts()) : while (have_posts()) : the_post();
	endwhile; else: endif;
	wp_reset_query();
	
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;		
	
	global $ma_prefix;
	$software_post;
	$software_id = 0;
	$proceed = false;
	if(isset($_GET['sid']) and $_GET['sid'] !=''){
		$software_post = get_post(intval($_GET['sid']));
		if(!empty($software_post) and 'software' == $software_post->post_type) {
			$software_id =intval($_GET['sid']);
			if(ma_ellak_user_is_post_admin($software_post)){
				$proceed = true;
			}
		}
	} 
	if($proceed ){
	
	$args = array(
		'post_per_page' => 10,
		'post_type' => 'characteristic',
		'post_status' => 'draft', 
		'paged' => $paged,
	);
	
	$args['meta_query'] = array(
		array(
			'key' => $ma_prefix.'for_software',
			'value' => $software_id,
		)
	);

	
	//print_r($args);
	$posts = get_posts($args);
		
?>
<div class="row-fluid">&nbsp;</div>
<div class="row-fluid">
	<div class="span6">
		<h4><?php _e('Κατάλογος Μη Δημοσιευμένων Γνωρισμάτων', 'ma-ellak'); ?></h4>
	</div>
	<div class="span6">
	<?php if($software_id != 0){ ?>
		<?php echo __('ΑΦΟΡΑ ΤΟ ΛΟΓΙΣΜΙΚΟ','ma-ellak');?>:
			<a href="<?php echo get_permalink($software_id) ?>" rel="bookmark" title="<?php echo get_the_title($software_id);?>" class="btn btn-large btn-link">
				 <?php echo get_the_title($software_id); ?>
			</a>
	<?php } ?>
	</div>
</div>

<div class="row-fluid">&nbsp;</div>

<div class="row-fluid">
	<div class="span8 char-list offset2">
	
<?php
		foreach($posts as $post){ setup_postdata($post);
		
	?>
		<div class="row-fluid event">
			<div class="cols">
				
				<div class="span8 text col">
					<h3><a href="<?php echo get_permalink($post->ID); ?>" rel="bookmark" title="<?php the_title();?>" class="btn btn-large btn-link"><?php the_title(); ?></a></h3>
					<?php  the_excerpt_max_charlength(250);?>
					<p>	
						<?php ma_ellak_single_edit_permalink(); ?>
					</p>
				</div>
			</div>
		</div>
  		<?php }
		if(count($posts) == 0){
			_e('Δεν υπάρχουν Γνωρίσματα ή Χαρακτηριστικά Μη Δημοσιευμένα.', 'ma_ellak');
		}
		?>
	</div><!-- span8 -->
	
  	<div class="span4"></div>
	
 </div>
 <?php 
 next_posts_link(); 
 previous_posts_link();
 ?>
<?php
	} else {
		_e('Δεν έχετε δικαίωμα πρόσβασης σε αυτή τη σελίδα.', 'ma_ellak');
	}
  get_footer();
?>