<?php
/*
Template Name: View All News
*/


get_header(); 

$shown_content_types = array('events', 'video', 'software', 'document', 'bp_doc', 'characteristic', 'job');

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$arguments = array(
	'post_status' => 'publish',
	'post_type' =>  $shown_content_types,
	'paged'=>$paged,
);

$all_query = new WP_Query($arguments);

if ($all_query->have_posts()) : while ($all_query->have_posts()) : $all_query->the_post();
?>

	<div class="row-fluid event">
		<div class="cols">
			<div class="span10 offset2 col">
				 <h3><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title();?>" class="btn btn-large btn-link"><?php the_title(); ?></a></h3>
				<p class="meta"><span>
				<?php if($post->post_type=='events'){
                            $data = get_post_meta($post->ID,'_ma_events_type', true);
                               echo get_posttype_label($post->post_type,$data);     
                            }else 
                                echo get_posttype_label($post->post_type);
                            echo " ";?>
				<?php echo ma_ellak_print_unit_title($post->ID);?> 
				<?php echo ma_ellak_print_thema($post->ID,'thema');?></span> <span><?php the_date(); ?></span></p>
			</div>
		</div>
	</div>
	
	<?php
	  endwhile; else: endif; 
	  	if( $all_query->max_num_pages>1){
		pagination(false, false, $all_query);
	}
	  ?>
	  
<?php 
get_footer(); 
?>