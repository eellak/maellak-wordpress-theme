<?php
/*
Template Name: Job - Add
*/
	$anon = ot_get_option('ma_ellak_anonymous_job'); 
	
	if ( (!is_user_logged_in()) and ('yes' != $anon[0])) // Μόνο εγγεγραμμένοι χρήστες μπορούν να είναι εδώ. 
		header('Location: '.get_bloginfo('url').''); 
	
	$user_id = 0;
	
	if('yes' == $anon[0] and !is_user_logged_in()){
		$user = ot_get_option('ma_ellak_anonymous_user');
		$user_data = get_user_by('email', $user );
		$user_id = $user_data->ID;
	} else{
		$cur_user = wp_get_current_user();
		$user_id = $cur_user->ID;
	}
	$success = false;
	$ma_message = '';
	global $ma_prefix ;
	
	if(isset($_POST['ma_ellak_job_submit']) &&isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {
		
		$title = sanitize_text_field($_POST['ctitle']);
		$description = $_POST['cdescription']; 
		$author =  sanitize_text_field($_POST['cuser']); 
		$tag_list = implode(',', $_POST['tag-select']);
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
			'post_title'	=> $title,
			'post_content'	=> $description,		
			'post_status'	=> 'draft', 	// publish, preview, future, etc.
			'post_type'		=> 'job', 	
			'tax_input'		=> $tax, 		
			'post_author'	=> $author 
		);
		
		$job_id = wp_insert_post($job);
		
		if($job_id){
			ma_ellak_job_save_details($job_id);
			// Την ορίζουμε και ως Ενεργή
			update_post_meta( $job_id, $ma_prefix . 'job_status',  'active' );
			
			$ma_message = '<p class="message">H καταχώρησή της Προσφοράς ήταν επιτυχής. Θα δημοσιευθεί μόλις εγκριθεί απο τον Διαχειριστή.</p>';
			$success = true;

		} else {
			$ma_message = '<p class="error">Παρουσιάστηκε πρόβλημα και η καταχώρηση δεν ήταν επιτυχής.</p>';
		}
	} 
	
?>
<?php get_header(); 

