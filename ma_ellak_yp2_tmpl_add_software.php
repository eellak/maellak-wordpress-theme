<?php
/*
Template Name: Software - Add
*/

	 if (! is_user_logged_in()) // Μόνο εγγεγραμμένοι χρήστες μπορούν να είναι εδώ.
		header('Location: '.URL.''); 
	
	$cur_user = wp_get_current_user();
	
	$success = false;
	$ma_message = '';

	if(isset($_POST['ma_ellak_software_submit']) &&isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {
		
		$title = sanitize_text_field($_POST['ctitle']);
		$description = $_POST['cdescription']; 
		$author =  sanitize_text_field($_POST['user']);
		$tag_list = implode(',', $_POST['tag-select']);
		if(isset($_POST['selftags'])){
			$tag_list .= ','.sanitize_text_field($_POST['selftags']);
		}
		// Ορίζουμε τις κατηγορίες/ταξονομίες
		$tax = array(
			'post_tag' => $tag_list, 
			'thema' => implode(',', $_POST['thema-select']),
			'type' => $_POST['type-select'],
			'licence' => $_POST['licence-select'],
			'nace' => implode(',', $_POST['nace-select']),
			'frascati' => implode(',', $_POST['frascati-select']),
			'package' => implode(',', $_POST['package-select']),
		);
	
		$software = array(
			'post_title'	=> $title,
			'post_content'	=> $description,
			'tax_input'		=> $tax, 		
			'post_status'	=> 'draft', 	// publish, preview, future, etc.
			'post_type'		=> 'software', 	
			'post_author'	=> $author 
		);
		
		// Καταχωρούμε το Λογισμικό
		$software_id = wp_insert_post($software);
		
		if($software_id){
		
			$unit_id =  ma_ellak_get_unit_id();
			if( $unit_id != 0)
				update_post_meta( $software_id, '_ma_ellak_belongs_to_unit',$unit_id );
			
			ma_ellak_software_save_details($software_id);
			
			global $ma_prefix ;
			if ($_FILES) {
				foreach ($_FILES as $file => $array) {
					if(!empty($file))
						insert_attachment($file, $software_id, $ma_prefix . 'software_logo');
				}
			};
			
			if(isset($_POST['othertitle']) and isset($_POST['otherdescription']) and $_POST['othertitle']!=''){
				
				$time = current_time('mysql');
				$member_id = bp_core_get_userid( $cur_user->ID );
				$data = array(
					'comment_post_ID' => $software_id,
					'comment_author' => bp_core_get_user_displayname( $member_id ) ,
					'comment_author_email' => $cur_user->user_email,
					'comment_author_url' => bp_core_get_user_domain( $member_id ) ,
					'comment_content' => $_POST['otherdescription'],
					'comment_type' => '',
					'comment_parent' => 0,
					'user_id' => $cur_user->ID,
					'comment_date' => $time,
					'comment_approved' => 1,
				);
				$cid = 0;
				$cid = wp_insert_comment($data);
				if($cid != 0 && isset($_POST['othertitle']) && $_POST['othertitle']!=''){
					add_comment_meta( $cid, 'type', 'alternative');
					add_comment_meta( $cid, 'title', sanitize_text_field($_POST['othertitle'])	);
				}

			}
			
			$ma_message = '<p class="message">H καταχώρησή Λογισμικού ήταν επιτυχής.</p>';
			// Αποστολή email στον διαχειριστή/υπεύθυνο
			$email_message = 'Νέα καταχώριση Λογισμικού με τίτλο: '.$title;
			$unit_id =  ma_ellak_get_unit_id();
				
			if( $unit_id != 0)
				update_post_meta( $event_id, '_ma_ellak_belongs_to_unit',$unit_id );
				
			// Ενημέρωσε τους Διαχειριστές της ΜΑ -----------------------------------
			$unit_id = get_post_meta($event_id, '_ma_ellak_belongs_to_unit', true);
			if($unit_id != 0 ){
				$mail_message = 'Καταχωρήθηκε Νέο Λογισμικό,\r\n\r\n';
				$mail_message .= 'Αφορά το λογισμικό '.get_the_title($event_id).' ( '.get_permalink($event_id).' ).\r\n\r\n';
				$mail_message .= 'Επεξεργαστείτε το λογισμικό '.get_permalink(get_option_tree('ma_ellak_edit_software'))."?id=".$software_id.' \r\n\r\n';
				$mail_message .= 'Διαχείριση Δικτυακής Πύλης Μονάδων Αριστείας ΕΛ/ΛΑΚ \r\n\r\n';
				$admin_users = get_users(array('meta_key' => '_ma_ellak_admin_unit', 'meta_value' =>$unit_id ));
				foreach ($admin_users as $user) {
					wp_mail( $user->user_email, 'Μονάδες Αριστείας ΕΛ/ΛΑΚ - Καταχώριση Νέου Λογισμικού', $mail_message );
				}
			}
			$success = true;
		} else {
			$ma_message = '<p class="error">Παρουσιάστηκε πρόβλημα και η καταχώρησή Δεν ήταν επιτυχής.</p>';
		}
	} 
?>
<?php get_header(); ?>
	
   	<div class="row-fluid event">
		<div class="cols">
			<div class="span12">
				  
			</div>
		</div>
	</div>
	
   	 <div class="row-fluid event">
		<?php /*---------------------- Form ------------------------------------------*/ ?>
		<div id="ma-message"><?php echo($ma_message); ?> </div>
		<?php if($success){ } else { 
			$url = get_permalink(get_option_tree('ma_ellak_submit_software'));
		?>
		
		<div class="yamm-content events">
            <div class="row-fluid">
			
				<div class="form-vertical span8 offset2 fetcher">
					<a id="datafetcherviewer" href="#"><?php _e('Επιλέξτε εδώ για καταχώριση μέσω δημόσιο αποθετηρίου (sourceforge, github) ή συμπληρώστε τα στοιχεία παρακάτω', 'ma-ellak'); ?></a>
					<div id="datafetcher">
						<div class="datapack">
							<input type="radio" name="source" value="sourceforge" checked><?php _e('Sourceforge', 'ma-ellak'); ?> &nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" name="source" value="github"><?php _e('GitHub', 'ma-ellak'); ?>
							<input type="text" name="remote_url" id="remote_url" />
							<a href="#" id="fetch_remote_data"><?php _e('Λήψη', 'ma-ellak'); ?></a><br />
							
								<div id="help_message" style="width:80%"></div>
								<div id="fetch_message"></div>
							
						</div><!-- datapack -->
					</div><!-- datafetcher -->
				
			</div>
			
			 <div class="row-fluid">
				<form action="<?php echo $url; ?>" method="post" id="ma_ellak_software_submit_form" enctype="multipart/form-data" class="form-horizontal span12">
					<fieldset class="form-vertical span8 offset2">
					<div class="control-group">
						<label class="control-label span12" for="ctitle"><?php _e('Τίτλος', 'ma-ellak'); ?></label>
						<div class="controls">
						<input type="text" name="ctitle" id="ctitle" class="form-control input-block-level required" value="<?php if(isset($_POST['ctitle'])) echo $_POST['ctitle'];?>"  />
						</div>
					</div>
					
					<div class="control-group">
						<label for="cdescription"><?php _e('Πλήρης Περιγραφή του Λογισμικού', 'ma-ellak'); ?></label>
						<?php 	
							echo"<br/>";
							if(isset($_POST['cdescription'])) $content = $_POST['cdescription'];	
							wp_editor( $content, 'cdescription');
						?>
					</div>
					
					<div class="control-group">
						<label for="logo"><?php _e('Λογότυπο', 'ma-ellak'); ?></label>
						<input type="file" name="datafile" size="40">
					</div>
					
					<div class="control-group">
						<label for="type"><?php _e('Κατηγορία Λογισμικού', 'ma-ellak'); ?></label>
						<?php 	
							$type = get_taxonomy('type'); 
							echo ma_ellak_choose_one_term( $type, 'type-select', true); 
						?>
					</div>
					
					<div class="control-group">
						<label for="type"><?php _e('Τομείς Επιχειρηματικής Δραστηριότητας', 'ma-ellak'); ?></label>
						<?php 	
							$nace = get_taxonomy('nace'); 
							echo ma_ellak_add_term_chosebox( $nace, 'nace-select', true); 
						?>
					</div>
					
					<div class="control-group">
						<label for="cat"><?php _e('Θεματικές κατηγορίες', 'ma-ellak'); ?></label>
						<?php 						
							echo ma_ellak_add_thema_term_chosebox( 'thema-select', true); 
						?>
					</div>
					
					<div class="control-group">
						<label for="licence"><?php _e('Άδεια Χρήσης', 'ma-ellak'); ?></label>
						<?php 	
							$licence = get_taxonomy('licence'); 
							echo ma_ellak_add_term_chosebox( $licence, 'licence-select', true);
							//echo ma_ellak_choose_one_term( $licence, 'licence-select', true); 
						?>
						<span id="licenceslist"></span>
					</div>
					
					<div class="control-group">
						<label for="frascati"><?php _e('Επιστημονικά Πεδία', 'ma-ellak'); ?></label>
						<?php 
							$frascati = get_taxonomy('frascati'); 
							echo ma_ellak_add_term_chosebox( $frascati, 'frascati-select', true); 
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
					
					<?php
						global $software_fields;
						foreach($software_fields as $field){
							if($field['id']=='_ma_software_repository_source') continue;
							if($field['type'] != 'text' and $field['type'] != 'textarea_small' and $field['type'] != 'textarea') continue;
							if($field['type'] == 'textarea_small' or $field['type'] == 'textarea') {
						?>	
						<div class="control-group editor-area">
							<label class="control-label span12" for="<?php echo $field['id']; ?>"><?php echo $field['name'] ; ?></label>
							<?php 
								if($field['type'] == 'textarea_small')
									$settings = array( 'media_buttons' => false, 'textarea_rows'=>5 );
								else
									$settings = array( 'media_buttons' => false, 'textarea_rows'=>15 );
								
								if(isset($_POST[$field['id']])) $content = $_POST[$field['id']]; else $content = '';
								
								wp_editor( $content, $field['id'], $settings);
							?>
						</div>
						<?php
							} else {
						?>
						
							<div class="control-group">
								<label class="control-label span12" for="<?php echo $field['id']; ?>"><?php echo $field['name'] ; ?></label>
								<div class="controls">
								<input type="text" name="<?php echo $field['id']; ?>" id="<?php echo $field['id']; ?>" class="form-control input-block-level" value="<?php if(isset($_POST[$field['id']])) echo $_POST[$field['id']];?>"  />
								</div>
							</div>
						
					<?php
							}
						} ?>
					
					<div class="control-group">
						<label class="control-label span12" for="othertitle"><?php _e('Εναλλακτική Λύση για..', 'ma-ellak'); ?></label>
						<div class="controls">
						<input type="text" name="othertitle" id="othertitle" class="form-control input-block-level" value="<?php if(isset($_POST['othertitle'])) echo $_POST['othertitle'];?>"  placeholder="<?php _e('Τίτλος εναλλακτικού λογισμικού', 'ma-ellak'); ?>" />
						<?php 	
							echo"<br/>";
							$settings = array( 'media_buttons' => false, 'textarea_rows'=>5 );
							if(isset($_POST['otherdescription'])) $content = $_POST['otherdescription'];	
							wp_editor( $content, 'otherdescription', $settings);
						?>
						</div>
					</div>
					
					<input type="hidden" id="cuser" name="cuser" value="<?php echo $cur_user->ID; ?>" />
					<input type="hidden" id="_ma_software_repository_source" name="_ma_software_repository_source" value="" />
					<div class="control-group">
						<label class="control-label span12" for="ma_ellak_software_submit"></label>
						<div class="controls">
							<button type="submit" id="ma_ellak_software_submit" name="ma_ellak_software_submit" class="btn btn-primary btn-block"><?php _e('ΥΠΟΒΟΛΗ', 'ma-ellak');?></button>
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