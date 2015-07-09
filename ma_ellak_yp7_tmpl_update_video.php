<?php
/*
Template Name: Video - Update
*/

	if (! is_user_logged_in()) // Μόνο εγγεγραμμένοι χρήστες μπορούν να είναι εδώ.
		header('Location: '.URL.''); 

	get_header();
	$cur_user = wp_get_current_user();
	if(strpos($_SERVER['HTTP_REFERER'], '?id')==false)	$UrlReferrer = $_SERVER['HTTP_REFERER'];
	
	$success = false;
	$ma_message = '';

	if (!isset($_GET['id'])){
		$ma_message='<p class="error">TO BINTEO ΠΟΥ ΠΡΟΣΠΑΘΕΙΤΕ ΝΑ ΕΠΕΞΕΡΓΑΣΤΕΙΤΕ ΔΕΝ ΥΠΑΡΧΕΙ.</p>';
		echo $ma_message;	
	}else{
		$video_id= sanitize_text_field($_GET['id']);
		$video_data = get_post($video_id);
		if (count($video_data)==0){
			$ma_message='<p class="error">TO BINTEO ΠΟΥ ΠΡΟΣΠΑΘΕΙΤΕ ΝΑ ΕΠΕΞΕΡΓΑΣΤΕΙΤΕ ΔΕΝ ΥΠΑΡΧΕΙ.</p>';
			echo $ma_message;
		}else{
			if(isset($_POST['publish']) && isset($_POST['post_nonce_field']) 
					&& wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {
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
				
				$pub_status = 'draft';
				if(isset($_POST['_ma_video_status'])) $pub_status = 'publish';
				$video = array(
					'ID'			=> $video_id,
					'post_title'	=> $title,
					'post_content'	=> $description,
					'post_status'	=> $pub_status,	// publish, preview, future, etc.
					'post_type'		=> 'video',
					'post_excerpt'	=> $excerpt,
					'post_author'	=> $author,
					'tax_input'		=> $tax,
					'post_excerpt'	=> ''
				);

				// Καταχωρούμε το Βίντεο
				$video_id = wp_update_post($video);
				if($video_id){
					// Αποθηκεύουμε τα post meta
					ma_ellak_video_save_details($video_id);
					
					// Ενημέρωσε τους Διαχειριστές της ΜΑ -----------------------------------
					$unit_id = get_post_meta($video_id, '_ma_ellak_belongs_to_unit', true);
					if($unit_id != 0){
						$mail_message = 'Καταχωρήθηκε Νέο Video - Επεξεργασια,\r\n\r\n';
						$mail_message .= 'Αφορά το Video '.get_the_title($video_id).' ('.get_permalink($video_id).').\r\n\r\n';
						$mail_message .= 'Επεξεργαστείτε το Video '.get_permalink(get_option_tree('ma_ellak_update_video'))."?id=".$video_id.' \r\n\r\n';
						$mail_message .= 'Διαχείριση Δικτυακής Πύλης Μονάδων Αριστείας ΕΛ/ΛΑΚ \r\n\r\n';
						$admin_users = get_users(array('meta_key' => '_ma_ellak_admin_unit', 'meta_value' =>$unit_id ));
						foreach ($admin_users as $user) {
							wp_mail( $user->user_email, 'Μονάδες Αριστείας ΕΛ/ΛΑΚ - Καταχώριση Νέου Video - Επεξεργασια', $mail_message );
							//echo $user->user_email.' => '.$mail_message;
						}
					}
					$ma_message = '<p class="message">H καταχώρησή σας ήταν επιτυχής.</p>';
					$ma_message .='Μπορείτε να γυρίσετε στην σελίδα που ήσασταν πατώντας <a href='.$_POST['pagerefferer'].'>εδώ</a>';
						
					$success = true;
				} else
					$ma_message = '<p class="error">Παρουσιάστηκε πρόβλημα και η καταχώρηση δεν ήταν επιτυχής.</p>';
			}//if isset
		
?>


<div class="postWrapper" id="post-<?php the_ID(); ?>">
	<?php while ( have_posts() ) : the_post(); ?>
	<?php endwhile; ?>
	<div class="post">
		<?php /*---------------------- Form ------------------------------------------*/ ?>
		<div id="ma-message"><?php echo($ma_message); ?> </div>
		<?php if($success){ } else {
			$video_metadata=get_post_meta($video_id);
			$video_main_data = get_post($video_id);
			$title=$video_data->post_title;
			$description=$video_data->post_content;
			$show_date=$video_metadata['_ma_video_date'][0];
			$duration=$video_metadata['_ma_video_duration'][0];
			$duration_parts=explode(':', $duration);
			$duration_hours=$duration_parts[0];
			$duration_minutes=$duration_parts[1];
			$duration_seconds=$duration_parts[2];
			$url=$video_metadata['_ma_video_url'][0];
			$know=$video_metadata['_ma_video_know'][0];
			$video_tags =wp_get_post_terms($video_id, 'post_tag');
			$video_thema =wp_get_post_terms($video_id, 'thema');
			$video_event =$video_metadata['_ma_video_events_stream'][0];
		?>
			<form action="<?php echo esc_url( get_permalink( get_the_ID() ) )."?id=".$video_id; ?>" method="post" id="post">
				<div class="control-group">
					<label for="title" ><?php _e('ΤΙΤΛΟΣ βίντεο (*)', 'ma-ellak'); ?></label>
					<div class="controls">
						<input type="text" name="title" id="title" class="input-block-level input required" value="<?php if(isset($title)) echo $title;?>" class="required" />				
                    </div>
				</div>
				<div class="control-group">
					<label for="description"><?php _e('Περιγραφή βίντεο', 'ma-ellak'); ?></label>
				<?php
					if(isset($description)) $content = $description;
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
									<input class="cmb_text_small cmb_datepicker " name="_ma_video_date" id="_ma_video_date" value="<?php if(isset($show_date)) echo $show_date;?>" type="text-date" width="100" />
								</div>
						</div>
					</div><!-- span6 -->
					<div class="span6">
						<div class="control-group">
							<label for="_ma_video_duration"><?php _e('Χρονική διάρκεια', 'ma-ellak'); ?></label>
							<input class="cmb_text_tiny" maxlength="2" name="_ma_video_duration_hours" id="_ma_video_duration_hours" placeholder="HH" value="<?php if(isset($duration_hours)) echo $duration_hours;?>" size=2/>:
							<input class="cmb_text_tiny" maxlength="2" name="_ma_video_duration_minutes" id="_ma_video_duration_minutes"  placeholder="MM" value="<?php if(isset($duration_minutes)) echo $duration_minutes;?>" size=2/>:
							<input class="cmb_text_tiny" maxlength="2" name="_ma_video_duration_seconds" id="_ma_video_duration_seconds" placeholder="SS" value="<?php if(isset($duration_seconds)) echo $duration_seconds;?>" size=2 />
							<br><span id=result></span><br><span id=result_m></span><br><span id=result_s></span>
						</div>
					</div>
				</div>
				<div class="control-group">
					<label for="_ma_video_url"><?php _e('Εξωτερικός σύνδεσμος βίντεο (*)', 'ma-ellak'); ?></label>
					<div class="controls ">
						<input type="text" name="_ma_video_url" id="_ma_video_url"  class="input-block-level" value="<?php if(isset($url)) echo $url;?>"/>
					</div>
					<br><span id="result_"></span>
				</div>

				<div class="control-group">
					<div class="controls">
						<label  class="checkbox inline" for="_ma_video_know">
						<input type="checkbox" name="_ma_video_know" id="_ma_video_know"
						<?php
							if ($know=='on')
								echo "checked";
						?>
						/>
						<span class="meta"><?php _e('Έχω γνώση του περιεχομένου που αναρτώ (*)', 'ma-ellak'); ?></span>
						</label>
					</div>
				</div>
				<div class="row-fluid"></div>
				<div class="control-group">
					<label for="cat"><?php _e('Θεματικές κατηγορίες', 'ma-ellak'); ?></label>
					<?php
						$i=0;
						foreach ($video_thema as $term){
							$arrayTerms[$i]= $term->term_id;
							$i++;
						}
						echo ma_ellak_add_thema_term_chosebox( 'thema-select', true, $arrayTerms);
					?>
				</div>
				<div class="control-group">
					<label for=""><?php _e('Ετικέτες', 'ma-ellak'); ?></label>
					<?php 
						$i=0;
						foreach ($video_tags as $term){
							$arrayTermsTags[$i]= $term->slug;
							$i++;
						}
						$tagz = get_taxonomy('post_tag');
						echo ma_ellak_add_term_chosebox( $tagz, 'tag-select',false,$arrayTermsTags);
					?>
					<a href="#" id="addnewtags" style="font-size:90%; font-style:italics;"><?php _e('Προσθέστε δικές σας Ετικέτες αν δεν εντοπίστηκαν παραπάνω.', 'ma-ellak'); ?></a>
					<input type="text" name="selftags" style="display:none;" id="selftags" class="form-control input-block-level" value="<?php if(isset($_POST['selftags'])) echo $_POST['selftags'];?>" placeholder="<?php _e('Χωρίστε με κόμα (,) τις νέες ετικέτες', 'ma-ellak'); ?>" />
					
				</div>
				<div class="control-group">
					<label for=""><?php _e('Σχετική Εκδήλωση', 'ma-ellak'); ?></label>
					<?php 
						if($video_event)
							ma_ellak_render_events($video_event);
						else
							ma_ellak_render_events(0);
					?>	
					<?php 
					echo"<br/>";
					echo __('Αν το video αποτελεί μέρος μίας εκδήλωσης των Μονάδων Αριστείας, επιλέξτε την εκδήλωση', 'ma-ellak');?>						
					
				</div>
				<div class="control-group">
						<div class="controls">
							<label  class="checkbox inline" for="_ma_video_status">
							<input type="checkbox" name="_ma_video_status" id="_ma_video_status" 
							<?php if(isset($video_main_data->post_status) && $video_main_data->post_status=='publish') echo "checked='checked'";?>
							/>
							<span class="meta"><?php _e('Να δημοσιευτεί;', 'ma-ellak');  ?></span>
							</label>
						</div>
					</div>

                <button id="publish" name="publish" class="btn btn-primary btn-block"><?php _e('Υποβολή', 'ma-ellak'); ?></button>
				<input type="hidden" id="user" name="user" value="<?php echo $cur_user->ID; ?>" />
				<input type="hidden" id="admin" name="admin" value="0" />
				<input type="hidden" id="pagerefferer" name="pagerefferer" value="<?php echo $UrlReferrer;?>"/>
				

				<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
			</form>
		<?php }
		}//else if id exists
		}//else if the user defines id
		?>
		<?php /*---------------------- End Form ------------------------------------------*/ ?>
	</div>
</div>	
<?php get_footer(); ?>