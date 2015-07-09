<?php

  /**
  *@desc A single blog post See page.php is for a page layout.
  */

  get_header();

  if (have_posts()) : while (have_posts()) : the_post();
  
	global $ma_prefix;
	$job_id = get_the_ID();
	$cur_user = wp_get_current_user();
	
	$job_status = get_post_meta($job_id, $ma_prefix . 'job_status', true);
	$job_expiration = get_post_meta($job_id, $ma_prefix . 'job_expiration', true);
	$job_applicant = get_post_meta($job_id, $ma_prefix . 'job_applicant_type', true);
	$job_complete_comment = get_post_meta($job_id, $ma_prefix . 'job_complete_comment', true);

	$job_contact_point_name = get_post_meta($job_id, $ma_prefix . 'job_contact_point_name', true);
	$job_contact_point_foreas = get_post_meta($job_id, $ma_prefix . 'job_contact_point_foreas', true);
	$job_contact_point_email = get_post_meta($job_id, $ma_prefix . 'job_contact_point_email', true);
	$job_contact_point_phone = get_post_meta($job_id, $ma_prefix . 'job_contact_point_phone', true);
  ?>

    <div class="row-fluid">
	<div class="span5 characteristic-sidebar software-sidebar">
		<ul class="characteristic-details">
			
			<?php 
				$jobtype = wp_get_post_terms(get_the_ID(), 'jobtype');
				if(count($jobtype) != 0){ ?>
			<li><span><?php _e('Τύπος Εργασίας', 'ma-ellak'); ?></span>&nbsp;&nbsp;&nbsp;<?php 
					foreach ($jobtype  as $term)
						echo ''.$term->name .'' ; ?>
			</li>
			<?php } ?>
			<?php 
				$package = wp_get_post_terms(get_the_ID(), 'package');
				if(count($package) != 0){ ?>
			<li><span><?php _e('Πακέτα Λογισμικού', 'ma-ellak'); ?></span>&nbsp;&nbsp;&nbsp;<?php 
					foreach ($package  as $term)
						echo '<div class="term_item">'.$term->name .'</div>' ; ?>
			</li>
			<?php } ?>
			<?php if($job_foreas){?>
			<li><span><?php _e('Φορεας', 'ma-ellak'); ?></span>&nbsp;&nbsp;&nbsp;<?php echo $job_foreas; ?></li>
			<?php }?>
			<li><span><?php _e('Ημερομηνία Δημοσίευσης', 'ma-ellak'); ?></span>&nbsp;&nbsp;&nbsp;<?php echo the_date('j/m/Y'); ?></li>
			<?php if($job_expiration){?>
			<li><span><?php _e('Ημερομηνία Λήξης', 'ma-ellak'); ?></span>&nbsp;&nbsp;&nbsp;<?php echo  mysql2date('j/m/Y', $job_expiration); ?></li>
			<?php }?>
			
		</ul>
		<div class="characteristic-views">
			<?php 
				$views = ma_ellak_show_statistics(get_the_ID(), 'job');
				if (!isset($views))
					$views=0;
			?>
			<i class="icon-eye-open"></i> <?php echo $views; ?> 
		</div>
		<?php if($job_status == 'active') {  ?>
			<?php
				if(is_user_logged_in() && user_has_profile()){ 
					if(!user_can_apply_for($cur_user->ID, $job_id)) { ?>
				<?php }else if(user_has_applied_for($cur_user->ID, $job_id)){  ?>
					<div id="application_placeholder"><p><?php _e('Έχετε ήδη Υποβάλλει Αίτηση','ma-ellak'); ?></p></div>
			<?php	} else {
				?>
				<div id="application_placeholder">
				<a href="" id="interest_on_job" name="interest_on_job" usr="<?php echo $cur_user->ID; ?>" job="<?php echo $job_id; ?>" class="btn btn-primary btn-block"><?php _e('ΕΚΔΗΛΩΣΗ ΕΝΔΙΑΦΕΡΟΝΤΟΣ', 'ma-ellak');?></a>
				</div>
			<?php 	
				} }
			?>
			<div class="contactpoint-view">
				<div class="contactpoint">
					<h4><?php _e('Στοιχεία υπευθύνου', 'ma-ellak'); ?></h4>
					<?php echo "<strong>".__('Ονοματεπώνυμο ', 'ma-ellak')."</strong>"; echo $job_contact_point_name ."<br>"; ?>
					<?php
						if ($job_contact_point_foreas!=''){
							echo "<strong>".__('Φορέας ', 'ma-ellak')."</strong>"; 
							echo $job_contact_point_foreas ."<BR>";
						}
						if ($job_contact_point_email!=''){
							echo "<strong>".__('Email ', 'ma-ellak')."</strong>"; 
							echo $job_contact_point_email ."<BR>";
						}
						if ($job_contact_point_phone!=''){
							echo "<strong>".__('Τηλέφωνο ', 'ma-ellak')."</strong>";
							echo $job_contact_point_phone;
						}
					?>
				</div>
			</div>
		<?php } ?>
		<p class="single_edit_sidebar"><?php ma_ellak_single_edit_permalink(); ?></p>
  	</div>
  	<div class="span7">
		 <div class="row-fluid">
			<div class="span12 comment-seperator">
			<?php echo social_output();  ?><br />
			<?php echo get_job_status_name($job_status);?>
			  <p><?php the_content(__('(more...)')); ?></p>
				<?php if($job_status == 'done'){  ?>
					<div class="done-user magenta"><?php 
						$accepted = get_post_meta($job_id, '_ma_ellak_accepted_user', true );
						$args = array(
							'post_per_page' => 1,
							'post_type' => 'profile',
							'post_status' => 'publish', 
							'author' => $accepted
						);
						$profiles = get_posts($args);
						foreach($profiles as $user){					
							echo '<p>'.__('Υλοποιήθηκε απο', 'ma-ellak').' <a href="'.get_permalink($user->ID).'" >'.$user->post_title . '</a>';
							$uvote = intval(get_post_meta($job_id, '_ma_accepted_user_vote', true));
							echo ' ( '.$uvote.'&nbsp;&nbsp;';
							for ($i = 1; $i <= $uvote; $i++) {
								echo '<i class="icon-star"></i>&nbsp;&nbsp;';
							}
							echo ' )</p>';
						} 
					 ?></div>
					<?php 
						$classname = 'done-job-comments';
						$complete_descr = __('Επιτυχής Ολοκλήρωσης της Εργασίας', 'ma-ellak');
						$job_success = get_post_meta($job_id,'_ma_job_success', true);
						if($job_success != 'yes'){
							$classname .= ' noncomplete-job';
							$complete_descr = __('Μη Επιτυχής Ολοκλήρωσης της Εργασίας', 'ma-ellak');
						}
					?>
					 <div class="<?php echo $classname; ?>">
						<h4><?php echo $complete_descr ; ?></h4>
						<?php echo apply_filters('the_content', $job_complete_comment); ?>
					</div>
			   <?php }  ?>
			    <?php the_tags('<span class="profil-tags">','</span><span class="profil-tags">','</span>&nbsp;<br/><br/>'); ?>
			</div>
		</div>
	</div>
</div><!-- row-fluid -->

	<?php

  endwhile; else: ?>

		<p>Sorry, no posts matched your criteria.</p>

<?php
  endif;
  get_footer();

?>