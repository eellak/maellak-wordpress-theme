<?php
/*
Template Name: Profile - Hire
*/
get_header();
	$success = false;
	$ma_message = '';

	//Display only the jobs the user has applied for
	$profile_post = get_post($profile_id);
	$user_applied = $profile_post->post_author;
	$all_jobs_applied_for = get_user_meta($user_applied, '_ma_ellak_all_jobs_applied', true );

	global $ma_prefix;
	/**get the author**/
	$cur_user = wp_get_current_user();
	$author_id = $cur_user->ID;

	/**get the profile id**/
	if (!isset($_GET['profile_id']))
		_e('Θα πρέπει να παρέχετε ένα αναγνωριστικό για το συγκεκριμένο προφίλ.','ma-ellak');
	else if (intval($_GET['profile_id'])!=0){
		$profile_id=intval($_GET['profile_id']);
		$profile_type = get_post_meta( $profile_id, $ma_prefix . 'profile_type', true);

		if ($profile_type=='')
			$applicant_type='nomatter';
		else if ($profile_type=='professional')
			$applicant_type='professional';
		else if ($profile_type=='volunteer')
			$applicant_type='volunteer';

		if ($profile_type=='volunteer' || $profile_type=='professional'){
			$args = array(
				'post_type' => 'job',
				'paged' => $paged,
				'ignore_sticky_posts'=> 1,
				'post_status' => 'publish',
				'meta_query'=>array(
					'relation'=>'AND',
						array(
							'key'=>$ma_prefix.'job_status',
							'value'=>'active',
							'compare' => '='
						),
						array(
							'key'=>'_ma_job_applicant_type',
							array('value'=>$applicant_type),
							array('value'=>'nomatter'),
							'relation'=>'OR',
							'compare' => '='
						)
				)
			);
		}
		else{
			$args = array(
				'post_type' => 'job',
				'paged' => $paged,
				'ignore_sticky_posts'=> 1,
				'post_status' => 'publish',
				'meta_query'=>array(
					'relation'=>'AND',
						array(
							'key'=>$ma_prefix.'job_status',
							'value'=>'active',
							'compare' => '='
						),
						array(
							'key'=>'_ma_job_applicant_type',
							'relation'=>'OR',
							array('value'=>'professional'),
							array('value'=>'volunteer'),
							array('value'=>'nomatter'),
							'compare' => '='
						)
				)
			);
		}
		global $wpdb;
		$posts = get_posts($args);
		/*************************PRINTING********************/
		$link_page=get_permalink($profile_id);?>
		<div class="row-fluid">&nbsp;</div>
		<div class="row-fluid">
			<div class="span12">
				<ul class="unstyled inline filters">
					<li><a href="<?php echo $link_page; ?>"><?php _e('ΠΙΣΩ ΣΤΟ ΠΡΟΦΙΛ', 'ma-ellak');?></a></li>
				</ul>
			</div>
		</div>

		<?php
			$url = get_permalink(get_option_tree('ma_ellak_hire'));
			$url.="?profile_id=". $profile_id;
		?>
		<?php
			if ($posts){
				?>
				<div class="row-fluid event">
					<div class="cols">
					<?php
					echo"<h4>". __('Οι εργασίες στις οποίες έχει υποβάλλει αίτηση ο χρήστης είναι οι ακόλουθες: ', 'ma_ellak') ."</h4>";
					$no_jobs_available=0;
					foreach($posts as $post){
						setup_postdata($post);
					?>
						<div class="span12 text col">
							<?php
								$job_id=$post->ID;
								//Ο χρήστης που είναι αυτή τη στιγμή συνδεδεμένος και πάει να προσλάβει κάποιον πρέπει
								// να βλέπει μόνο όσες δουλειές έχει καταχωρήσει αυτός και για τις οποίες έχει εκδηλωθεί ενδιαφέρον
								$author_job = get_post($job_id);
								$owner_job = $author_job->post_author;
								if(in_array($job_id,$all_jobs_applied_for) && $owner_job==$author_id){
									$no_jobs_available++;
							?>
									<div class="control-group">
										<div class="controls">
											<label class="checkbox inline" for="checkbox"></label>
												<div id="api">
													<a href="<?php echo get_permalink($post->ID); ?>" rel="bookmark" title="<?php the_title();?>" class="btn btn-large btn-link"><?php the_title(); ?></a>
													<input type="checkbox" name="checkbox[]" value="<?php echo $job_id; ?>" rel="<?php echo $job_id; ?>"/>
												</div>
										</div>
									</div>
								<?php
								}
								?>
						</div>
					<?php
					}
					?>
					</div>
				</div>
				<?php
				//Δεν υπάρχουν εργασίες στις οποίες να έχει αιτηθεί ο χρήστης και να μην του έχουν ανατεθεί
				if ($no_jobs_available==0){
					_e('Δεν υπάρχουν εργασίες στις οποίες να έχετε υποβάλλει αίτηση και να μην σας έχουν προσλάβει', 'ma_ellak');
					echo"<p></p>";
				}
				else{
				?>
					<button id="add" name="add" class="btn btn-primary btn-block"><?php _e('Υποβολή', 'ma-ellak'); ?></button>
					<input type="hidden" id="user" name="user" value="<?php echo $user_applied;?>"/>
					<?php
					//Update the existing value
					$previous_jobs = get_user_meta($user_applied, '_ma_ellak_all_jobs_selected', true);
					?>
					<input type="hidden" name="previous_jobs" id="previous_jobs" value="<?php echo base64_encode(serialize($previous_jobs));?>"></input>
					<div id="test-div1"></div>
					<p></p>
				<?php
				}
				?>
			<?php
			}
			else{
				_e('Δεν υπάρχουν εργασίες στις οποίες να έχετε υποβάλλει αίτηση και να μην σας έχουν προσλάβει', 'ma_ellak');
				echo"<p></p>";
			}
	}
get_footer();
?>