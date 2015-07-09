<?php
/*
Template Name: Software - Edit
*/

	if (! is_user_logged_in()) // Μόνο εγγεγραμμένοι χρήστες μπορούν να είναι εδώ.
		header('Location: '.URL.''); 
	get_header();
	
	$software_post;
	$software_id = 0;
	if(isset($_GET['sid']) and $_GET['sid'] !=''){
		$software_post = get_post(intval($_GET['sid']));
		if(!empty($software_post) and 'software' == $software_post->post_type) 
			$software_id =intval($_GET['sid']);
	}
	
	$success = false;
	$ma_message = '';
	
	$url = get_permalink(get_option_tree('ma_ellak_edit_software'));
	$url .="?sid=".$software_id;
	
	$success = false;
	$ma_message = '';

	
if(!ma_ellak_user_can_edit_post($software_post)){

		_e('Δεν έχετε δικαίωμα Επεξεργασίας του Λογισμικού','ma-ellak');
	 
}else if($software_id != 0){
	
	$current_logo = get_post_meta($software_post->ID, $ma_prefix . 'software_logo', true);
	
	if(isset($_POST['ma_ellak_software_submit']) &&isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {
		
		$title = sanitize_text_field($_POST['ctitle']);
		$description = $_POST['cdescription']; 
		$status =  sanitize_text_field($_POST['gstatus']);
		$allowcomments = sanitize_text_field($_POST['allowcomments']);
		
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
			'ID'			=> $software_id ,
			'post_title'	=> $title,
			'post_content'	=> $description,
			'tax_input'		=> $tax, 		
			'post_status'	=> $status, 	// publish, preview, future, etc.
			'comment_status' => $allowcomments,
		);
		
		// Καταχωρούμε το Λογισμικό
		$software_id = wp_update_post($software);
		
		if($software_id){
			ma_ellak_software_save_details($software_id);
			global $ma_prefix ;
			if ($_FILES and isset($_POST['replacelogo']) and $_POST['replacelogo'] == 'yes' and $current_logo != '' and !empty($current_logo )) {
				foreach ($_FILES as $file => $array) {
					if(!empty($file))
						insert_attachment($file, $software_id, $ma_prefix . 'software_logo');
				}
			};
			
			if( $current_logo == '' or empty($current_logo ) and $_FILES ){
				foreach ($_FILES as $file => $array) {
					if(!empty($file))
						insert_attachment($file, $software_id, $ma_prefix . 'software_logo');
				}
			}
			
			$ma_message = '<p class="message">H επεξεργασία Λογισμικού ήταν επιτυχής.</p>';
			$success = true;
			$unit_id =  ma_ellak_get_unit_id();
			
			if( $unit_id != 0)
				update_post_meta( $event_id, '_ma_ellak_belongs_to_unit',$unit_id );
			
			/* Ενημέρωσε τους Διαχειριστές της ΜΑ -----------------------------------
			$unit_id = get_post_meta($event_id, '_ma_ellak_belongs_to_unit', true);
			if($unit_id != 0 ){
				$mail_message = 'Καταχωρήθηκε Νέο Λογισμικό- Ανανέωση μεταδεδομένων,\r\n\r\n';
				$mail_message .= 'Αφορά το λογισμικό '.get_the_title($event_id).' ('.get_permalink($event_id).').\r\n\r\n';
				$mail_message .= 'Επεξεργαστείτε το λογισμικό '.get_permalink(get_option_tree('ma_ellak_edit_software'))."?id=".$software_id.' \r\n\r\n';
				$mail_message .= 'Διαχείριση Δικτυακής Πύλης Μονάδων Αριστείας ΕΛ/ΛΑΚ \r\n\r\n';
				$admin_users = get_users(array('meta_key' => '_ma_ellak_admin_unit', 'meta_value' =>$unit_id ));
				foreach ($admin_users as $user) {
					wp_mail( $user->user_email, 'Μονάδες Αριστείας ΕΛ/ΛΑΚ - Καταχώριση Νέου Λογισμικού - Ανανέωση μεταδεδομένων', $mail_message );
				}
			}
			*/
		} else {
			$ma_message = '<p class="error">Παρουσιάστηκε πρόβλημα και η επεξεργασία Δεν ήταν επιτυχής.</p>';
		}
	} 
	
	if(isset($_GET['comment']) and isset($_GET['status']) ){
		$cid = intval($_GET['comment']);
		$comment = get_comment($cid);
		
		if(!empty($comment )){
			$commentarr = array();
			$commentarr['comment_ID'] = $comment -> comment_ID; 
			
			if($_GET['status'] == 'approve' ){
				$commentarr['comment_approved'] = 1;
				$result = wp_update_comment( $commentarr );
				if($result == 1)
					$ma_message = '<p class="alert alert-info">Το Σχόλιο δημοσιεύθηκε με επιτυχία.</p>';
				else
					$ma_message = '<p class="alert error-info">Συνέβη Σφάλμα κατά την Έγκριση του Σχολίου.</p>';
			} else if($_GET['status'] == 'discard' ){
				$commentarr['comment_approved'] = 'spam';
				$result = wp_update_comment( $commentarr );
				if($result == 1)
					$ma_message = '<p class="alert alert-info">Το Σχόλιο ορίστηκε ώς Ανεπιθύμητο με επιτυχία.</p>';
				else
					$ma_message = '<p class="alert error-info">Συνέβη Σφάλμα κατά τον ορισμό του Σχολίου ως Ανεπιθύμητου.</p>';
			} else {
				$ma_message = '<p class="alert error-info">Μη Αποδεκτή Ενέργεια!</p>';
			}
		} else {
			$ma_message = '<p class="alert error-info">Το Σχόλιο δεν Εντοπίστηκε!</p>';
		}
	}
	
	$allowcomments  = $software_post->comment_status;
	$gstatus = $software_post->post_status;
	
?>
	
   	<div class="row-fluid event">
		<div class="cols">
			<div class="span12">
				  
			</div>
		</div>
	</div>
	
   	 <div class="row-fluid event">
		<?php /*---------------------- Form ------------------------------------------*/ ?>
		<div id="ma-message"><?php echo($ma_message); ?> </div>
		<?php if($success){ } else { ?>
		<div class="yamm-content events">
            <div class="row-fluid">
        
				<form action="<?php echo $url; ?>" method="post" id="ma_ellak_software_submit_form" enctype="multipart/form-data" class="form-horizontal span12">
					<fieldset class="form-vertical span8 offset2">
					<div class="control-group">
						<label class="control-label span12" for="ctitle"><?php _e('Τίτλος', 'ma-ellak'); ?></label>
						<div class="controls">
						<input type="text" name="ctitle" id="ctitle" class="form-control input-block-level required" value="<?php echo $software_post->post_title; ?>"  />
						</div>
					</div>
					
					<div class="control-group">
						<label for="cdescription"><?php _e('Πλήρης Περιγραφή του Λογισμικού', 'ma-ellak'); ?></label>
						<?php 	
							echo"<br/>";
							wp_editor( $software_post->post_content, 'cdescription');
						?>
					</div>
					
					<div class="control-group">
						<label for="logo"><?php _e('Λογότυπο', 'ma-ellak'); ?></label>
						<input type="file" name="datafile" size="40">
						<?php if($current_logo != '' and !empty($current_logo)) { ?>
							<input type="checkbox" name="replacelogo" value="yes"> <?php _e('Αντικατάσταση Λογότυπου'); ?>
						<?php }?>
					</div>
					
					<?php if($current_logo != '' and !empty($current_logo)) { ?>
						<div class="control-group">
							<label for="current_logo"><?php _e('Υπάρχον Λογότυπο', 'ma-ellak'); ?></label>
							<?php global $ma_prefix; ?>
							<img src="<?php echo $current_logo; ?>" width="300" />
						</div>
					<?php }?>
					
					<div class="control-group">
						<label for="type"><?php _e('Κατηγορία Λογισμικού', 'ma-ellak'); ?></label>
						<?php 	
							$terms = array();
							foreach (wp_get_post_terms($software_id, 'type')  as $term)
								$terms[]= $term->term_id;
							$type = get_taxonomy('type'); 
							echo ma_ellak_choose_one_term( $type, 'type-select', true, $terms); 
						?>
					</div>
					
					<div class="control-group">
						<label for="cat"><?php _e('Θεματικές κατηγορίες', 'ma-ellak'); ?></label>
						<?php 	
							$terms = array();
							foreach (wp_get_post_terms($software_id, 'thema')  as $term)
								$terms[]= $term->term_id;
							echo ma_ellak_add_thema_term_chosebox( 'thema-select', true, $terms); 
						?>
					</div>
					
					<div class="control-group">
						<label for="type"><?php _e('Τομείς Επιχειρηματικής Δραστηριότητας', 'ma-ellak'); ?></label>
						<?php 	
							$terms = array();
							foreach (wp_get_post_terms($software_id, 'nace')  as $term)
								$terms[]= $term->term_id;
							$nace = get_taxonomy('nace'); 
							echo ma_ellak_add_term_chosebox($nace, 'nace-select', true, $terms); 
						?>
					</div>
					
					<div class="control-group">
						<label for="licence"><?php _e('Άδεια Χρήσης', 'ma-ellak'); ?></label>
						<?php
						
							$terms = array();
							foreach (wp_get_post_terms($software_id, 'licence')  as $term)
								$terms[]= $term->term_id;							
							$licence = get_taxonomy('licence'); 
							echo ma_ellak_add_term_chosebox($licence, 'licence-select', true, $terms);
							//echo ma_ellak_choose_one_term( $licence, 'licence-select', true, $terms); 
						?>
					</div>
					
					<div class="control-group">
						<label for="frascati"><?php _e('Επιστημονικά Πεδία', 'ma-ellak'); ?></label>
						<?php 
							$terms = array();
							foreach (wp_get_post_terms($software_id, 'frascati')  as $term)
								$terms[]= $term->term_id;		
							$frascati = get_taxonomy('frascati'); 
							echo ma_ellak_add_term_chosebox( $frascati, 'frascati-select', true, $terms);
						?>
					</div>
					
					<div class="control-group">
						<label for="frascati"><?php _e('Πακέτα Λογισμικού', 'ma-ellak'); ?></label>
						<?php 
							$terms = array();
							foreach (wp_get_post_terms($software_id, 'package')  as $term)
								$terms[]= $term->term_id;		
							$package = get_taxonomy('package'); 
							echo ma_ellak_add_term_chosebox( $package, 'package-select', true, $terms);
						?>
					</div>
					
					<div class="control-group">
						<label for="tags"><?php _e('Ετικέτες', 'ma-ellak'); ?></label>
						<?php 
							$terms = array();
							foreach (wp_get_post_terms($software_id, 'post_tag')  as $term)
								$terms[]= $term->slug;
							$tagz = get_taxonomy('post_tag'); 
							echo ma_ellak_add_term_chosebox( $tagz, 'tag-select', false, $terms ); 
						?>
						<a href="#" id="addnewtags" style="font-size:90%; font-style:italics;"><?php _e('Προσθέστε νέες Ετικέτες αν δεν εντοπίζονται παραπάνω.', 'ma-ellak'); ?></a>
						<input type="text" name="selftags" style="display:none;" id="selftags" class="form-control input-block-level" value="<?php if(isset($_POST[$field['selftags']])) echo $_POST[$field['selftags']];?>" placeholder="<?php _e('Χωρίστε με κόμα (,) τις νέες ετικέτες', 'ma-ellak'); ?>" />
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
								
								$content = get_post_meta($software_post->ID, $field['id'], true);
								
								wp_editor( $content, $field['id'], $settings);
							?>
						</div>
						<?php
							} else {
						?>
						
							<div class="control-group">
								<label class="control-label span12" for="<?php echo $field['id']; ?>"><?php echo $field['name'] ; ?></label>
								<div class="controls">
								<?php $value = get_post_meta($software_post->ID, $field['id'], true); ?>
								<input type="text" name="<?php echo $field['id']; ?>" id="<?php echo $field['id']; ?>" class="form-control input-block-level" value="<?php echo $value; ?>"  />
								</div>
							</div>
						
					<?php
							}
						} ?>
					
					<?php if(ma_ellak_user_is_post_admin($software_post)){ ?>
						<div class="admineditor back-gray">
							<div class="row-fluid">
								<div class="span4 offset1">
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
								<div class="span4 offset1">
									<div class="control-group">
										<label class="control-label span12" for="allowcomments"><?php  _e('Σχολιασμός', 'ma-ellak'); ?></label>
										<div class="controls">
											<select class="allowcomments" name="allowcomments">
												<option value=""><?php _e('Επιλέξτε', 'ma-ellak'); ?></option>
												<option value="open" <?php if($allowcomments == 'open') echo 'selected="selected"'; ?>><?php _e('Επιτρέπεται', 'ma-ellak'); ?></option>
												<option value="closed" <?php if($allowcomments == 'closed') echo 'selected="selected"'; ?>><?php _e('Δεν επιτρέπεται', 'ma-ellak'); ?></option>
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php 
						    
							$args = array(
								'status' => 'hold',
								'post_id' => $gnorisma_id, // use post_id, not post_ID
							);
								
							if(!isset($_GET['type'])){
								$ctype = 'comment';
							} else {
								$ctype = $_GET['type'];
								$args ['meta_query'] = array(
										array(
											'key' => 'type',
											'value' => $ctype,
											'compare' => '='
										)
								);
							}
							
							$comments = get_comments($args);
							?>
							<div class="comment-editor">
								<div class="row-fluid">
									<div class="span12">
										<?php 
											echo '<a class="btn btn-tiny btn-more action-comment pull-right" href="'.$url.'#comment_head_edit" >'.__('Σχόλια', 'ma-ellak').'</a>';
											
											echo '<a class="btn btn-tiny btn-more action-comment pull-right" href="'.$url.'&type=alternative#comment_head_edit" >'.__('Εναλλακτικές', 'ma-ellak').'</a>';
											
											echo '<a class="btn btn-tiny btn-more action-comment pull-right" href="'.$url.'&type=bpractice#comment_head_edit" >'.__('Βέλτιστες Πρακτικές', 'ma-ellak').'</a>';
										?>
									</div>
								</div>
								<div class="row-fluid">
									<div class="span12">
										<div id="comment_head_edit">
											<?php
												if($ctype == 'comment')
													_e('Σχόλια προς Επεξεργασία', 'ma-ellak'); 
												elseif($ctype == 'alternative')
													_e('Εναλλακτικές Λύσεις προς Επεξεργασία', 'ma-ellak'); 
												else //$ctype == 'bpractice'
													_e('Βέλτιστες Πρακτικές προς Επεξεργασία', 'ma-ellak'); 
											?> 
											<span><?php /*if($ctype != 'comment' )*/ echo count($comments); //temporary hide wrong comment number ?></span></div>
									</div>
								</div>
								<?php $class_comm = 'hideme' ; if(isset($_GET['comment'])) $class_comm = 'openme'; ?>
								<ul id="comment_list_admin" class="<?php echo $class_comm  ; ?>">
						<?php		foreach($comments as $comment) { 
										$type = get_comment_meta( $comment->comment_ID, 'type',  true );
										if($ctype == 'comment' and $type != '')  continue;
									echo '<li><div class="author_name">'.$comment->comment_author . '</div>';
									if(isset($_GET['type'])){
										if($ctype == 'alternative'){
											$meta_title = get_comment_meta( $comment->comment_ID, 'title',  true );
											echo '<div class="comment_meta">' .__('Τίτλος', 'ma-ellak'). $meta_title.'</div>';
										} else {
											$meta_title = get_comment_meta( $comment->comment_ID, 'title',  true );
											$organisation = get_comment_meta( $comment->comment_ID, 'organisation',  true );
											echo '<div class="comment_meta">' .__('Τίτλος', 'ma-ellak'). $meta_title.'</div>';
											echo '<div class="comment_meta">' .__('Φορέας', 'ma-ellak'). $organisation.'</div>';
										}
									}
									echo '<div class="comment_content">' . $comment->comment_content.'</div>';
									echo '<div class="comment_actions">';
									echo '<a class="btn btn-tiny btn-more action-comment discard-comment pull-right" href="'.$url.'&type='.$ctype.'&comment='.$comment->comment_ID.'&status=discard#comment_list_admin" >'.__('Ανεπιθύμητο', 'ma-ellak').'</a>';
									echo '<a class="btn btn-tiny btn-more action-comment approve-comment pull-right" href="'.$url.'type='.$ctype.'&comment='.$comment->comment_ID.'&status=approve#comment_list_admin" >'.__('Έγκριση', 'ma-ellak').'</a>';
									echo '</div></li>';
								}  ?>
								</ul>
							</div>
					<?php } ?>
					
					<div class="control-group">
						<label class="control-label span12" for="ma_ellak_software_submit"></label>
						<div class="controls">
							<button type="submit" id="ma_ellak_software_submit" name="ma_ellak_software_submit" class="btn btn-primary btn-block"><?php _e('ΕΠΕΞΕΡΓΑΣΙΑ', 'ma-ellak');?></button>
						</div>
					</div>
					<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
					</fieldset>
				</form>
			</div>
		<?php } /*---------------------- End Form ------------------------------------------*/ ?>
		</div>
	</div>	
<?php } else {   _e('Πρέπει να επιλέξετε Λογισμικό πρώτα!','ma-ellak');  }

get_footer(); ?>