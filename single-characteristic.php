<?php

  /**
  *@desc A single blog post See page.php is for a page layout.
  */

  get_header();

  if (have_posts()) : while (have_posts()) : the_post();
	global $ma_prefix;
	$type = get_post_meta(get_the_ID(), $ma_prefix.'characteristic_type', true);
	
	$status =  get_post_meta(get_the_ID(), $ma_prefix.'stage_status', true);
	$acceptance = get_post_meta(get_the_ID(), $ma_prefix.'characteristic_acceptance', true);
	$track_change_url = get_post_meta(get_the_ID(), $ma_prefix.'track_change_url', true);
	$softId = get_post_meta(get_the_ID(), $ma_prefix.'for_software', true);
  ?>

    <div class="row-fluid">
	<div class="span4 characteristic-sidebar gnorisma">
		<div class="characteristic-rounder">
			<?php the_ratings();?>
			<img src="<? echo get_bloginfo('template_directory'); ?>/images/bg-characteristic.png" class="bg-characteristic" alt="grade" title="grade"/>
		</div>
		<?php 
			if(!empty($status)){
				echo '<div class="characteristic-selected">'.get_status_name($status).'</div>';
			}
		?>
		<div class="characteristic-views">
			<?php 
				$views = ma_ellak_show_statistics(get_the_ID(), 'characteristic');
				if (!isset($views))
					$views=0;
			?>
			<i class="icon-eye-open"></i> <?php echo $views; ?> 
			<?php if(function_exists('like_counter_p')) { like_counter_p(''); } ?>
			<?php if(function_exists('dislike_counter_p')) { dislike_counter_p(''); } ?>
		</div>
		<ul class="characteristic-details">
			<li><span><?php _e('Λογισμικό', 'ma-ellak'); ?></span>
				<?php echo get_about_software(); ?>
			</li>
			<li><span><?php _e('Τύπος', 'ma-ellak'); ?></span>
			<?php 
					if($type=='gnorisma') echo __('Γνώρισμα', 'ma-ellak');
					else echo __('Χαρακτηριστικό', 'ma-ellak'); ?>
			</li>
			<?php if(!empty($track_change_url)){ ?>
				<li><span><?php _e('Ticket', 'ma-ellak'); ?></span>
				<a href="<?php echo $track_change_url?>" target="_blank"><?php _e('Σύνδεσμος Αποθετηρίου', 'ma-ellak'); ?></a>
			</li>
			<?php } ?>
			<li><span><?php _e('Ημερομηνία', 'ma-ellak'); ?></span><?php echo the_date(MA_DATE_FORMAT); ?></li>
			<li><?php echo ma_ellak_print_unit_title($softId); ?></li>
			<li><?php echo ma_ellak_print_thema($softId,'thema'); ?></li>
			<li><br/></li>
			<li><?php ma_ellak_single_edit_permalink(); ?></li>
			
		</ul>
		
  	</div>
  	<div class="span8">
		 <div class="row-fluid">
			<div class="span12 comment-seperator">
			  <p><?php the_content(__('(more...)')); ?></p>
			  <?php if($status == 'done'){  ?>
				<div class="done-comments"><?php echo apply_filters('the_content', $acceptance); ?></p></div>
			   <?php }  ?>
			</div>
		</div>
		<?php comments_template();?>
	</div>
</div><!-- row-fluid -->

	<?php

  endwhile; else: ?>

		<p>Δεν βρέθηκε κάποιο γνώρισμα που να ικανοποιεί τα κριτήρια που θέσατε.</p>

<?php
  endif;

  get_footer();

?>