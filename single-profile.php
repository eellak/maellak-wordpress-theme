<?php
/**
* Αρχείο Προβολής Στοιχείων profile
*
* @licence GPL
* 
* Project URL http://ma.ellak.gr
*/
	get_header();
?>
	<div class="row-fluid filters">
		<div class="span12">
			<p><a href="<?php echo get_permalink(get_option_tree('ma_ellak_list_profiles'))?>">ΠΙΣΩ ΣΤΗ ΛΙΣΤΑ</a></p>
		</div>
	</div>
	
	<?php
		if (have_posts()) : while (have_posts()) : the_post();
			$post_id=get_the_ID();
			$meta = get_post_custom($post_id);
			$post_data=get_post($post_id);
			$name=$post_data->post_title;
			$bio=$post_data->post_content;

			$logo=$meta['_ma_profile_logo'][0];
			$property=$meta['_ma_profile_property'][0];
			$experience=$meta['_ma_ellak_profile_experience'][0];
			

			$scomment_list = '';
			
			
			$args = array(
					'status' => 'approve',
					'post_id' =>  $post->ID , // use post_id, not post_ID
			);
				
			$scomments = get_comments($args);
			if ( count($scomments ) > 0 ) {
				foreach ($scomments as $comment) {
					$comment_content = '<li id="comment-'.$comment->comment_ID.'">';
					
					//get_avatar( $comment, 32 );
					$comment_content .= '<div class="comment_content">' . $comment->comment_content.'</div>';
					
					if(!empty($comment->comment_author))
						$comment_content .= '<div class="comment_author"><a href="'.$comment->comment_author_url.'">'.$comment->comment_author.'</a> @ ';
					else {
						$user = get_user_by('ID', $comment->user_id);
						$member_id = bp_core_get_userid( $user->user_login );
						$comment_content .= '<div class="comment_author"><a href="'.bp_core_get_user_domain( $member_id ).'">'.bp_core_get_user_displayname( $member_id ).'</a> @ ';
					}
					
					$comment_content .= mysql2date('j M Y',$comment->comment_date);
					$comment_content .= '</div></li>';
					$scomment_list .= $comment_content;
				}
			}
			
	?>
	<div class="row-fluid event">
		<div class="cols">
			<div class="span3 col">
				<div class="boxed-in text-center the-date">
				<?php
					if ($logo!=''){
						$thumbnail=get_profile_logo($logo);
						echo "<img src=\"". $thumbnail ."\" alt=\"profile\" title=\"profile\">";
					}
					else
						echo"<img src=\"". get_template_directory_uri() ."/images/profile.jpg\" alt=\"profile\" width=\"150\" height=\"150\"/>";
				?>
				</div>
				<p class="meta purple" style="padding:10px;"></p>
					<?php
					if ($property!='')
						echo"<h3>". $property ."</h3>";
				
					echo"<div id='profil'><p class='social'>";
					if ($meta['_ma_profile_facebook'][0]!='')
						print_social_image('facebook', $meta['_ma_profile_facebook'][0]);
					if ($meta['_ma_profile_twitter'][0]!='')
						print_social_image('twitter', $meta['_ma_profile_twitter'][0]);
					if ($meta['_ma_profile_linkedin'][0]!='')
						print_social_image('linkedin', $meta['_ma_profile_linkedin'][0]);
					if ($meta['_ma_profile_email'][0]!='')
						print_social_image('email', $meta['_ma_profile_email'][0]);
					?>
				    </div>
				<?php 
					$views = ma_ellak_show_statistics($post_id, 'profile');
					if (!isset($views))
						$views=0;
				?>
				<br/>
				
				<?php the_ratings();?>
				<div class="profil-views">
				<span class="magenta"><i class="icon-eye-open"></i> <?php echo $views; ?> </span>
				</div>
			</div><!-- span3 col -->
		 	<div class="span9 text  ">
				<h3><?php echo get_the_title(); ?> <?php ma_ellak_single_edit_permalink();?></h3>
				<p><?php echo $bio; ?></p>
				<p>&nbsp;</p>
				<p>
					<?php
					the_tags('<span class="profil-tags">','</span><span class="profil-tags">','</span>&nbsp;<br/><br/>'); 					
		
					?>
				</p>
				<?php
				$hire_url = get_permalink(get_option_tree('ma_ellak_hire'));
				$hire_url.="?profile_id=". $post_id;
				?>
				<p><a class="btn btn-medium btn-primary" href="<?php echo $hire_url; ?>"><?php _e('HIRE ME!', 'ma_ellak'); ?></a></p>
			</div><!-- span8 text col -->
		</div><!-- cols -->
	</div><!-- row-fluid event -->
	</div>  
	
	<!-- TABS  -->
	 <div class="back-purple">
        <div class="container">
          <div class="row-fluid">
            <ul class="nav nav-tabs span12">
					<?php 
					if (isset($_GET['comment']) && $_GET['comment']=='comment')
						echo"<li>";
					else
						echo "<li class=\"active\">";
					?>
						<a href="#tab-0" data-toggle="tab"><?php echo  __('ΕΜΠΕΙΡΙΑ','ma-ellak');?></a>
					</li>
					<li>
						<a href="#tab-1" data-toggle="tab"><?php echo  __('ΕΡΓΑΣΙΕΣ','ma-ellak');?></a>
					</li>					
					<li><a href="#tab-2"><?php echo __('ΥΠΗΡΕΣΙΕΣ','ma-ellak')?></a></li>
					<li <?php if(isset($_GET['comment'])) echo ' class="active"';?>><a href="#tab-3" ><?php echo __('ΣΧΟΛΙΑ','ma-ellak')?></a></li>
							
            </ul>
          </div>
        </div>
      </div>
