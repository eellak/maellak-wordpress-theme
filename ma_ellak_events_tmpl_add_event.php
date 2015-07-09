<?php
/*
Template Name: Event - Add
*/

	 if (! is_user_logged_in()) // Μόνο εγγεγραμμένοι χρήστες μπορούν να είναι εδώ.
		header('Location: '.URL.''); 
	
	$cur_user = wp_get_current_user();
	
	$success = false;
	$ma_message = '';
	

	if(isset($_POST['ma_ellak_event_submit']) &&isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {
		
		$title = sanitize_text_field($_POST['titlez']);
		$description = $_POST['descriptionz']; 
		$author =  sanitize_text_field($_POST['userz']); 
		$event_title_program_desc = sanitize_text_field($_POST['event_title_program_desc']); 
		$tag_list = implode(',', $_POST['tag-select']);
		if(isset($_POST['selftags'])){
			$tag_list .= ','.sanitize_text_field($_POST['selftags']);
		}
		// Ορίζουμε τις κατηγορίες/ταξονομίες
		$tax = array('post_tag' => $tag_list, 'thema' => implode(',', $_POST['thema-select']));
	
		$event = array(
			'post_title'	=> $title,
			'post_content'	=> $description,
			'tax_input'		=> $tax, 		
			'post_status'	=> 'draft', 	// publish, preview, future, etc.
			'post_type'		=> 'events', 	
			'post_author'	=> $author 
		);
		
		// Καταχωρούμε το Λογισμικό
		$event_id = wp_insert_post($event);
		
		if($event_id){
			// Αποθηκεύουμε τα post meta
			ma_ellak_events_save_details($event_id);
			
			// Redirect αν το θέλουμε (πχ στο δημοσιευμένο άρθρο). 
			//wp_redirect( home_url() ); exit;
			$ma_message = '<p class="message">H καταχώρισή σας ήταν επιτυχής!</p>';
			$success = true;
			
			// Αποστολή email στον διαχειριστή/υπεύθυνο
			$email_message = 'Νέα καταχώριση Εκδήλωσης με τίτλο: '.$title;
			$unit_id =  ma_ellak_get_unit_id();
			
			if( $unit_id != 0)
				update_post_meta( $event_id, '_ma_ellak_belongs_to_unit',$unit_id );
			
			// Ενημέρωσε τους Διαχειριστές της ΜΑ -----------------------------------
			$unit_id = get_post_meta($event_id, '_ma_ellak_belongs_to_unit', true);
			if($unit_id != 0 ){
				$mail_message = 'Καταχωρήθηκε Νέα Εκδήλωση,\r\n\r\n';
				$mail_message .= 'Αφορά την εκδήλωση '.get_the_title($event_id).' ( '.get_permalink($event_id).' ).\r\n\r\n';
				$mail_message .= 'Επεξεργαστείτε την εκδήλωση '.get_permalink(get_option_tree('ma_ellak_update_event'))."?id=".$event_id.' \r\n\r\n';
				$mail_message .= 'Διαχείριση Δικτυακής Πύλης Μονάδων Αριστείας ΕΛ/ΛΑΚ \r\n\r\n';
				$admin_users = get_users(array('meta_key' => '_ma_ellak_admin_unit', 'meta_value' =>$unit_id ));
				foreach ($admin_users as $user) {
					wp_mail( $user->user_email, 'Μονάδες Αριστείας ΕΛ/ΛΑΚ - Καταχώριση Νέας Εκδήλωσης', $mail_message );
				}
			}
		} else {
			$ma_message = '<p class="error">Παρουσιάστηκε πρόβλημα και η καταχώρησή Δεν ήταν επιτυχής.</p>';
		}
	} 
?>
<?php get_header(); 
//echo get_page_template();
?>

<div class="postWrapper" id="post-<?php the_ID(); ?>">
<?php 

?>
	<?php while ( have_posts() ) : the_post(); ?>
	<?php endwhile; ?>
	<div class="post">
		<?php /*---------------------- Form ------------------------------------------*/ ?>
		<div id="ma-message"><?php echo($ma_message); ?> </div>
		<?php if($success){ } else { ?>
			<form action="<?php echo esc_url( get_permalink( get_option_tree('ma_ellak_add_event_option_id') ) ); ?>" method="post" id="ma_ellak_event_submit_form">
				<div class="control-group">
					<label for="titlez" ><?php _e('ΤΙΤΛΟΣ ΕΚΔΗΛΩΣΗΣ (*)', 'ma-ellak'); ?></label>
					<div class="controls">
						<input type="text" name="titlez" id="titlez" class="input-block-level input required" 
							value="<?php if(isset($_POST['title'])) echo $_POST['title'];?>" />				
                    </div>
				</div>
				
				<div class="control-group">
					<label for="descriptionz"><?php _e('Πλήρης Περιγραφή εκδήλωσης', 'ma-ellak'); ?></label>
				<?php 	
					echo"<br/>";
					if(isset($_POST['description'])) $content = $_POST['description'];
						
					wp_editor( $content, 'descriptionz');
				?>
				<span class="help-block"><?php echo __('Αναλυτική περιγραφή της εκδήλωσης','ma-ellak')?></span>
				</div>
		
				<div class="control-group">
					<label for="thema-select"><?php _e('Θεματική', 'ma-ellak'); ?></label>
					<?php 						
						//$thema = get_taxonomy('thema'); 
						//echo ma_ellak_add_term_chosebox( $thema, 'thema-select', true); 
						echo ma_ellak_add_thema_term_chosebox( 'thema-select', true); 
					?>
				</div>
				
				<div class="control-group">
					<label for="tag-select"><?php _e('Ετικέτες', 'ma-ellak'); ?></label>
					<?php 
						$tagz = get_taxonomy('post_tag'); 
						echo ma_ellak_add_term_chosebox( $tagz, 'tag-select'); 
					?>
					<a href="#" id="addnewtags" style="font-size:90%; font-style:italics;"><?php _e('Προσθέστε δικές σας Ετικέτες αν δεν εντοπίστηκαν παραπάνω.', 'ma-ellak'); ?></a>
					<input type="text" name="selftags" style="display:none;" id="selftags" class="form-control input-block-level" value="<?php if(isset($_POST['selftags'])) echo $_POST['selftags'];?>" placeholder="<?php _e('Χωρίστε με κόμα (,) τις νέες ετικέτες', 'ma-ellak'); ?>" />
				
				</div>
				<div class="row-fluid">
					<div class="span4">
						<div class="control-group">
							<label for="_ma_events_type"><?php _e('Τύπος εκδήλωσης', 'ma-ellak'); ?></label>
							<select name="_ma_events_type" id="_ma_events_type" class="required" class="input-block-level">
								<option value="event" selected="selected">Εκδήλωση</option>
								<option value="seminar" >Σεμινάριο</option>
								<option value="seminar1" >Κύκλος Εκπαίδευσης</option>
								<option value="school" >Σχολείο Ανάπτυξης Κώδικα</option>
								<option value="meeting" >Ημερίδα</option>
								<option value="summerschool" >Θερινό σχολείο</option>
							</select>
							</div>
						</div><!-- span6 -->
						<div class="span4">
							<div class="control-group">
						
							<label for="_ma_events_participate"><?php _e('Δήλωση συμμετοχής', 'ma-ellak'); ?></label>
							<select name="_ma_events_participate" id="_ma_events_participate" class="required" class="input-block-level">
								<option value="no" selected="selected">Όχι</option>
								<option value="yes" >Ναι</option>
							</select>
					</div>
						</div><!-- span6 -->
						<div class="span4">
								
						<div class="control-group">
						<div class="controls">
							<label  class="checkbox inline" for="_ma_event_evaluation">
							<input type="checkbox" name="_ma_event_evaluation" id="_ma_event_evaluation" 
							<?php if(isset($meta['_ma_event_evaluation'][0]) && $meta['_ma_event_evaluation'][0]=='on') echo "checked='checked'";?>
							/>
							<span class="meta"><?php _e('Θέλετε να αξιολογηθεί μετά το πέρας;', 'ma-ellak');  ?></span>
							</label>
						</div>
						</div>
							</div><!-- span6 -->
				</div><!-- row-fluid -->
					
					<div class="row-fluid">
						<div class="span6">
							<div class="control-group">
								<label for="_ma_event_place"><?php _e('Χώρος', 'ma-ellak'); ?></label>
								<div class="controls">
									<input type="text" name="_ma_event_place" id="_ma_event_place" class="input-block-level input " value="<?php if(isset($_POST['_ma_event_place'])) echo $_POST['_ma_event_place'];?>" />
								</div>
							</div>
						</div><!-- span6 -->
						<div class="span6">
						
							<div class="control-group">
								<label for="_ma_event_address"><?php _e('Διεύθυνση', 'ma-ellak'); ?></label>
								<input type="text" name="_ma_event_address" id="_ma_event_address" class="input-block-level input " value="<?php if(isset($_POST['_ma_event_address'])) echo $_POST['_ma_event_address'];?>"  />
							</div>
						</div><!-- span6 -->
					</div>
					<div class="row-fluid">
						<div class="span3">
							<div class="control-group">
								<label for="_ma_event_startdate_timestamp"><?php _e('Ημερομηνία έναρξης (*)', 'ma-ellak'); ?></label>
								<input class="cmb_datepicker  input-block-level" type="text" name="_ma_event_startdate_timestamp" id="_ma_event_startdate_timestamp" value="">
							</div>	
						</div><!-- span6 -->
						<div class="span3">
							<div class="control-group">
							<label for="_ma_event_startdate_time"><?php _e('Ώρα έναρξης', 'ma-ellak'); ?></label>
							<input class="cmb_timepicker text_time input-block-level" type="text" name="_ma_event_startdate_time" id="_ma_event_startdate_time"  autocomplete="OFF">
							</div>
						</div><!-- span6 -->
						<div class="span3">
							<div class="control-group">
						<label for="_ma_event_enddate_timestamp"><?php _e('Ημερομηνία Λήξης  (*)', 'ma-ellak'); ?></label>
						<input class="cmb_datepicker  input-block-level" type="text" name="_ma_event_enddate_timestamp" id="_ma_event_enddate_timestamp" value="">
					</div>	
						</div><!-- span6 -->
						<div class="span3">
							<div class="control-group">
						<label for="_ma_event_enddate_time"><?php _e('Ώρα λήξης', 'ma-ellak'); ?></label>
						<input class="cmb_timepicker text_time input-block-level" type="text" name="_ma_event_enddate_time" id="_ma_event_enddate_time"  autocomplete="OFF">
					</div>
						</div><!-- span6 -->
					</div><!-- row-fluid -->
						
				<div class="control-group">
					<label for="_ma_event_title_program_desc"><?php _e('Πρόγραμμα εκδήλωσης', 'ma-ellak'); ?></label>
				<?php 	
					echo"<br/>";
					if(isset($_POST['_ma_event_title_program_desc'])) $content = $_POST['_ma_event_title_program_desc'];
						
					wp_editor( $content, '_ma_event_title_program_desc');
				?>
				<span class="help-block"><?php echo __('Αναλυτική περιγραφή της εκδήλωσης','ma-ellak')?></span>
				</div>
						
					<div class="control-group">
						<div class="controls">
							<label  class="checkbox inline" for="_ma_video_know">
							<input type="checkbox" name="_ma_event_live" id="_ma_event_live"/>
							<span class="meta"><?php _e('Έχει live;', 'ma-ellak');  ?></span>
							</label>
						</div>
					</div>
				
					
					<div id="meta_inner">
				    </div>
	   				<span class="add btn btn-info btn-xs"><?php echo __('Προσθήκη Ζωντανής Σύνδεσης','ma-ellak'); ?></span>
	   				<br/><br/>
	   				<span id="here"></span>
	   				
				<br/><br/>
                <button id="ma_ellak_event_submit" name="ma_ellak_event_submit" class="btn btn-primary btn-block"><?php _e('Υποβολή', 'ma-ellak'); ?></button>
				<input type="hidden" id="userz" name="userz" value="<?php echo $cur_user->ID; ?>" />
				<input type="hidden" name="eventslistcounter" id="eventslistcounter" value=0/>
				
				<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
			</form>
		<?php } ?>
		<?php /*---------------------- End Form ------------------------------------------*/ ?>
	</div>
	</div>
<?php get_footer(); ?>