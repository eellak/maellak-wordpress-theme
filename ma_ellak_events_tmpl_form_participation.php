<?php
/*
Template Name: Event - Participation
*/

	// if (! is_user_logged_in()) // Μόνο εγγεγραμμένοι χρήστες μπορούν να είναι εδώ.
//		header('Location: '.URL.''); 
	
	$cur_user = wp_get_current_user();
	
	$success = false;
	$ma_message = '';
	
	if(isset($_POST['ma_ellak_events_participation_submit']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {
		global $wpdb;
		$upload=0;
		if( function_exists( 'cptch_check_custom_form' ) && cptch_check_custom_form() === true ) {
		
			$name = sanitize_text_field($_POST['namez']);
			$surname = sanitize_text_field($_POST['surnamez']);
			$email = sanitize_text_field($_POST['emailz']);
			$events_id = intval($_POST['events_id']);
			$ma_position = sanitize_text_field($_POST['ma_position']);
			$ma_institute = sanitize_text_field($_POST['ma_institute']);
			$ma_phone = sanitize_text_field($_POST['ma_phone']);
			
			// Check if mail exists
			$query = "SELECT count(*) FROM ma_events_participants where events_id=$events_id and email like '$email%'";
			$user_email_already = $wpdb->get_var( $query );

			if($user_email_already != 0){
				$ma_message .= '<p class="error">Παρουσιάστηκε πρόβλημα και η καταχώριση. Το δηλωθέν email έχει ήδη καταχωρηθεί.</p>';
			} else {
			
				if(isset($_FILES["fileToUpload"]["name"])){
				$ma_bio = sanitize_text_field($_FILES["fileToUpload"]["name"]);
					if (file_exists(ABSPATH."wp-content/files/bios/" . $_FILES["fileToUpload"]["name"]))
					{
						$ma_message="Το αρχείο με όνομα ". $_FILES["fileToUpload"]["name"] . " υπάρχει ήδη. ";
						$upload=-1;
					}
					else
					{
						move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],
								ABSPATH."wp-content/files/bios/" . $_FILES["fileToUpload"]["name"]);
					}
				}
				//Collect the data
				$participation = array(
						'events_id'	=> $events_id,
						'name'	=> $name,
						'surname'	=> $surname,
						'email'		=> $email,	
						'ma_position'=>$ma_position,			
						'ma_institute'=>$ma_institute,			
						'ma_phone'=>$ma_phone,
						'ma_bio'=>$ma_bio,			
				);
				$format= array('%s','%s','%s', '%d','%s' );
				// Καταχωρούμε τη συμμετοχή 
				if($upload!=-1){
					$wpdb->insert( 'ma_events_participants', $participation );
					$wpdb->show_errors();
					$id = $wpdb->insert_id;
				}
				if($id && $upload!=-1){
					
					$ma_message = '<p class="message">H καταχώριση σας ήταν επιτυχής.</p>';
					$success = true;
					
					// Αποστολή email στον διαχειριστή/υπεύθυνο
					$email_message = 'Νέα συμμετοχή με όνομα: '.$name;
					$unit_id = get_post_meta($events_id, '_ma_ellak_belongs_to_unit', true);
					if($unit_id != 0 ){
						$mail_message = 'Νέα συμμετοχή στην Εκδήλωση - Σεμινάριο,\r\n\r\n';
						$mail_message .= 'Αφορά την εκδήλωση '.get_the_title($events_id).' ( '.get_permalink($events_id).' ).\r\n\r\n';
						$mail_message .= 'Επεξεργαστείτε την συμμετοχή '.get_permalink(get_option_tree('ma_ellak_update_event'))."?id=".$events_id.' \r\n\r\n';
						$mail_message .= 'Διαχείριση Δικτυακής Πύλης Μονάδων Αριστείας ΕΛ/ΛΑΚ \r\n\r\n';
						
						$admin_users = get_users(array('meta_key' => '_ma_ellak_admin_unit', 'meta_value' =>$unit_id ));
						foreach ($admin_users as $user) {
							wp_mail( $user->user_email, 'Μονάδες Αριστείας ΕΛ/ΛΑΚ - Νέα συμμετοχή στην Εκδήλωση - Σεμινάριο', $mail_message );
						}
					}
					// wp_mail( 'email@ma.ellak.gr', '[Λογισμικό] Νέα καταχώριση', $email_message);
				} else {
					$ma_message .= '<p class="error">Παρουσιάστηκε πρόβλημα και η καταχώριση. Δεν ήταν επιτυχής.</p>';
				}
			}
		}else 
			$ma_message = '<p class="error">Παρουσιάστηκε πρόβλημα και η καταχώριση. Δεν ήταν επιτυχής.Πρέπει να συμπληρώσετε το captcha</p>';
			
	} 

