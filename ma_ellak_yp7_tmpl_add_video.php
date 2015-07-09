<?php
/*
Template Name: Video - Add
*/

	if (! is_user_logged_in()) // Μόνο εγγεγραμμένοι χρήστες μπορούν να είναι εδώ.
		header('Location: '.URL.''); 
	
	$cur_user = wp_get_current_user();
	$success = false;
	$ma_message = '';
	if(isset($_POST['publish']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {
		$title = sanitize_text_field($_POST['title']);
		$description = $_POST['description']; 
		$author =  sanitize_text_field($_POST['user']); 

		// Ορίζουμε τις κατηγορίες/ταξονομίες
		$tax1=$tax2=array();
		
		$tax1 = implode(',', $_POST['tag-select']);
		if(isset($_POST['selftags'])){
			$tax1 .= ','.sanitize_text_field($_POST['selftags']);
		}
		$tax1=array('post_tag' => $tax1);
		if (isset($_POST['thema-select']))
			$tax2=array('thema' => implode(',', $_POST['thema-select']));
		$tax=array_merge($tax1, $tax2);

		//$tax = array('post_tag' => implode(',', $_POST['tag-select']), 'thema' => implode(',', $_POST['thema-select']));
		$video = array(
			'post_title'	=> $title,
			'post_content'	=> $description,
			'post_status'	=> 'draft',	// publish, preview, future, etc.
			'post_type'		=> 'video',
			'post_excerpt'	=> $excerpt,
			'post_author'	=> $author,
			'tax_input'		=> $tax,
			'post_excerpt'	=> ''
		);

		// Καταχωρούμε το Βίντεο
		$video_id = wp_insert_post($video);
		$unit_id =  ma_ellak_get_unit_id();
		if( $unit_id != 0)
			update_post_meta( $video_id, '_ma_ellak_belongs_to_unit',$unit_id );
		if($video_id){
			// Αποθηκεύουμε τα post meta
			ma_ellak_video_save_details($video_id);
			
			// Ενημέρωσε τους Διαχειριστές της ΜΑ -----------------------------------
			$unit_id = get_post_meta($video_id, '_ma_ellak_belongs_to_unit', true);
			if($unit_id != 0){
				$mail_message = 'Καταχωρήθηκε Νέο Video,\r\n\r\n';
				$mail_message .= 'Αφορά το Video '.get_the_title($video_id).' ( '.get_permalink($video_id).' ).\r\n\r\n';
				$mail_message .= 'Επεξεργαστείτε το Video '.get_permalink(get_option_tree('ma_ellak_update_video'))."?id=".$video_id.' \r\n\r\n';
				$mail_message .= 'Διαχείριση Δικτυακής Πύλης Μονάδων Αριστείας ΕΛ/ΛΑΚ \r\n\r\n';
				$admin_users = get_users(array('meta_key' => '_ma_ellak_admin_unit', 'meta_value' =>$unit_id ));
				foreach ($admin_users as $user) {
					wp_mail( $user->user_email, 'Μονάδες Αριστείας ΕΛ/ΛΑΚ - Καταχώριση Νέου Video', $mail_message );
					//echo $user->user_email.' => '.$mail_message;
				}
			}
			
			$ma_message = '<p class="message">H καταχώρησή σας ήταν επιτυχής.</p>';
			$success = true;
		} else {
			$ma_message = '<p class="error">Παρουσιάστηκε πρόβλημα και η καταχώρηση δεν ήταν επιτυχής.</p>';
		}
	} 
?>
<?php get_header();
?>

<div class="postWrapper" id="post-<?php the_ID(); ?>">
	<?php while ( have_posts() ) : the_post(); ?>
	<?php endwhile; ?>
	<div class="post">
		<?php /*---------------------- Form ------------------------------------------*/ ?>
		<div id="ma-message"><?php _e($ma_message, 'ma-ellak'); ?> </div>
		<?php if($success){ } else { ?>
			<form action="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>" method="post" id="post">
				
				<div class="control-group">
					<label for="title" ><?php _e('ΤΙΤΛΟΣ βίντεο (*)', 'ma-ellak'); ?></label>
					<div class="controls">
						<input type="text" name="title" id="title" class="input-block-level input required" value="<?php if(isset($_POST['title'])) echo $_POST['title'];?>" class="required" />				
                    </div>
				</div>
				<div class="control-group">
					<label for="description"><?php _e('Περιγραφή βίντεο', 'ma-ellak'); ?></label>
				<?php
					if(isset($_POST['description'])) $content = $_POST['description'];
					else $content='';
					$settings = array( 'media_buttons' => false, 'textarea_rows'=>5 );
					wp_editor( $content, 'description',$settings );
				?>
				</div>
				<div class="row-fluid">
					<div class="span3">
						<div class="control-group">
								<label for="_ma_video_date"><?php _e('Ημερομηνία προβολής', 'ma-ellak'); ?></label>
								<div class="controls ">
									<input class="cmb_text_small cmb_datepicker " name="_ma_video_date" id="_ma_video_date" value="" type="text-date" width="100" />
								</div>
						</div>
					</div><!-- span6 -->
					<div class="span6">
						<div class="control-group">
							<label for="_ma_video_duration"><?php _e('Χρονική διάρκεια', 'ma-ellak'); ?></label>
							<input class="cmb_text_tiny" maxlength="2" name="_ma_video_duration_hours" id="_ma_video_duration_hours" placeholder="HH" value="<?php if(isset($_POST['_ma_video_duration_hours'])) echo $_POST['_ma_video_duration_hours'];?>" size=2/>:
							<input class="cmb_text_tiny" maxlength="2" name="_ma_video_duration_minutes" id="_ma_video_duration_minutes"  placeholder="MM" value="<?php if(isset($_POST['_ma_video_duration_minutes'])) echo $_POST['_ma_video_duration_minutes'];?>" size=2/>:
							<input class="cmb_text_tiny" maxlength="2" name="_ma_video_duration_seconds" id="_ma_video_duration_seconds" placeholder="SS" value="<?php if(isset($_POST['_ma_video_duration_seconds'])) echo $_POST['_ma_video_duration_seconds'];?>" size=2 />
							<br><span id=result></span><br><span id=result_m></span><br><span id=result_s></span>
						</div>
					</div>
				</div>
				<div class="control-group">
					<label for="_ma_video_url"><?php _e('Εξωτερικός σύνδεσμος βίντεο (*) - Youtube & Vimeo - Video hosting Services', 'ma-ellak'); ?></label>
					<div class="controls ">
						<input type="text" name="_ma_video_url" id="_ma_video_url"  class="input-block-level" value="<?php if(isset($_POST['_ma_video_url'])) echo $_POST['_ma_video_url'];?>"/>
					</div>
					<br><span id="result_"></span>
				</div>

				
				<div class="control-group">
					<div class="controls">
						<label  class="checkbox inline" for="_ma_video_know">
						<input type="checkbox" name="_ma_video_know" id="_ma_video_know"/>
						<span class="meta"><?php _e('Έχω γνώση του περιεχομένου που αναρτώ (*)', 'ma-ellak'); ?></span>
						</label>
					</div>
				</div>
				<div class="row-fluid"></div>
				<div class="control-group">
					<label for="cat"><?php _e('Θεματικές κατηγορίες', 'ma-ellak'); ?></label>
					<?php 						
						//$thema = get_taxonomy('thema'); 
						echo ma_ellak_add_thema_term_chosebox( 'thema-select', true); 
					?>
				</div>
				<div class="control-group">
					<label for=""><?php _e('Ετικέτες', 'ma-ellak'); ?></label>
					<?php 
						$tagz = get_taxonomy('post_tag'); 
						echo ma_ellak_add_term_chosebox( $tagz, 'tag-select'); 
					?>
					<a href="#" id="addnewtags" style="font-size:90%; font-style:italics;"><?php _e('Προσθέστε δικές σας Ετικέτες αν δεν εντοπίστηκαν παραπάνω.', 'ma-ellak'); ?></a>
					<input type="text" name="selftags" style="display:none;" id="selftags" class="form-control input-block-level" value="<?php if(isset($_POST['selftags'])) echo $_POST['selftags'];?>" placeholder="<?php _e('Χωρίστε με κόμα (,) τις νέες ετικέτες', 'ma-ellak'); ?>" />
					
				</div>
				
				<div class="control-group">
					<label for=""><?php _e('Σχετική Εκδήλωση', 'ma-ellak'); ?></label>
					<?php 
						 ma_ellak_render_events(0); 
					?>
				</div>

                <button id="publish" name="publish" class="btn btn-primary btn-block"><?php _e('Υποβολή', 'ma-ellak'); ?></button>
				<input type="hidden" id="user" name="user" value="<?php echo $cur_user->ID; ?>" />
				<input type="hidden" id="admin" name="admin" value="0" />
				
				<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
			</form>
		<?php } ?>
		<?php /*---------------------- End Form ------------------------------------------*/ ?>
	</div>
</div>	
<?php get_footer(); ?>