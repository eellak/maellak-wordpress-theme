<?php
/*
Template Name: Job - Edit
*/
	
	
	if ( (!is_user_logged_in())) // Μόνο εγγεγραμμένοι χρήστες μπορούν να είναι εδώ. 
		header('Location: '.get_bloginfo('url').''); 
	get_header();
	
	
	$job_post;
	$job_id = 0;
	if(isset($_GET['jid']) and $_GET['jid'] !=''){
		$job_post = get_post(intval($_GET['jid']));
		if(!empty($job_post) and 'job' == $job_post->post_type) 
			$job_id =intval($_GET['jid']);
	}
	
	$success = false;
	$ma_message = '';
	
	$url = get_permalink(get_option_tree('ma_ellak_edit_job'));
	$url .="?jid=".$job_id;
	

?>
<?php 
if(!ma_ellak_user_can_edit_post($job_post)){
	_e('Δεν έχετε δικαίωμα Επεξεργασίας της Προσφοράς','ma-ellak');
}else if($job_id != 0){

	if(isset($_POST['ma_ellak_job_submit']) &&isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {
		
		$title = sanitize_text_field($_POST['ctitle']);
		$description = $_POST['cdescription']; 
		$author =  sanitize_text_field($_POST['cuser']); 
		$tag_list = implode(',', $_POST['tag-select']);
		$status =  sanitize_text_field($_POST['gstatus']);
		
		if(isset($_POST['selftags'])){
			$tag_list .= ','.sanitize_text_field($_POST['selftags']);
		}
		
		// Ορίζουμε τις κατηγορίες/ταξονομίες
		$tax = array(
			'post_tag' => $tag_list, 
			'jobtype' => $_POST['jobtype-select'],
			'package' => implode(',', $_POST['package-select']),
		);		
		
		$job = array(
			'ID' => $job_id,
			'post_title'	=> $title,
			'post_content'	=> $description,		
			'post_status'	=> $status, 	// publish, preview, future, etc.
			'post_type'		=> 'job', 	
			'tax_input'		=> $tax, 		
		);
		
		$job_id = wp_update_post($job);
		
		if($job_id){
			ma_ellak_job_save_details($job_id);
			
			$ma_message = '<p class="message">H επεξεργασία της Προσφοράς ήταν επιτυχής.</p>';
			$success = true;

		} else {
			$ma_message = '<p class="error">Παρουσιάστηκε πρόβλημα και η καταχώρηση δεν ήταν επιτυχής.</p>';
		}
	}
	
	$has_selected = get_post_meta( $job_id, '_ma_ellak_accepted_user');
	if(!empty($has_selected) and $has_selected !='')
		$has_seleced = true;
	else
		$has_seleced = false;

	//If you haven't chosen an applicant and the job status is publish send email
	if (!$has_seleced && $status=='publish'){
		if ($_POST['_ma_job_applicant_type']=='')
			$job_applicant_type='nomatter';
		else
			$job_applicant_type=$_POST['_ma_job_applicant_type'];

		if (!isset($_POST['jobtype-select']) || $_POST['jobtype-select']=='')
			$jobtype='';
		else
			$jobtype=$_POST['jobtype-select'];
			
		if (!isset($_POST['package-select']) || $_POST['package-select']=='')
			$package='';
		else
			$package=$_POST['package-select'];

		$emails=ma_ellak_send_email_users($jobtype, $package, $job_applicant_type);
		if ($emails){
			$email_message = 'Νέα καταχώρηση Προσφοράς Εργασίας με τίτλο: '.$title;
			wp_mail( $emails, 'Νέα καταχώρηση προσφοράς', $email_message);
		}
	}
	
	if(isset($_GET['accept']) and !$has_seleced){
		$user_id = intval($_GET['accept']);
		
		// Update the User to say he has been chosen ----------------------
		$jobs_selected = get_user_meta($user_id, '_ma_ellak_all_jobs_selected', true );    
		
		if(!empty($jobs_selected))
			$jobs_selected[] = $job_id ;
		else
			$jobs_selected = array($job_id);
			
		$go1 = update_user_meta( $user_id, '_ma_ellak_all_jobs_selected', $jobs_selected);
		
		// Update Job to Say User has been chosen ----------------------
		$go2 = update_post_meta( $job_id, '_ma_ellak_accepted_user',  $user_id );
		$go3 = update_post_meta( $job_id, $ma_prefix . 'job_status',  'processed' );
		
		if($go1 and $go2 and $go3){
			$mail_message = 'Συγχαρητήρια,\r\n\r\n';
			$mail_message .= 'επιλεχθήκατε ως Ανάδοχος για την Προσφορά Εργασίας '.get_the_title($job_id).' ('.get_permalink($job_id).').\r\n\r\n';
			$mail_message .= 'Ο υπεύθυνος θα επικοινωνήσει σύντομα μαζί σας ηλεκτρονικά. \r\n\r\n';
			$mail_message .= 'Διαχείριση Δικτυακής Πύλης Μονάδων Αριστείας ΕΛ/ΛΑΚ \r\n\r\n';
			$user = get_user_by('id', $user_id);   
			wp_mail( $user->user_email, 'Μονάδες Αριστείας ΕΛ/ΛΑΚ - Επιλεχθήκατε ως Ανάδοχος', $mail_message );
			//echo $user->user_email.' => '.$mail_message;
			$ma_message = '<p class="alert alert-info">Ο Ανάδοχος ορίστηκε! Παράλληλα ενημερώθηκε με email και αναμένει επικοινωνία απο μέρους σας.</p>';
		} else {
			$ma_message = '<p class="alert error-info">Παρουσιάστηκε σφάλμα!</p>';
		}
	}	
	
	if(isset($_GET['remove']) and $has_seleced){
		$user_id = intval($_GET['remove']);
		
		// Update the User to say he has been chosen ----------------------
		$jobs_selected = get_user_meta($user_id, '_ma_ellak_all_jobs_selected', true );    
		
		if (($key = array_search($job_id, $jobs_selected)) !== false) {
			unset($jobs_selected[$key]);
		}
			
		$go1 = update_user_meta( $user_id, '_ma_ellak_all_jobs_selected', $jobs_selected);
		
		// Update Job to Say User has been chosen ----------------------
		$go2 = delete_post_meta( $job_id, '_ma_ellak_accepted_user');
		$go3 = update_post_meta( $job_id, $ma_prefix . 'job_status',  'active' );
		
		if($go1 and $go2 and $go3){
			$ma_message = '<p class="alert alert-info">Ο Ανάδοχος αφαιρέθηκε!</p>';
		} else {
			$ma_message = '<p class="alert error-info">Παρουσιάστηκε σφάλμα!</p>';
		}
	}
	
	
	$job_post = get_post($job_id);
	global $ma_prefix;
	$gstatus = $job_post->post_status;
	$job_status = get_post_meta($job_id, $ma_prefix . 'job_status', true);
	$job_expiration = get_post_meta($job_id, $ma_prefix . 'job_expiration', true);
	$job_contact_point = get_post_meta($job_id, $ma_prefix . 'job_contact_point', true);
	$job_applicant = get_post_meta($job_id, $ma_prefix . 'job_applicant_type', true);
	$job_complete_comment = get_post_meta($job_id, $ma_prefix . 'job_complete_comment', true);
	$accepted_user_vote = get_post_meta($job_id,$ma_prefix.'accepted_user_vote', true);
	$job_success = get_post_meta($job_id,'_ma_job_success', true);
	$job_contact_point_name=get_post_meta($job_id,'_ma_job_contact_point_name', true);
	$job_contact_point_email=get_post_meta($job_id,'_ma_job_contact_point_email', true);
	$job_contact_point_foreas=get_post_meta($job_id,'_ma_job_contact_point_foreas', true);
	$job_contact_point_phone=get_post_meta($job_id,'_ma_job_contact_point_phone', true);
	
?>
<?php get_header(); 

?>	<?php if($gstatus == 'publish'){ ?>
	<div class="row-fluid filters">
		<div class="span6">
			<a href="<?php echo get_permalink($job_id) ?>" rel="bookmark" title="<?php echo get_the_title($job_id);?>" class="btn btn-large btn-link">
				<?php echo __('ΠΡΟΒΟΛΗ TΗΣ ΠΡΟΣΦΟΡΑΣ','ma-ellak');?>
			</a>
			</p>
		</div>
   	</div>  
	<?php } ?>
   	 <div class="row-fluid event">
		<?php /*---------------------- Form ------------------------------------------*/ ?>
		<div id="ma-message" class="span8 offset2"><?php echo($ma_message); ?> </div>
		<?php //if($success){ } else { ?>
		<div class="yamm-content events">
            <div class="row-fluid">
        
				<form action="<?php echo get_permalink(get_option_tree('ma_ellak_edit_job')); ?>?jid=<?php echo $job_id; ?>" method="post" id="ma_ellak_job_submit_form" enctype="multipart/form-data" class="form-horizontal span12">
					<fieldset class="form-vertical span8 offset2">
					<div class="control-group">
						<label class="control-label span12" for="ctitle"><?php _e('Τίτλος', 'ma-ellak'); ?> (*)</label>
						<div class="controls">
						<input type="text" name="ctitle" id="ctitle" class="form-control input-block-level required" value="<?php echo $job_post->post_title; ?>"  />
						</div>
					</div>
					
					<div class="control-group">
						<label for="cdescription"><?php _e('Πλήρης Περιγραφή της Εργασίας', 'ma-ellak'); ?> (*)</label>
						<?php 	
							echo"<br/>";
							wp_editor( $job_post->post_content, 'cdescription');
						?>
					</div>
					
					<div class="control-group">
						<div class="span6">
							<label class="control-label span12" style="text-align:left;" for="want"><?php _e('Θέλω', 'ma-ellak'); ?></label>
							<div class="controls">
								<select class="_ma_job_applicant_type" name="_ma_job_applicant_type">
									<option value=""><?php _e('Επιλέξτε', 'ma-ellak'); ?>  (*)</option>
									<option value="professional"<?php if($job_applicant == 'professional') echo ' selected="selected"'; ?>><?php _e('Επαγγελματία', 'ma-ellak'); ?></option>
									<option value="volunteer"<?php if($job_applicant == 'volunteer') echo ' selected="selected"'; ?>><?php _e('Εθελοντή', 'ma-ellak'); ?></option>
									<option value="nomatter"<?php if($job_applicant == 'nomatter') echo ' selected="selected"'; ?>><?php _e('Αδιάφορο', 'ma-ellak'); ?></option>
								</select>
							</div>
						</div>
						<div class="span6">
							<label class="control-label span12" style="text-align:left;" for="_ma_job_expiration"><?php _e('Ημερομηνία Λήξης', 'ma-ellak'); ?></label>
							<div class="controls">
							<input type="text" name="_ma_job_expiration" id="_ma_job_expiration" class="form-control input-block-level cmb_datepicker" value="<?php echo $job_expiration; ?>"  />
							</div>
						</div>
					</div>
					
				
					<div class="control-group">
						<div class="span6">
						<label class="control-label span12" style="text-align:left;" for="_ma_job_contact_point_name"><?php _e('Στοιχεία Υπευθύνου - Ονοματεπώνυμο', 'ma-ellak'); ?> (*)</label>
							<div class="controls">
							<input type="text" name="_ma_job_contact_point_name" id="_ma_job_contact_point_name" class="form-control input-block-level required" value="<?php  echo $job_contact_point_name;?>"  />
							</div>
						</div>
						<div class="span6">
						<label class="control-label span12" style="text-align:left;" for="_ma_job_contact_point_email"><?php _e('Στοιχεία Υπευθύνου - email', 'ma-ellak'); ?>(*)</label>
							<div class="controls">
							<input type="text" name="_ma_job_contact_point_email" id="_ma_job_contact_point_email" class="form-control input-block-level required" value="<?php echo $job_contact_point_email;?>"  />
							</div>
						</div>
					</div>
					<div class="control-group">
						<div class="span6">
						<label class="control-label span12" style="text-align:left;" for="_ma_job_contact_point_foreas"><?php _e('Στοιχεία Υπευθύνου - Φορέας', 'ma-ellak'); ?></label>
							<div class="controls">
							<input type="text" name="_ma_job_contact_point_foreas" 
							id="_ma_job_contact_point_foreas" class="form-control input-block-level" 
							value="<?php echo $job_contact_point_foreas; ?>"  />
							</div>
						</div>
						<div class="span6">
						<label class="control-label span12" style="text-align:left;" for="_ma_job_contact_point_phone"><?php _e('Στοιχεία Υπευθύνου - Τηλέφωνο', 'ma-ellak'); ?></label>
							<div class="controls">
							<input type="text" name="_ma_job_contact_point_phone" 
							id="_ma_job_contact_point_phone" class="form-control input-block-level" 
							value="<?php echo $job_contact_point_phone;?>"  />
							</div>
						</div>
					</div>
					<div class="control-group">
						<label for="type"><?php _e('Τύπος Εργασίας', 'ma-ellak'); ?></label>
						<?php 	
							$terms = array();
							foreach (wp_get_post_terms($job_id, 'jobtype')  as $term)
								$terms[]= $term->term_id;
							$jobtype = get_taxonomy('jobtype'); 
							echo ma_ellak_choose_one_term( $jobtype, 'jobtype-select', true, $terms); 
						?>
					</div>
					
					<div class="control-group">
						<label for="tags"><?php _e('Πακέτα Λογισμικού', 'ma-ellak'); ?></label>
						<?php 	
							$terms = array();
							foreach (wp_get_post_terms($job_id, 'package')  as $term)
								$terms[]= $term->term_id;
							$package = get_taxonomy('package'); 
							echo ma_ellak_add_term_chosebox( $package, 'package-select', true, $terms); 
						?>
					</div>
					
					<div class="control-group">
						<label for="tags"><?php _e('Ετικέτες', 'ma-ellak'); ?></label>
						<?php 
							$terms = array();
							foreach (wp_get_post_terms($job_id, 'post_tag')  as $term)
								$terms[]= $term->slug;
							$tagz = get_taxonomy('post_tag'); 
							echo ma_ellak_add_term_chosebox( $tagz, 'tag-select', false, $terms ); 
						?>
						<a href="#" id="addnewtags" style="font-size:90%; font-style:italics;"><?php _e('Προσθέστε δικές σας Ετικέτες αν δεν εντοπίστηκαν παραπάνω.', 'ma-ellak'); ?></a>
						<input type="text" name="selftags" style="display:none;" id="selftags" class="form-control input-block-level" value="<?php if(isset($_POST['selftags'])) echo $_POST['selftags'];?>" placeholder="<?php _e('Χωρίστε με κόμα (,) τις νέες ετικέτες', 'ma-ellak'); ?>" />
					</div>
					
					<div class="comment-editor">
						<div class="row-fluid">
							<div class="span12">
								<div id="comment_head_edit"> <?php _e('Ρυθμίσεις', 'ma-ellak');  ?> </div>
							</div>
						</div>
						<div class="row-fluid">
							<div class="span12">
								<div class="span6">
									<label class="control-label span12" style="text-align:left;" for="want"><?php _e('Κατάσταση', 'ma-ellak'); ?></label>
									<div class="controls">
										<select class="_ma_job_status" name="_ma_job_status" id="stage_status">
											<option value=""><?php _e('Επιλέξτε', 'ma-ellak'); ?></option>
											<option value="active"<?php if($job_status == 'active') echo ' selected="selected"'; ?>><?php _e('Ενεργή', 'ma-ellak'); ?></option>
											<option value="processed"<?php if($job_status == 'processed') echo ' selected="selected"'; ?>><?php _e('Σε εξέλιξη', 'ma-ellak'); ?></option>
											<option value="done"<?php if($job_status == 'done') echo ' selected="selected"'; ?>><?php _e('Ολοκληρωμένη', 'ma-ellak'); ?></option>
											<option value="inactive"<?php if($job_status == 'inactive') echo ' selected="selected"'; ?>><?php _e('Μη Ενεργή', 'ma-ellak'); ?></option>										
										</select>
									</div>
								</div>
							
							</div>
						</div>
						<div class="row-fluid">
							<div class="span12" id="acceptance">
								<div class="row-fluid">
									<div class="control-group span6">
										<div class="controls">
											<label for="_ma_accepted_user_vote"><?php _e('Αξιολογήστε τον Επαγγελματία/Εθελοντή.', 'ma-ellak'); ?></label>
											<div class="controls">
												<select class="_ma_accepted_user_vote" name="_ma_accepted_user_vote" id="_ma_accepted_user_vote">
													<option value=""><?php _e('Επιλέξτε', 'ma-ellak'); ?></option>
													<option value="0"<?php if($accepted_user_vote == '0') echo ' selected="selected"'; ?>>0</option>
													<option value="1"<?php if($accepted_user_vote == '1') echo ' selected="selected"'; ?>>1</option>
													<option value="2"<?php if($accepted_user_vote == '2') echo ' selected="selected"'; ?>>2</option>
													<option value="3"<?php if($accepted_user_vote == '3') echo ' selected="selected"'; ?>>3</option>
													<option value="4"<?php if($accepted_user_vote == '4') echo ' selected="selected"'; ?>>4</option>	
													<option value="4"<?php if($accepted_user_vote == '5') echo ' selected="selected"'; ?>>5</option>									
												</select>
											</div>
										</div>
									</div>
									<div class="control-group span6">
										<div class="controls">
											<label for="_ma_job_success"><?php _e('Επιτυχής Ολοκλήρωση ;', 'ma-ellak'); ?></label>
											<div class="controls">
												<select class="_ma_job_success" name="_ma_job_success" id="_ma_job_success">
													<option value=""><?php _e('Επιλέξτε', 'ma-ellak'); ?></option>
													<option value="yes"<?php if($job_success == 'yes') echo ' selected="selected"'; ?>><?php _e('Ναι', 'ma-ellak'); ?></option>
													<option value="no"<?php if($job_success == 'no') echo ' selected="selected"'; ?>><?php _e('Όχι', 'ma-ellak'); ?></option>								
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="control-group">
									<div class="controls">
										<label for="_ma_job_complete_comment"><?php _e('Σύντομη περιγραφή ως προς την Ολοκλήρωση της Εργασίας.', 'ma-ellak'); ?></label>
										<?php 
											$settings = array( 'media_buttons' => false, 'textarea_rows'=>5 );
											wp_editor( $job_complete_comment , '_ma_job_complete_comment', $settings );
										?>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<?php 
						$current = get_post_meta($job_id, '_ma_ellak_interested_users', true );
						$accepted = get_post_meta($job_id, '_ma_ellak_accepted_user', true );
						$list = '';
						if(!empty($current))
							foreach($current as $user_id) { 
								$args = array(
									'post_per_page' => 1,
									'post_type' => 'profile',
									'post_status' => 'publish', 
									'author' => $user_id
								); 
								$profiles = get_posts($args);
								foreach($profiles as $user){
									$list .= '<li><div class="applicant"><a href="'.get_permalink($user->ID).'" class="pull-left" target="_blank">'.$user->post_title . '</a>';
									if(!empty($accepted) or($accepted != '')){
										if($accepted == $user_id){
											$list .= '<span class="btn btn-tiny approve-comment pull-right" >'.__('Επιλεγμένος', 'ma-ellak').'</span>';
											$list .= '<a class="btn btn-tiny action-comment discard-comment pull-right" href="'.$url.'&remove='.$user_id.'#comment_list_admin" >'.__('Αφαίρεση', 'ma-ellak').'</a>';
										}
									} else {
										$list .= '<a class="btn btn-tiny action-comment approve-comment pull-right" href="'.$url.'&accept='.$user_id.'#comment_list_admin" >'.__('Αποδοχή', 'ma-ellak').'</a>';
									}
									$list .= '</div></li>';
								} 
							}  ?>
					<div class="comment-editor">
						<div class="row-fluid">
							<div class="span12">
								<div id="comment_head_edit"> <?php _e('Εκδηλώσεις Ενδιαφέροντος', 'ma-ellak'); ?> <span><?php echo count($current); ?></span> </div>
							</div>
						</div>
						<div class="row-fluid">
							<div class="span12">
								<?php 
									$current = get_post_meta($job_id, '_ma_ellak_interested_users', true );
									//$class_comm = 'hideme' ; if(isset($_GET['accept'])) $class_comm = 'openme'; ?>
								<ul id="comment_list_admin">
						<?php	if($list != '') echo $list;
								  ?>
								</ul>
							</div>
						</div>
					</div>
					
			<?php	if(ma_ellak_user_is_post_admin($job_post )){ ?>
					<div class="admineditor back-gray">
						<div class="row-fluid">
						<div class="span4">
							<div class="control-group">
								<label class="control-label span12" for="gstatus"><?php _e('Κατάσταση', 'ma-ellak'); ?></label>
								<div class="controls">
									<select class="gstatus" name="gstatus">
										<option value=""><?php _e('Επιλέξτε', 'ma-ellak'); ?></option>
										<option value="draft" <?php if($gstatus == 'draft') echo 'selected="selected"'; ?>><?php _e('Προσχέδιο', 'ma-ellak'); ?></option>
										<option value="publish" <?php if($gstatus == 'publish') echo 'selected="selected"'; ?>><?php _e('Δημοσιευμένο', 'ma-ellak'); ?></option>
									</select>
								</div>
							</div>
						</div>
						</div>
					</div>
			<?php	} ?>
					<div class="control-group">
						<label class="control-label span12" for="ma_ellak_job_submit"></label>
						<div class="controls">
							<button type="submit" id="ma_ellak_job_submit" name="ma_ellak_job_submit" class="btn btn-primary btn-block"><?php _e('ΕΠΕΞΕΡΓΑΣΙΑ ΠΡΟΣΦΟΡΑΣ', 'ma-ellak');?></button>
						</div>
					</div>
					<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
					</fieldset>
				</form>
			</div>
		<?php //} /*---------------------- End Form ------------------------------------------*/ ?>
		</div>
	</div>	
<?php } else {   _e('Πρέπει να επιλέξετε Προσφορά πρώτα!','ma-ellak');  }

 get_footer(); ?>