?>
<?php get_header(); 

if(isset($_GET['events_id']))
	$events_id = absint($_GET['events_id']);
else
	$events_id = absint($_POST['events_id']);

if($events_id==0) echo __('Πρέπει να επιλέξετε εκδήλωση για να δηλώσετε συμμετοχή','ma-ellak');
else{
	$currentID= sanitize_text_field($_GET['events_id'] );
	$chekcData = get_post( $currentID);
	$custom = get_post_custom($currentID);

	if(!isset($chekcData) || $chekcData->post_type!='events' || $custom['_ma_events_participate'][0]!='yes'){
		$ma_message = '<p class="error">Η ΕΚΔΗΛΩΣΗ ΠΟΥ ΠΡΟΣΠΑΘΕΙΤΕ ΝΑ ΔΗΛΩΣΕΤΕ ΣΥΜΜΕΤΟΧΗ ΔΕΝ ΥΠΑΡΧΕΙ Η ΔΕΝ ΕΧΕΙ ΕΝΕΡΓΟΠΟΙΗΜΕΝΗ ΤΗΝ ΔΙΑΔΙΚΑΣΙΑ ΕΓΓΡΑΦΗΣ.</p>';
		echo $ma_message;
	}else{
$postData =  get_post($events_id);
$custom = get_post_custom($events_id);
$event_type = $custom['_ma_events_type'][0];
$start = $custom['_ma_event_startdate_timestamp'][0]?strtotime($custom['_ma_event_startdate_timestamp'][0]):'';
$startd = date(MA_DATE_FORMAT,$start);
$endd = $custom['_ma_event_enddate_timestamp'][0]?date(MA_DATE_FORMAT,strtotime($custom['_ma_event_enddate_timestamp'][0])):'';
$event_type = $custom['_ma_events_type'][0];

?>
  
   <?php while ( have_posts() ) : the_post(); ?>
	 <div class="row-fluid filters">
          <div class="span6">
            <p><a href="<?php echo get_permalink($events_id)?>"><?php echo __('ΠΙΣΩ','ma-ellak');?>
            <?php get_event_type_label($event_type); 
						?>
            
            </a></p>
          </div>
   	</div>  
   	 <div class="row-fluid event">
		  	<div class="cols">
		  		<div class="span12">
					  <h3><a href="<?php get_permalink($events_id) ?>" rel="bookmark"  
				  	title="<?php echo get_the_title($events_id);?>" class="btn btn-large btn-link"><?php echo get_the_title($events_id); ?></a></h3>
					  <p  class="meta purple">
					  <?php get_event_type_label($event_type); 
						?>
					  <?php ma_ellak_print_unit_title($cid); ?> 
					 
					  <?php echo ma_ellak_print_thema($events_id,'thema');?>
					  <?php echo $startd; if($endd) echo"-". $endd;?></p>
					  <p  class="meta purple">
					  <?php if($place){?>
					  <?php echo __( 'ΣΤΟ', 'ma-ellak' );?>  
					  <strong class="magenta"><?php echo $place?></strong> 
					  <?php }?>
					  <?php if($address)?>
					  <strong ><?php echo $address;?></strong></p>
					  
				</div><!-- span8 text col -->
		  	</div><!-- cols -->
	  </div><!-- row-fluid event -->
	
	<?php endwhile; ?>
   	 <div class="row-fluid event">
		<?php /*---------------------- Form ------------------------------------------*/ ?>
		<div id="ma-message"><?php echo($ma_message); ?> </div>
		<?php if($success){ } else { 
		
			$url = get_permalink(get_option_tree('ma_ellak_view_event_option_id'));
			$url .="?events_id=".$events_id;
			?>
		<div class="yamm-content events">
            <div class="row-fluid">
        
			<form action="<?php echo $url; ?>" method="post" id="ma_ellak_software_submit_form" enctype="multipart/form-data" class="form-horizontal span12">
				<fieldset class="form-vertical span4 offset2">
				<div class="control-group">
					<label class="control-label span12" for="namez"><?php _e('Όνομα', 'ma-ellak'); ?> (*)</label>
					<div class="controls">
					<input type="text" name="namez" id="namez" class="form-control input-block-level required" value="<?php if(isset($_POST['namez'])) echo $_POST['namez'];?>"  />
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label span12" for="surnamez"><?php _e('Επώνυμο', 'ma-ellak'); ?> (*)</label>
					<div class="controls">
						<input type="text" name="surnamez" id="surnamez" class="form-control input-block-level required" value="<?php if(isset($_POST['surnamez'])) echo $_POST['surnamez'];?>" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label span12" for="emailz"><?php _e('Ηλεκτρονικό ταχυδρομείο', 'ma-ellak'); ?> (*)</label>
					<div class="controls">
						<input type="text" name="emailz" id="emailz" class="form-control input-block-level required email" value="<?php if(isset($_POST['emailz'])) echo $_POST['emailz'];?>"  />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label span12" for="ma_position"><?php _e('Θέση', 'ma-ellak'); ?></label>
					<div class="controls">
						<input type="text" name="ma_position" id="ma_position" class="form-control input-block-level " value="<?php if(isset($_POST['ma_position'])) echo $_POST['ma_position'];?>"  />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label span12" for="ma_institute"><?php _e('Φορέας', 'ma-ellak'); ?></label>
					<div class="controls">
						<input type="text" name="ma_institute" id="ma_institute" class="form-control input-block-level " value="<?php if(isset($_POST['ma_institute'])) echo $_POST['ma_institute'];?>"  />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label span12" for="ma_phone"><?php _e('Τηλέφωνο επικοινωνίας', 'ma-ellak'); ?></label>
					<div class="controls">
						<input type="text" name="ma_phone" id="ma_phone" class="form-control input-block-level " value="<?php if(isset($_POST['ma_phone'])) echo $_POST['ma_phone'];?>"  />
					</div>
				</div>
				<?php if($event_type=='seminar' || $event_type=='seminar1' || $event_type=='school' || $event_type=='summerschool'){?>
				<div class="control-group">
   				   	<label class="control-label span12" for="exampleInputFile"><?php echo __('Βιογραφικό.','ma-ellak');?></label>
    			  	<div class="controls">
    			  		<input type="file" name="fileToUpload" id="fileToUpload" class="required">
						<span class="help-block"><?php echo __('Εισάγετε το βιογραφικό σας σε pdf.','ma-ellak');?></span>
						<span class="help-block">Το βιογραφικό που θα υποβληθεί στην ΑΙΤΗΣΗ θα πρέπει να έχει συνταχθεί στο: <a href="https://europass.cedefop.europa.eu/editors/el/cv/compose">https://europass.cedefop.europa.eu/editors/el/cv/compose</a></span>
    			 	</div>
    			 </div>
    			 <?php }?>
				<div class="control-group">
				<?php if( function_exists( 'cptch_display_captcha_custom' ) ) { echo "<input type='hidden' name='cntctfrm_contact_action' value='true' />"; echo cptch_display_captcha_custom(); } ?>
				
				</div>
				<input type="hidden" id="events_id" name="events_id" value="<?php echo $events_id; ?>" />
				 <div class="control-group">
                          <label class="control-label span12" for="ma_ellak_events_participation_submit"></label>
                          <div class="controls">
                            <button type="submit" id="ma_ellak_events_participation_submit" name="ma_ellak_events_participation_submit" class="btn btn-primary btn-block"><?php _e('ΥΠΟΒΟΛΗ', 'ma-ellak');?></button>
                          </div>
                        </div>
				</fieldset>
				
				
				<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
			</form>
			</div>
			
		<?php } ?>
		<?php } //	if(!isset($chekcData) || $chekcData->post_type!='events' || $custom['_ma_events_participate'][0]!='yes'){
			?>
		<?php /*---------------------- End Form ------------------------------------------*/ ?>
	</div>
</div>	
<?php } //no events_id ?> 
<?php get_footer(); ?>