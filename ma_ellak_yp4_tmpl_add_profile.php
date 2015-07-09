<?php
/*
Template Name: Profile - Add
*/

	 if (! is_user_logged_in()) // Μόνο εγγεγραμμένοι χρήστες μπορούν να είναι εδώ.
		header('Location: '.URL.''); 
	
	$cur_user = wp_get_current_user();
	$success = false;
	$ma_message = '';
	if(isset($_POST['publish']) &&isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {
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
			'package' => implode(',', $_POST['package-select']),
			'jobtype' => implode(',', $_POST['jobtype-select']),
			'type' => implode(',', $_POST['type-select']),
		);
		$profile = array(
			'post_title'	=> $title,
			'post_content'	=> $description,
			'tax_input'		=> $tax, 		
			'post_status'	=> 'draft', 	// publish, preview, future, etc.
			'post_type'		=> 'profile', 	
			'post_author'	=> $author 
		);
		
		// Καταχωρούμε το Λογισμικό
		$profile_id = wp_insert_post($profile);

		if($profile_id){
			$unit_id =  ma_ellak_get_unit_id();
			if( $unit_id != 0)
				update_post_meta( $profile_id, '_ma_ellak_belongs_to_unit',$unit_id );
			
			ma_ellak_profile_save_details($profile_id);
			
			global $ma_prefix ;
			if ($_FILES) {
				foreach ($_FILES as $file => $array) {
					if(!empty($file))
						insert_attachment($file, $profile_id, $ma_prefix . 'profile_logo');
				}
			};
			
			$ma_message = '<p class="message">H καταχώρησή Προφίλ ήταν επιτυχής.</p>';
			$success = true;
		} else {
			$ma_message = '<p class="error">Παρουσιάστηκε πρόβλημα και η καταχώρησή Δεν ήταν επιτυχής.</p>';
		}
	} 
?>
<?php get_header(); ?>

