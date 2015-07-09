<?php

  /**
  *@desc A single blog post See page.php is for a page layout.
  */

  get_header();
  
  
  ?>
  <div class="row-fluid">
  <div class="span8">
  
  

  <?php 
  if (have_posts()) : while (have_posts()) : the_post();
	
  ?>

		<div class="row-fluid event">
	     <div class="cols">
	     
	     <div class="span12 text col">
	       <h3><a href="<?php the_permalink() ?>" rel="bookmark" 
	       title="<?php the_title();?>" class="btn btn-large btn-link"><?php the_title(); ?></a></h3>
	       <p  class="meta purple">
	     
	       <?php echo ma_ellak_print_unit_title(get_the_ID());?>  
		       <?php echo ma_ellak_print_thema(get_the_ID(),'thema');?>
</p>
	       <?php  the_excerpt_max_charlength(240);?>
	       
	    </div><!-- span8 text col -->
	     </div><!-- cols -->
	   </div><!-- row-fluid event -->
	    <div class="row-fluid">
 			<p><?php //edit_post_link(__('Edit'), ''); ?></p>
 			
		</div>
	
	<?php
	  endwhile; else: ?>
  		<p> <?php _e('Δεν υπάρχει περιεχόμενο','ma-ellak');?></p>
  		 <?php endif; ?>
		<?php 
		global $wp_query;
	if( $wp_query->max_num_pages>1){
		pagination(false, false, $wp_query);
	}
			?>
  </div><!-- span8 -->
  	<div class="span4 sidebar">
  		<?php get_sidebar()?>
		<br/><br/>
  		</div><!-- span4 end -->
 </div><!-- row-fluid -->
 <?php 
 next_posts_link(); 
 previous_posts_link();
 ?>
<?php

  get_footer();

?>