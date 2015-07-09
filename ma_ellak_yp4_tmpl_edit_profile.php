<?php
/*
Template Name: Profile - Edit
*/
	if (! is_user_logged_in()) // Μόνο εγγεγραμμένοι χρήστες μπορούν να είναι εδώ.
		header('Location: '.URL.''); 
	get_header();

	$profile_id = 0;
	if(isset($_GET['pid']) and $_GET['pid'] !=''){
		$profile_post = get_post(intval($_GET['pid']));
		$profile_post_metadata=get_post_meta($_GET['pid']);
		if(!empty($profile_post) and 'profile' == $profile_post->post_type) 
			$profile_id =intval($_GET['pid']);
	}

	$success = false;
	$ma_message = '';
	
	$url = get_permalink(get_option_tree('ma_ellak_edit_profile'));
	$url .="?pid=".$profile_id;
	
	$success = false;
	$ma_message = '';
	global $ma_prefix;

	
if(!ma_ellak_user_can_edit_post($profile_post)){
	_e('Δεν έχετε δικαίωμα Επεξεργασίας του Προφίλ','ma-ellak'); 
}else if($profile_id != 0){
	$current_logo = get_post_meta($profile_post->ID, $ma_prefix . 'profile_logo', true);
	if(isset($_POST['publish']) &&isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {

		$title = sanitize_text_field($_POST['ctitle']);
		$description = $_POST['cdescription']; 
		$status =  sanitize_text_field($_POST['gstatus']);

		$tag_list = implode(',', $_POST['tag-select']);
		if(isset($_POST['selftags'])){
			$tag_list .= ','.sanitize_text_field($_POST['selftags']);
		}
		
		// Ορίζουμε τις κατηγορίες/ταξονομίες
		$tax1=$tax2=$tax3=$tax4=array();
		$tax1=array('post_tag'=>$tag_list);
		if (isset($_POST['package-select']))
			$tax2=array('package' => implode(',', $_POST['package-select']));
		if (isset($_POST['jobtype-select']))
			$tax3=array('jobtype' => implode(',', $_POST['jobtype-select']));
		if (isset($_POST['type-select']))
			$tax4=array('type' => implode(',', $_POST['type-select']));
		$tax=array_merge($tax1, $tax2, $tax3, $tax4);

		$profile = array(
			'ID'			=> $profile_id ,
			'post_title'	=> $title,
			'post_content'	=> $description,
			'tax_input'		=> $tax,
			'post_status'	=> $status, 	// publish, preview, future, etc.
		);

		// Καταχωρούμε το Λογισμικό
		$profile_id = wp_update_post($profile);
		if($profile_id){		
			ma_ellak_profile_save_details($profile_id);
			
			global $ma_prefix ;
			if ($_FILES and isset($_POST['replacelogo']) and $_POST['replacelogo'] == 'yes' and $current_logo != '' and !empty($current_logo )) {
				foreach ($_FILES as $file => $array) {
					if(!empty($file))
						insert_attachment($file, $profile_id, $ma_prefix . 'profile_logo');
				}
			};
			
			if( $current_logo == '' or empty($current_logo ) and $_FILES ){
				foreach ($_FILES as $file => $array) {
					if(!empty($file))
						insert_attachment($file, $profile_id, $ma_prefix . 'profile_logo');
				}
			}
			
			$ma_message = '<p class="message">H επεξεργασία Προφίλ ήταν επιτυχής.</p>';
			$success = true;
		} else {
			$ma_message = '<p class="error">Παρουσιάστηκε πρόβλημα και η επεξεργασία δεν ήταν επιτυχής.</p>';
		}
	}
	$gstatus = $profile_post->post_status;
?>
<?php get_header(); ?>
<div class="row-fluid filters">
		<div class="span12">
			<p><a href="<?php echo get_permalink($profile_id)?>">ΠΙΣΩ ΣΤO ΠΡΟΦΙΛ</a></p>
		</div>
	</div>
	<div class="postWrapper" id="post-<?php the_ID(); ?>">
	<div class="post">
		<?php /*---------------------- Form ------------------------------------------*/ ?>
		
		<?php if($success){?>
			
			<div id="ma-message"><?php echo($ma_message); ?> </div>
			</div></div>
		<?php } else { 

		?>
				<form action="<?php echo $url; ?>" method="post" id="ma_ellak_profile_submit_form" enctype="multipart/form-data">
					
						<div class="row-fluid">
					<div class="cols">
						<div class="span2 characteristic-sidebar software-sidebar">
							<?php if($current_logo != '' and !empty($current_logo)) { ?>
								<div class="control-group">
								
									<label for="current_logo"><?php _e('Υπάρχουσα Φωτογραφία', 'ma-ellak'); ?></label>
									<input type="checkbox" name="replacelogo" value="yes"> <?php _e('Αντικατάσταση Λογότυπου'); ?>
									<?php global $ma_prefix; ?>
									<img src="<?php echo $current_logo; ?>" width="150" height="150" />
								</div>
								<?php }else{?>
									<label for="logo"><?php _e('Φωτογραφία', 'ma-ellak'); ?></label>
									<img src="http://localhost/BestPractices/maellak/wp-content/themes/ma_ellak/images/profile.jpg" alt="profile" width="150" height="150">
							
							<?php }?>
							
							<br/>
							<div class="control-group">
								<input type="file" name="datafile" size="40">
							</div>
								<?php global $current_user,$user_login;  ?>
								<label for="username"><?php _e('Όνομα χρήστη', 'ma-ellak'); ?></label>
								 <p><?php echo $current_user->user_login;?>
								<input type="hidden" name="username" id="username" class="input-block-level input required" value="<?php echo $current_user->user_login;?>"/>
						</div><!-- span5 characteristic-sidebar software-sidebar -->
						
						<div class="span5 col side-right">
							<div class="control-group">
								<label for="ctitle"><?php _e('Ονοματεπώνυμο (*)', 'ma-ellak'); ?></label>
								<div class="controls">
									<input type="text" name="ctitle" id="ctitle" class="input-block-level input required" value="<?php if(isset($_POST['ctitle'])) echo $_POST['ctitle']; else  echo $profile_post->post_title; ?>" class="required" />
								</div>
							</div>
							<div class="control-group">
								<label for="property"><?php _e('Ιδιότητα (*)', 'ma-ellak'); ?></label>
								<input type="text" name="property" id="property" class="input-block-level input required" value="<?php if(isset($_POST['property'])) echo $_POST['property']; else if (isset($profile_post_metadata['_ma_profile_property'][0]))echo $profile_post_metadata['_ma_profile_property'][0];?>" class="required" />
							</div>
							<div class="control-group">
								<label for="location"><?php _e('Περιοχή δραστηριότητας (*)', 'ma-ellak'); ?></label>
								<input type="text" name="location" id="location" class="input-block-level input required" value="<?php if(isset($_POST['location'])) echo $_POST['location']; else if (isset($profile_post_metadata['_ma_profile_location'][0]))echo $profile_post_metadata['_ma_profile_location'][0];?>" class="required" />
							</div>
						</div><!-- span5 -->
						<div class="span5 col side-right">
							<div class="control-group">
								<label for="email"><?php _e('E-mail επικοινωνίας (*)', 'ma-ellak'); ?></label>
								<input type="text" name="email" id="email" class="input-block-level input required email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; else  if (isset($profile_post_metadata['_ma_profile_email'][0]))echo $profile_post_metadata['_ma_profile_email'][0];?>" class="required"/>
							</div>
							<div class="control-group">
								<label for="url"><?php _e('Προσωπικός ιστοχώρος', 'ma-ellak'); ?></label>
								<input type="text" name="url" id="url" class="input-block-level url input " value="<?php if(isset($_POST['url'])) echo $_POST['url']; else if (isset($profile_post_metadata['_ma_profile_url'][0]))echo $profile_post_metadata['_ma_profile_url'][0];?>"/>
							</div>
							<div class="control-group">
								<label for="phone"><?php _e('Τηλέφωνο επικοινωνίας', 'ma-ellak'); ?></label>
								<input type="text" name="phone" id="phone" class="input-block-level input required" value="<?php if(isset($_POST['phone'])) echo $_POST['phone']; else if (isset($profile_post_metadata['_ma_profile_phone'][0]))echo $profile_post_metadata['_ma_profile_phone'][0];?>"/>
							</div>
							
					   </div><!-- span5 -->
					</div><!-- cols -->
										
				</div><!--row-fluid  -->
					
				
					<!--ΤΕΛΟΣ ΤΩΝ ΓΕΝΙΚΩΝ ΣΤΟΙΧΕΙΩΝ ΤΟΥ ΠΡΟΦΙΛ-->
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
							$value = get_post_meta($profile_post->ID, $field['id'], true);
							?>
									<div class="span3" style="padding-left:15px;">
										<div class="control-group">
											<label for="<?php echo $field['id']; ?>"><?php echo $field['name'] ; ?></label>
											<div class="controls">
											<input type="text" placeholder="Προσθέσετε το όνομα που χρησιμοποιείτε στο <?php echo $field['name']; ?>" name="<?php echo $field['id']; ?>" id="<?php echo $field['id']; ?>" class="form-control input-block-level" value="<?php if(isset($_POST[$field['id']])) echo $_POST[$field['id']]; else if(isset($value)) echo $value;?>"  />
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
						<label for="cdescription"><?php _e('Σύντομο βιογραφικό', 'ma-ellak'); ?></label>
						<?php 	
							echo"<br/>";
							wp_editor( $profile_post->post_content, 'cdescription');
						?>
					</div>
			  <div class="row-fluid">
					<div>
						<h3>Παρεχόμενες υπηρεσίες</h3>
						<p>Δηλώστε τις υπηρεσίες που παρέχετε.</p>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					
					<div class="cols">
						
						<div class="span6  col side-right">
						
							<!-- ΑΡΧΗ ΠΑΡΕΧΟΜΕΝΩΝ ΥΠΗΡΕΣΙΩΝ -->
								<div class="control-group">
									<label for="jobtype"><?php _e('Αντικείμενο Παρεχόμενης Υπηρεσίας', 'ma-ellak'); ?></label>
									<?php 	
										$i=0;
										$jobtype_terms =wp_get_post_terms($profile_id, 'jobtype');
										foreach ($jobtype_terms as $term){
											$arrayTermsTags[$i]= $term->slug;
											$i++;
										}
										$jobtype_tax = get_taxonomy('jobtype');
										echo ma_ellak_add_term_chosebox( $jobtype_tax, 'jobtype-select',false,$arrayTermsTags);
									?>
								</div>
			
								<div class="control-group">
									<label for="package"><?php _e('Πακέτα Λογισμικού', 'ma-ellak'); ?></label>
									<?php 
										$terms = array();
										foreach (wp_get_post_terms($profile_id, 'package')  as $term)
											$terms[]= $term->slug;
										$package = get_taxonomy('package');
										echo ma_ellak_add_term_chosebox( $package, 'package-select', false, $terms);
									?>								
								</div>
								<div class="control-group">
									<label for="type"><?php _e('Κατηγορία Λογισμικού', 'ma-ellak'); ?></label>
									<?php 	
										$terms = array();
										foreach (wp_get_post_terms($profile_id, 'type')  as $term)
											$terms[]= $term->slug;
										$tagz = get_taxonomy('type'); 
										echo ma_ellak_add_term_chosebox( $tagz, 'type-select', false, $terms );
									?>
								</div>
					
						
						</div>
						<div class="span6 characteristic-sidebar software-sidebar">
							<!--SKILLS-->
							
							<div class="control-group">
								<label for="_ma_hourly_rate">Κοστος Ανθρωποωρας</label>
								<div class="controls">
									<input type="text" name="_ma_hourly_rate" id="_ma_hourly_rate" class="form-control input-block-level" value="<?php echo $profile_post_metadata['_ma_hourly_rate'][0];?>">
								</div>
							</div>
							<div class="control-group">
									<label for="_ma_profile_type">Ειδος παρεχομενης υπηρεσιας </label>
									<div class="controls">
										<select class="required" name="_ma_profile_type" id="_ma_profile_type" >
													<option value="">Επιλέξτε</option>
													<option value="professional" <?php if($profile_post_metadata['_ma_profile_type'][0]=='professional') echo "selected";?>>Εγγυημένη</option>
													<option value="volunteer" <?php if($profile_post_metadata['_ma_profile_type'][0]=='volunteer') echo "selected";?> >Εθελοντική</option>
											</select>
									</div>
								</div>
							<!--END OF SKILLS-->
						</div><!-- class="span6 characteristic-sidebar software-sidebar" -->
					</div><!-- cols -->
				</div><!-- row-fluid -->
					<div class="control-group">
						<label for="cdescription"><?php _e('Περιγραφή παρεχόμενης υπηρεσίας', 'ma-ellak'); ?></label>
						<?php
							if(isset($_POST['_ma_service_desc'])) $content = $_POST['_ma_service_desc'];	
							$settings = array( 'media_buttons' => false, 'textarea_rows'=>10 );
							wp_editor( $content, '_ma_service_desc', $settings);
						?>
					</div>
					
					<!--ΤΕΛΟΣ ΠΑΡΕΧΟΜΕΝΩΝ ΥΠΗΡΕΣΙΩΝ-->
				
					
					<!--SKILLS-->
					<div class="control-group">
						<label for="tags"><?php _e('Λέξεις Κλειδιά (Skills)', 'ma-ellak'); ?></label>
						<?php 
							$terms = array();
							foreach (wp_get_post_terms($profile_id, 'post_tag')  as $term)
								$terms[]= $term->slug;
							$tagz = get_taxonomy('post_tag');
							echo ma_ellak_add_term_chosebox( $tagz, 'tag-select', false, $terms );
						?>
						<a href="#" id="addnewtags" style="font-size:90%; font-style:italics;"><?php _e('Προσθέστε δικές σας Ετικέτες (skills) αν δεν εντοπίστηκαν παραπάνω.', 'ma-ellak'); ?></a>
						<input type="text" name="selftags" style="" id="selftags" class="form-control input-block-level" value="<?php if(isset($_POST['selftags'])) echo $_POST['selftags'];?>" placeholder="<?php _e('Χωρίστε με κόμμα (,) τις νέες ετικέτες', 'ma-ellak'); ?>" />
					</div>
					<!--END OF SKILLS-->

					
			
						<div id="meta_inner"></div>
						<span class="add btn btn-info btn-xs"><?php _e('Προσθήκη Εμπειρίας','ma-ellak'); ?></span>
						<?php
						$experience = get_post_meta($_GET['pid'],'_ma_ellak_profile_experience',true);
						?>
						<?php
						$c = 0;
						if($experience)
							if ( count( $experience ) >= 0 ) {
								foreach( $experience as $exp ) {									
									if ( isset( $exp['_ma_ellak_exp_title'] ) ) {
										printf( '<div class="container-fluid">
													<div class="row-fluid">
														<div class="span1"><label>Τίτλος</label></div><div class="span3"><input type="text" name="experience[%1$s][_ma_ellak_exp_title]" id="_ma_ellak_exp_title%1$s"  value="%2$s" /> </div>
														<div class="span1"><label>Φορέας</label></div><div class="span3"><input type="text" name="experience[%1$s][_ma_ellak_exp_entity]" id="_ma_ellak_exp_entity%1$s"  value="%3$s" /> </div>
														<div class="span1"><label>Url</label></div><div class="span3"> <input type="text" name="experience[%1$s][_ma_ellak_exp_url]" value="%4$s" id="_ma_ellak_exp_url%1$s" /> </div>
													</div>
													<div class="row-fluid">
														<div class="span1"><label>Περιγραφή</label></div><div class="span3"> <textarea name="experience[%1$s][_ma_ellak_exp_desc]" id="_ma_ellak_exp_desc%1$s" rows="2" cols="5">%5$s</textarea> </div>
														<div class="span1"><label>Από</label></div><div class="span3"> <input type="text-date" name="experience[%1$s][_ma_ellak_exp_from]" id="_ma_ellak_exp_from%1$s"  value="%6$s" /> </div>
														<div class="span1"><label>Έως</label></div><div class="span3"> <input type="text-date" name="experience[%1$s][_ma_ellak_exp_to]" id="_ma_ellak_exp_to%1$s"  value="%7$s" />  </div>
													</div>
													<div class="row-fluid"><span class="remove btn btn-danger btn-xs">%8$s</span></div>
												</div>', $c, $exp['_ma_ellak_exp_title'], $exp['_ma_ellak_exp_entity'], $exp['_ma_ellak_exp_url'], $exp['_ma_ellak_exp_desc'], $exp['_ma_ellak_exp_from'],$exp['_ma_ellak_exp_to'],"<span class=remove btn btn-danger btn-xs>Αφαίρεση</span>" );
										$c = $c +1;
									}
								}
							}
						?>
						<input type="hidden" name="experiencecounter" id="experiencecounter" value="<?php echo $c;?>"/>
		   				<span id="here"></span>
						<br/><br/>
					<?php	if(ma_ellak_user_is_post_admin($profile_post )){ ?>
					<div class="admineditor back-gray">
							<div class="control-group">
								<label for="gstatus"><?php _e('Κατάσταση', 'ma-ellak'); ?></label>
								<div class="controls">
									<select class="gstatus" name="gstatus">
										<option value=""><?php _e('Επιλέξτε', 'ma-ellak'); ?></option>
										<option value="draft" <?php if($gstatus == 'draft') echo 'selected="selected"'; ?>><?php _e('Προσχέδιο', 'ma-ellak'); ?></option>
										<option value="publish" <?php if($gstatus == 'publish') echo 'selected="selected"'; ?>><?php _e('Δημοσιευμένο', 'ma-ellak'); ?></option>
									</select>
								</div>
							</div>
					</div>
			<?php	} ?>

					<div class="control-group">
						<label for="publish"></label>
						<div class="controls">
							<button type="submit" id="publish" name="publish" class="btn btn-primary btn-block"><?php _e('ΕΠΕΞΕΡΓΑΣΙΑ ΠΡΟΦΙΛ', 'ma-ellak');?></button>
						</div>
					</div>
					<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
				</form>
			</div>
		<?php //} /*---------------------- End Form ------------------------------------------*/ ?>
	</div>
	<?php }
		
	?>
<?php } else {   _e('Πρέπει να επιλέξετε Προφίλ πρώτα!','ma-ellak');  }
 get_footer(); ?>