<?php
/*
Template Name: Characteristic - Add
*/
	$anon = ot_get_option('ma_ellak_anonymous_characteristic'); 
	
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
	
	$software_post;
	$software_id = 0;
	if(isset($_GET['sid']) and $_GET['sid'] !=''){
		$software_post = get_post(intval($_GET['sid']));
		if(!empty($software_post) and 'software' == $software_post->post_type) 
			$software_id =intval($_GET['sid']);
	}

	if(isset($_POST['ma_ellak_characteristic_submit']) &&isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce') && $software_id != 0) {
		
		$title = sanitize_text_field($_POST['ctitle']);
		$description = $_POST['cdescription']; 
		$author =  sanitize_text_field($_POST['cuser']); 

		$characteristic = array(
			'post_title'	=> $title,
			'post_content'	=> $description,		
			'post_status'	=> 'draft', 	// publish, preview, future, etc.
			'post_type'		=> 'characteristic', 	
			'post_author'	=> $author 
		);
		
		$characteristic_id = wp_insert_post($characteristic);
		
		if($characteristic_id){
			ma_ellak_characteristic_save_details($characteristic_id);
			
			$unit_id =  ma_ellak_get_unit_id();
			if( $unit_id != 0)
				update_post_meta( $software_id, '_ma_ellak_belongs_to_unit',$unit_id );
				
			// Ενημέρωσε τους Διαχειριστές της ΜΑ -----------------------------------
			$unit_id = get_post_meta($software_id, '_ma_ellak_belongs_to_unit', true);
			if($unit_id != 0){
				$mail_message = 'Καταχωρήθηκε Νέο Γνώρισμα,\r\n\r\n';
				$mail_message .= 'Αφορά το Λογισμικό '.get_the_title($software_id).' ( '.get_permalink($software_id).' ).\r\n\r\n';
				$mail_message .= 'Επεξεργαστείτε το Γνώρισμα '.get_permalink(get_option_tree('ma_ellak_list_characteristic_unapproved'))."?sid=".$software_id.' \r\n\r\n';
				$mail_message .= 'Διαχείριση Δικτυακής Πύλης Μονάδων Αριστείας ΕΛ/ΛΑΚ \r\n\r\n';
				$admin_users = get_users(array('meta_key' => '_ma_ellak_admin_unit', 'meta_value' =>$unit_id )); 
				foreach ($admin_users as $user) {
					wp_mail( $user->user_email, 'Μονάδες Αριστείας ΕΛ/ΛΑΚ - Καταχώριση Νέου Γνωρίσματος', $mail_message );
					//echo $user->user_email.' => '.$mail_message;
				}
			}
			//-----------------------------------------------------------------------
			
			$ma_message = '<p class="message">H καταχώρησή του Γνωρίσματος/Λειτουργικού Χαρακτηριστικού ήταν επιτυχής. Θα δημοσιευθεί μόλις εγκριθεί απο τον Διαχειριστή.</p>';
			$success = true;

		} else {
			$ma_message = '<p class="error">Παρουσιάστηκε πρόβλημα και η καταχώρηση δεν ήταν επιτυχής.</p>';
		}
	} 
	
?>
<?php get_header(); 

if($software_id != 0){
?>

	<div class="row-fluid filters">
		<div class="span6">
			<p><a href="<?php echo get_permalink($software_id)?>"><?php echo __('ΠΙΣΩ ΣΤΟ ΛΟΓΙΣΜΙΚΟ','ma-ellak');?> </a></p>
		</div>
   	</div>  
	
   	<div class="row-fluid event">
		<div class="cols">
			<div class="span12">
				  <h3><a href="<?php echo get_permalink($software_id); ?>" rel="bookmark" title="<?php echo get_the_title($software_id);?>" class="btn btn-large btn-link">
					<?php echo get_the_title($software_id); ?></a></h3>
			</div>
		</div>
	</div>
	
   	 <div class="row-fluid event">
		<?php /*---------------------- Form ------------------------------------------*/ ?>
		<div id="ma-message"><?php echo($ma_message); ?> </div>
		<?php if($success){ } else { 
			$url = get_permalink(get_option_tree('ma_ellak_submit_characteristic'));
			$url .="?sid=".$software_id;
			?>
		<div class="yamm-content events" ">
            <div class="row-fluid">
        
				<form action="<?php echo $url; ?>" method="post" id="ma_ellak_characteristic_submit_form" enctype="multipart/form-data" class="form-horizontal span12">
					<fieldset class="form-vertical span8 offset2">
					<div class="control-group">
						<label class="control-label span12" for="ctitle"><?php _e('Τίτλος', 'ma-ellak'); ?> (*)</label>
						<div class="controls">
						<input type="text" name="ctitle" id="ctitle" class="form-control input-block-level required" value="<?php if(isset($_POST['ctitle'])) echo $_POST['ctitle'];?>"  />
						</div>
					</div>
					
					<div class="control-group">
						<label for="cdescription"><?php _e('Πλήρης Περιγραφή τους Γνωρίσματος/Λειτουργικού Χαρακτηριστικού', 'ma-ellak'); ?>(*)</label>
						<?php 	
							echo"<br/>";
							if(isset($_POST['cdescription'])) $content = $_POST['cdescription'];	
							wp_editor( $content, 'cdescription');
						?>
					</div>
					
					<div class="control-group">
						<label class="control-label span12" for="_ma_characteristic_type"><?php _e('Τύπος', 'ma-ellak'); ?> (*)</label>
						<div class="controls">
							<select class="_ma_characteristic_type" name="_ma_characteristic_type">
								<option value=""><?php _e('Επιλέξτε', 'ma-ellak'); ?></option>
								<option value="gnorisma"><?php _e('Λειτουργικό Γνώρισμα', 'ma-ellak'); ?></option>
								<option value="characteristic"><?php _e('Χαρακτηριστικό', 'ma-ellak'); ?></option>
							</select>
						</div>
					</div>
					
					<input type="hidden" id="software_id" name="software_id" value="<?php echo $software_id; ?>" />
					<input type="hidden" id="cuser" name="cuser" value="<?php echo $user_id ; ?>" />
					<div class="control-group">
						<label class="control-label span12" for="ma_ellak_characteristic_submit"></label>
						<div class="controls">
							<button type="submit" id="ma_ellak_characteristic_submit" name="ma_ellak_characteristic_submit" class="btn btn-primary btn-block"><?php _e('ΥΠΟΒΟΛΗ', 'ma-ellak');?></button>
						</div>
					</div>
					<span class="small"><strong>
					<?php _e('(*) Υποχρεωτικό Πεδίο','ma-ellak');?>
					</strong></span>
					<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
					</fieldset>
				</form>
			</div>
		<?php } /*---------------------- End Form ------------------------------------------*/ ?>
		</div>
	</div>	
<?php } else {   _e('Πρέπει να επιλέξετε Λογισμικό για να καταχωρίσετε Λειτουργικό Χαρακτηριστικό/Γνώρισμα','ma-ellak');  }

get_footer(); ?>