<!--  end of basic tabs -->      
      
<!--  start tabs content -->
      <div class="back-gray" id="buddypress">
        <div class="container">
          <div class="row-fluid">
            <div class="tab-content span12">
            
            <!-- tab0 -->
             <div id="tab-0" class="tab-pane<?php if(!isset($_GET['comment'])) echo ' active'; ?>">
				<div class="row-fluid">
					<div class="span8">
					<?php
					if($experience!='')
						echo ma_ellak_get_profile_experience($post_id);
					else
						_e('Δεν έχει καταχωρηθεί προϋπηρεσία.', 'ma_ellak');
					?>
					</div>
				</div>
              </div>
            <!-- tab0 -->
            <!-- tab1 -->
             <div id="tab-1" class="tab-pane">
				<div class="row-fluid">
					<div class="span8">
					<?php
						$cur_user = wp_get_current_user();
						$user_id = $cur_user->ID;
						$all_jobs_applied = get_user_meta($user_id, '_ma_ellak_all_jobs_applied', true );
						if ($all_jobs_applied!=''){
							foreach ($all_jobs_applied as $job){
								$job_id=$job;
								$title=get_the_title($job_id);
								$job_meta=get_post_custom($job_id);
								$status=$job_meta['_ma_job_status'][0];
								if ($status=='active')
									$st='Ενεργή';
								else if ($status=='processed')
									$st='Σε εξέλιξη';
								else if ($status=='done')
									$st='Ολοκληρωμένη';
								echo __($title, 'ma_ellak') ." <strong class=\"magenta\">". $st ."</strong><br>";
								
							}
						}else echo __('Δεν έχει καταχωρήσει Εργασίες','ma-ellak');
				?>					
				</div>
				</div>
              </div>
            <!-- tab1 -->
            <!-- tab2 -->
            <div id="tab-2" class="tab-pane">
				<div class="row-fluid">
					<div class="span8">
							<?php
								$jobs=wp_get_post_terms($post_id, 'jobtype');
								if (count($jobs)>0){
									echo "<span class='magenta'>".__("Αντικείμενο παρεχόμενης υπηρεσίας: ", "ma_ellak")."</span>";
									echo"<strong class=\"magenta\">";
									foreach ($jobs  as $job)
										echo " ". $job->name;
									echo"</strong>";
									echo"<BR>";
								}
								
								$packages=wp_get_post_terms($post_id, 'package');
								if (count($packages)>0){
									echo "<span class='magenta'>". __("Πακέτα λογισμικού: ", "ma_ellak")."</span>";
									echo"<strong class=\"magenta\">";
									foreach ($packages  as $package)
										echo " ". $package->name;
									echo"</strong>";
									echo"<BR>";
								}

								$types=wp_get_post_terms($post_id, 'type');
								if (count($types)>0){
									echo "<span class='magenta'>". __("Κατηγορία λογισμικού: ", "ma_ellak")."</span>";
									echo"<strong class=\"magenta\">";
									foreach ($types  as $type)
										echo " ". $type->name;
									echo"</strong>";
									echo"<BR>";
								}

								if ($meta['_ma_profile_type'][0]!=''){
									echo "<span class='magenta'>".__("Είδος παρεχόμενης υπηρεσίας: ", "ma_ellak")."</span>";
									echo"<strong class=\"magenta\">";
									echo " ". $meta['_ma_profile_type'][0];
									echo"</strong><BR>";
								}

								$hourly_rate=$meta['_ma_hourly_rate'][0];
								if($hourly_rate!=''){
									echo "<span class='magenta'>".__('Χρέωση ανά ώρα:', 'ma_ellak')."</span>";
									echo"<strong class=\"magenta\">";
									echo " ". $hourly_rate ."&euro;";
									echo"</strong><BR>";
								}

								$service_desc=$meta['_ma_service_desc'][0];
								if($service_desc!='')
									echo "<BR>". $service_desc;
								if (count($jobs)==0 && count($packages)==0 && count($types)==0 && !isset($meta['_ma_profile_type'][0]) && $hourly_rate=='' && $service_desc==''){
									_e('Δεν έχουν καταχωρηθεί πληροφορίες για τις παρεχόμενες υπηρεσίες.', 'ma_ellak');
								}
							?>
						</div>
					</div>
				</div>
            <!-- tab2-->
            <!-- tab3 -->
             <div id="tab-3" class="tab-pane<?php if(isset($_GET['comment']) and $_GET['comment']=='comment') echo ' active'; ?>">
				<div class="row-fluid">
					<div class="span4">
						<?php if ( comments_open() ) : ?>
							<h3 id="postcomment"><?php _e('Leave a comment'); ?></h3>
							<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
								<p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.'), get_option('siteurl')."/wp-login.php?redirect_to=".urlencode(get_permalink()));?></p>
							<?php else : ?>
							
								<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
								<?php if ( $user_ID ) : ?>
									<p><?php printf(__('Συνδεδεμένος ως %s.'), '<a href="'.get_option('siteurl').'/wp-admin/profile.php">'.$user_identity.'</a>'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Αποσύνδεση από το λογαριασμό') ?>"><?php _e('Αποσύνδεση &raquo;'); ?></a></p>
								<?php else : ?>
									<div class="row-fluid">
										<p class="span6">
											<input class="span12 required" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" type="text">
											<label for="author"><small><?php _e('Όνομα'); ?> <?php if ($req) _e('(υποχρεωτικό)'); ?></small></label>
										</p>
										<p class="span6">
											  <input class="span12 required" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" type="text">
											  <label for="email"><small><?php _e('Mail (δεν θα δημοσιευτεί)');?> <?php if ($req) _e('(υποχρεωτικό)'); ?></small></label>
										 </p>
									</div>
								<?php endif; ?>
									<p><textarea name="comment" placeholder="Η άποψή σας (*)" class="span12" id="comment"  rows="10" tabindex="4"></textarea></p>
									<div class="actions"><div class="span5 offset4"><input class="btn btn-primary btn-block required" name="submit" id="submit" tabindex="5" value="<?php echo attribute_escape(__('Submit Comment')); ?>" type="submit"></div></div>
									<p></p>
									<p><input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" /></p>
									<input type="hidden" name="redirect_to" value="<?php echo get_permalink(); ?>/?comment=comment#buddypress" />
									<?php do_action('comment_form', $post->ID); ?>
								</form>
							<?php endif; ?>
						<?php endif; ?>
					</div>
					<div class="span8">
						<?php if(isset($_GET['comment']) and $_GET['comment']=='comment'){ ?>
							<div class="alert alert-info"><p><?php _e('Το Σχόλιό σας υποβλήθηκε επιτυχώς. Στην περίπτωση που δεν εμφανίζεται στην ακόλουθή λίστα θα δημοσιευθεί μόλις εγκριθεί απο τον Διαχειριστή.', 'ma-ellak') ?></p></div>
						<?php } ?>
						<?php if ( $scomment_list  != '' ) { echo	'<ul id="scommentlist">'.$scomment_list.'</ul>'; } ?>
					</div>
				</div>
              </div>
			  
            <!-- tab3 -->
            </div><!-- tab-content span12 -->
		</div><!-- row-fluid -->
	</div><!-- container  -->
	<!-- back-gray -->
<!--  end tabs content -->
	
	
	<?php
  endwhile; else: ?>
		<p>Sorry, no posts matched your criteria.</p>

<?php
  endif;
  echo social_output();
  
  get_footer();
  
function print_social_image($type, $url){
	if ($type=='email')
		echo "<a href=\"mailto:$url\"><img src=\"". get_template_directory_uri() ."/images/".$type.".jpg\" alt=\"". $email ."\" width=\"20\" height=\"20\"/></a>";
	else{
		
		if($type=='facebook'){
			if(!strstr('facebook',$url))
				$url = 'http://www.facebook.com/'.$url;
		}
		if($type=='twitter'){
			if(!strstr('twitter',$url))
				$url = 'http://www.twitter.com/'.$url;
		}
		if($type=='linkedin'){
			if(!strstr('linkedin',$url))
				$url = 'http://www.linkedin.com/profile/view/?'.urlencode("id=".$url);
		}
	
		echo "<a href=". $url ." target='_blank'><img src=\"". get_template_directory_uri() ."/images/". $type.".jpg\" alt=\"". $type ."\" title=\"". $type ."\" width=\"20\" height=\"20\"/></a>";
	}
}
  
?>