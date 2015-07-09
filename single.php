<?php

  /**
  *@desc A single blog post See page.php is for a page layout.
  */

  get_header();

  if (have_posts()) : while (have_posts()) : the_post();
  ?>

    <div class="row-fluid">
  	<div class="span8">
  	<p  class="meta purple">
  	 <small><?php the_date(); ?>  <?php echo __('ΑΠΟ','ma-ellak')."&nbsp;"; the_author(); ?></small>
      <?php //echo get_avatar( $comment, 32 ); ?>  
  	</p>
      
      <p><?php the_content(__('(more...)')); ?></p>
      <?php ma_ellak_print_tags();?>
      <?php ma_ellak_print_categories();?>
	</div><!-- span8 end -->
  	<div class="span4 sidebar">
  		<?php get_sidebar()?>
  	</div><!-- span4 end -->
 </div><!-- row-fluid -->
 <div class="row-fluid">
 		<p><?php edit_post_link(__('Edit'), ''); ?></p>
 </div>

     
  
    

	<?php

  comments_template();

  endwhile; else: ?>

		<p>Sorry, no posts matched your criteria.</p>

<?php
  endif;

  get_footer();

?>