?>
	
   	 <div class="row-fluid event">
		<?php /*---------------------- Form ------------------------------------------*/ ?>
		<div id="ma-message"><?php echo($ma_message); ?> </div>
		<?php if($success){ } else { ?>
		<div class="yamm-content events">
            <div class="row-fluid">
        
				<form action="<?php echo get_permalink(get_option_tree('ma_ellak_submit_job')); ?>" method="post" id="ma_ellak_job_submit_form" enctype="multipart/form-data" class="form-horizontal span12">
					<fieldset class="form-vertical span8 offset2">
					<div class="control-group">
						<label class="control-label span12" for="ctitle"><?php _e('Τίτλος', 'ma-ellak'); ?> (*)</label>
						<div class="controls">
						<input type="text" name="ctitle" id="ctitle" class="form-control input-block-level required" value="<?php if(isset($_POST['ctitle'])) echo $_POST['ctitle'];?>"  />
						</div>
					</div>
					
					<div class="control-group">
						<label for="cdescription"><?php _e('Πλήρης Περιγραφή της Εργασίας', 'ma-ellak'); ?> (*)</label>
						<?php 	
							echo"<br/>";
							if(isset($_POST['cdescription'])) $content = $_POST['cdescription'];	
							wp_editor( $content, 'cdescription');
						?>
					</div>
					
					<div class="control-group">
						<div class="span6">
							<label class="control-label span12" style="text-align:left;" for="want"><?php _e('Θέλω', 'ma-ellak'); ?> (*)</label>
							<div class="controls">
								<select class="_ma_job_applicant_type" name="_ma_job_applicant_type">
									<option value=""><?php _e('Επιλέξτε', 'ma-ellak'); ?></option>
									<option value="professional"><?php _e('Επαγγελματία', 'ma-ellak'); ?></option>
									<option value="volunteer"><?php _e('Εθελοντή', 'ma-ellak'); ?></option>
									<option value="nomatter"><?php _e('Αδιάφορο', 'ma-ellak'); ?></option>
								</select>
							</div>
						</div>
						<div class="span6">
							<label class="control-label span12" style="text-align:left;" for="_ma_job_expiration"><?php _e('Ημερομηνία Λήξης', 'ma-ellak'); ?></label>
							<div class="controls">
							<input type="text" name="_ma_job_expiration" id="_ma_job_expiration" class="form-control input-block-level cmb_datepicker" value="<?php if(isset($_POST['_ma_job_expiration'])) echo $_POST['_ma_job_expiration'];?>"  />
							</div>
						</div>
					</div>
					
					<div class="control-group">
						<div class="span6">
						<label class="control-label span12" style="text-align:left;" for="_ma_job_contact_point_name"><?php _e('Στοιχεία Υπευθύνου - Ονοματεπώνυμο', 'ma-ellak'); ?> (*)</label>
							<div class="controls">
							<input type="text" name="_ma_job_contact_point_name" id="_ma_job_contact_point_name" class="form-control input-block-level required" value="<?php if(isset($_POST['_ma_job_contact_point_name'])) echo $_POST['_ma_job_contact_point_name'];?>"  />
							</div>
						</div>
						<div class="span6">
						<label class="control-label span12" style="text-align:left;" for="_ma_job_contact_point_email"><?php _e('Στοιχεία Υπευθύνου - email', 'ma-ellak'); ?>(*)</label>
							<div class="controls">
							<input type="text" name="_ma_job_contact_point_email" id="_ma_job_contact_point_email" class="form-control input-block-level required" value="<?php if(isset($_POST['_ma_job_contact_point_email'])) echo $_POST['_ma_job_contact_point_email'];?>"  />
							</div>
						</div>
					</div>
					<div class="control-group">
						<div class="span6">
						<label class="control-label span12" style="text-align:left;" for="_ma_job_contact_point_foreas"><?php _e('Στοιχεία Υπευθύνου - Φορέας', 'ma-ellak'); ?></label>
							<div class="controls">
							<input type="text" name="_ma_job_contact_point_foreas" id="_ma_job_contact_point_foreas" class="form-control input-block-level" value="<?php if(isset($_POST['_ma_job_contact_point_foreas'])) echo $_POST['_ma_job_contact_point_foreas'];?>"  />
							</div>
						</div>
						<div class="span6">
						<label class="control-label span12" style="text-align:left;" for="_ma_job_contact_point_phone"><?php _e('Στοιχεία Υπευθύνου - Τηλέφωνο', 'ma-ellak'); ?></label>
							<div class="controls">
							<input type="text" name="_ma_job_contact_point_phone" id="_ma_job_contact_point_phone" class="form-control input-block-level" value="<?php if(isset($_POST['_ma_job_contact_point_phone'])) echo $_POST['_ma_job_contact_point_phone'];?>"  />
							</div>
						</div>
					</div>
					
					<div class="control-group">
						<label for="type"><?php _e('Τύπος Εργασίας', 'ma-ellak'); ?></label>
						<?php 	
							$jobtype = get_taxonomy('jobtype'); 
							echo ma_ellak_choose_one_term( $jobtype, 'jobtype-select', true); 
						?>
					</div>
					
					<div class="control-group">
						<label for="tags"><?php _e('Πακέτα Λογισμικού', 'ma-ellak'); ?></label>
						<?php 
							$package = get_taxonomy('package'); 
							echo ma_ellak_add_term_chosebox( $package, 'package-select', true);
						?>
					</div>
					
					<div class="control-group">
						<label for="tags"><?php _e('Ετικέτες', 'ma-ellak'); ?></label>
						<?php 
							$tagz = get_taxonomy('post_tag'); 
							echo ma_ellak_add_term_chosebox( $tagz, 'tag-select', false ); 
						?>
						<a href="#" id="addnewtags" style="font-size:90%; font-style:italics;"><?php _e('Προσθέστε δικές σας Ετικέτες αν δεν εντοπίστηκαν παραπάνω.', 'ma-ellak'); ?></a>
						<input type="text" name="selftags" style="display:none;" id="selftags" class="form-control input-block-level" value="<?php if(isset($_POST['selftags'])) echo $_POST['selftags'];?>" placeholder="<?php _e('Χωρίστε με κόμα (,) τις νέες ετικέτες', 'ma-ellak'); ?>" />
					</div>

					<input type="hidden" id="cuser" name="cuser" value="<?php echo $user_id ; ?>" />
					<div class="control-group">
						<label class="control-label span12" for="ma_ellak_job_submit"></label>
						<div class="controls">
							<button type="submit" id="ma_ellak_job_submit" name="ma_ellak_job_submit" class="btn btn-primary btn-block"><?php _e('ΥΠΟΒΟΛΗ ΠΡΟΣΦΟΡΑΣ', 'ma-ellak');?></button>
						</div>
					</div>
					<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
					</fieldset>
				</form>
			</div>
		<?php } /*---------------------- End Form ------------------------------------------*/ ?>
		</div>
	</div>	
<?php get_footer(); ?>