<div class="postWrapper" id="post-<?php the_ID(); ?>">
	<?php while ( have_posts() ) : the_post(); ?>
	<?php endwhile; ?>
	<div class="post">
		<?php /*---------------------- Form ------------------------------------------*/ ?>
		<div id="ma-message"><?php _e($ma_message, 'ma-ellak'); ?> </div>
		<?php if($success){ } else {
   	 		$url = get_permalink(get_option_tree('ma_ellak_submit_profile'));
		?>
		<form action="<?php echo $url; ?>" method="post" id="ma_ellak_profile_submit_form" enctype="multipart/form-data">
				<div class="row-fluid">
					<div class="cols">
						<div class="span2 characteristic-sidebar software-sidebar">
							<img src="http://localhost/BestPractices/maellak/wp-content/themes/ma_ellak/images/profile.jpg" alt="profile" width="150" height="150">
							<br/>
							<div class="control-group">
								<label for="logo"><?php _e('Φωτογραφία', 'ma-ellak'); ?></label>
								<input type="file" name="datafile" size="40">
							</div>
							<div class="control-group">
								<label for="username"><?php _e('Όνομα χρήστη', 'ma-ellak'); ?></label>
								<?php global $current_user,$user_login;  ?>
								<p><?php echo $current_user->user_login;?>
								<input type="hidden" name="username" id="username" class="input-block-level input required" value="<?php echo $current_user->user_login;?>"/>
							</div>
						</div><!-- span5 characteristic-sidebar software-sidebar -->
						
						<div class="span5 col side-right">
							<div class="control-group">
								<label for="ctitle"><?php _e('Ονοματεπώνυμο (*)', 'ma-ellak'); ?></label>
								<div class="controls">
									<input type="text" name="ctitle" id="ctitle" class="input-block-level input required" value="<?php if(isset($_POST['ctitle'])) echo $_POST['ctitle'];?>" class="required" />
								</div>
							</div>
							<div class="control-group">
								<label for="property"><?php _e('Ιδιότητα (*)', 'ma-ellak'); ?></label>
								<input type="text" name="property" id="property" class="input-block-level input required" value="<?php if(isset($_POST['property'])) echo $_POST['property'];?>" class="required" />
							</div>
							<div class="control-group">
								<label for="location"><?php _e('Περιοχή δραστηριότητας (*)', 'ma-ellak'); ?></label>
								<input type="text" name="location" id="location" class="input-block-level input required" value="<?php if(isset($_POST['location'])) echo $_POST['location'];?>" class="required" />
							</div>
						</div><!-- span5 -->
						<div class="span5 col side-right">
							<div class="control-group">
								<label for="email"><?php _e('E-mail επικοινωνίας (*)', 'ma-ellak'); ?></label>
								<input type="text" name="email" id="email" class="input-block-level input required email" value="<?php if(isset($_POST['email'])) echo $_POST['email'];?>" class="required"/>
							</div>
							<div class="control-group">
								<label for="url"><?php _e('Προσωπικός ιστοχώρος', 'ma-ellak'); ?></label>
								<input type="text" name="url" id="url" class="input-block-level url input " value="<?php if(isset($_POST['url'])) echo $_POST['url'];?>"/>
							</div>
							<div class="control-group">
								<label for="phone"><?php _e('Τηλέφωνο επικοινωνίας (*)', 'ma-ellak'); ?></label>
								<input type="text" name="phone" id="phone" class="input-block-level input required" value="<?php if(isset($_POST['phone'])) echo $_POST['phone'];?>"/>
							</div>
							
					   </div><!-- span5 -->
					</div><!-- cols -->
										
				</div><!--row-fluid  -->
					
					
					
					
					<!-- ΣΤΟΙΧΕΙΑ ΚΟΙΝΩΝΙΚΗΣ ΔΙΚΤΥΩΣΗΣ-->
					<div class="row-fluid back-gray ">
					 <div style="padding-left:15px;">
						<h3>Social</h3>
						<p>Δηλώστε τα στοιχεία σας στα κοινωνικά δίκτυα</p>
						</div>
					</div>
					<div class="row-fluid back-gray " >
						<?php
						global $social_fields;
						foreach($social_fields as $field){
							if($field['type'] != 'text' and $field['type'] != 'textarea_small' and $field['type'] != 'textarea' and $field['type'] != 'select') continue;
							if($field['type'] == 'text'){
								?>
									<div class="span3" style="padding-left:15px;">
										<div class="control-group">
											<label for="<?php echo $field['id']; ?>"><?php echo $field['name'] ; ?></label>
											<div class="controls">
											<input type="text" placeholder="Προσθέσετε το όνομα που χρησιμοποιείτε στο <?php echo $field['name']; ?>" name="<?php echo $field['id']; ?>" id="<?php echo $field['id']; ?>" class="form-control input-block-level" value="<?php if(isset($_POST[$field['id']])) echo $_POST[$field['id']];?>"  />
											<span class="help-block">(π.χ. cocacola)</span>
											</div>
										</div>
									</div>
								<?php
							}
						}
						?>
					</div>
					<!--ΤΕΛΟΣ ΣΤΟΙΧΕΙΩΝ ΚΟΙΝΩΝΙΚΗΣ ΔΙΚΤΥΩΣΗΣ-->
					<div class="control-group">
								<label for="tags"><?php _e('Λέξεις Κλειδιά (Skills)', 'ma-ellak'); ?></label>
								<?php 
									$tagz = get_taxonomy('post_tag'); 
									echo ma_ellak_add_term_chosebox( $tagz, 'tag-select', false );
								?>
								<a href="#" id="addnewtags" style="font-size:90%; font-style:italics;"><?php _e('Προσθέστε δικές σας Ετικέτες (skills) αν δεν εντοπίστηκαν παραπάνω.', 'ma-ellak'); ?></a>
								<input type="text" name="selftags" style="" id="selftags" class="form-control input-block-level" value="<?php if(isset($_POST['selftags'])) echo $_POST['selftags'];?>" placeholder="<?php _e('Χωρίστε με κόμμα (,) τις νέες ετικέτες', 'ma-ellak'); ?>" />
					</div>
					<div class="row-fluid" ></div>
					
					<!--ΑΡΧΗ ΤΩΝ ΓΕΝΙΚΩΝ ΣΤΟΙΧΕΙΩΝ ΤΟΥ ΠΡΟΦΙΛ-->
				
					<div class="control-group">
						<label for="cdescription"><?php _e('Σύντομο βιογραφικό', 'ma-ellak'); ?></label>
						<?php
							if(isset($_POST['cdescription'])) $content = $_POST['cdescription'];	
							$settings = array( 'media_buttons' => false, 'textarea_rows'=>10 );
							wp_editor( $content, 'cdescription', $settings);
						?>
					</div>
					

					<!--ΤΕΛΟΣ ΤΩΝ ΓΕΝΙΚΩΝ ΣΤΟΙΧΕΙΩΝ ΤΟΥ ΠΡΟΦΙΛ-->
					
				<div class="row-fluid">
					<div>
						<h3>Παρεχόμενες υπηρεσίες</h3>
						<p>Δηλώστε τις υπηρεσίες που παρέχετε.</p>
						</div>
					</div>
				<!--</div>-->
				<div class="row-fluid">
					<div class="cols">
						<div class="span6  col side-right">
						
							<!-- ΑΡΧΗ ΠΑΡΕΧΟΜΕΝΩΝ ΥΠΗΡΕΣΙΩΝ -->
								<div class="control-group">
									<label for="jobtype"><?php _e('Αντικείμενο Παρεχόμενης Υπηρεσίας', 'ma-ellak'); ?></label>
									<?php 	
										$type = get_taxonomy('jobtype'); 
										echo ma_ellak_add_term_chosebox( $type, 'jobtype-select', true);
									?>
								</div>
								<div class="control-group">
									<label for="package"><?php _e('Πακέτα Λογισμικού', 'ma-ellak'); ?></label>
									<?php 
										$package = get_taxonomy('package'); 
										echo ma_ellak_add_term_chosebox( $package, 'package-select', true);
									?>
								</div>

								<div class="control-group">
									<label for="type"><?php _e('Κατηγορία Λογισμικού', 'ma-ellak'); ?></label>
									<?php 	
										$type = get_taxonomy('type');
										echo ma_ellak_add_term_chosebox( $type, 'type-select', true);
									?>
								</div>						
						</div>
						<div class="span6 characteristic-sidebar software-sidebar">
							<!--SKILLS-->
							
							<div class="control-group">
								<label for="_ma_hourly_rate">Κοστος Ανθρωποωρας</label>
								<div class="controls">
									<input type="text" name="_ma_hourly_rate" id="_ma_hourly_rate" class="form-control input-block-level" value="">
								</div>
							</div>
							<div class="control-group">
									<label for="_ma_profile_type">Ειδος παρεχομενης υπηρεσιας </label>
									<div class="controls">
										<select class="required" name="_ma_profile_type" id="_ma_profile_type" >
													<option value="">Επιλέξτε</option>
													<option value="professional">Εγγυημένη</option>
													<option value="volunteer">Εθελοντική</option>
											</select>
									</div>
								</div>
							<!--END OF SKILLS-->
						</div><!-- class="span6 characteristic-sidebar software-sidebar" -->
					</div><!-- cols -->
				</div><!-- row-fluid -->
				<div class="row-fluid"></div>
				
					<div class="control-group">
						<label for="cdescription"><?php _e('Περιγραφή παρεχόμενης υπηρεσίας', 'ma-ellak'); ?></label>
						<?php
							if(isset($_POST['_ma_service_desc'])) $content = $_POST['_ma_service_desc'];	
							$settings = array( 'media_buttons' => false, 'textarea_rows'=>10 );
							wp_editor( $content, '_ma_service_desc', $settings);
						?>
					</div>
					<!--ΤΕΛΟΣ ΠΑΡΕΧΟΜΕΝΩΝ ΥΠΗΡΕΣΙΩΝ-->

					<!------------EXPERIENCE------------->
					<div id="meta_inner"></div>
					<span class="add btn btn-info btn-xs"><?php echo __('ΠΡΟΣΘΗΚΗ ΕΜΠΕΙΡΙΑΣ','ma-ellak'); ?></span>
					<input type="hidden" name="experiencecounter" id="experiencecounter" value="0"/>
	   				<span id="here"></span>
					<!--------------END OF EXPERIENCE----->

					<input type="hidden" id="cuser" name="cuser" value="<?php echo $cur_user->ID; ?>" />
					<div class="control-group">
						<label for="publish"></label>
						<div class="controls">
							<button type="submit" id="publish" name="publish" class="btn btn-primary btn-block"><?php _e('ΠΡΟΣΘΗΚΗ ΠΡΟΦΙΛ', 'ma-ellak');?></button>
						</div>
					</div>
					<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
		</form>
	</div>
		<?php } /*---------------------- End Form ------------------------------------------*/ ?>
</div>
<?php get_footer(); ?>