<?php
/*
Template Name: Unit - Edit
*/

	 if (! is_user_logged_in()) // Μόνο εγγεγραμμένοι χρήστες μπορούν να είναι εδώ.
		header('Location: '.URL.''); 
	
	get_header();
	
	
	$unit_post;
	$unit_id = 0;
	
	
	if(isset($_GET['uid']) and $_GET['uid'] !=''){
		$unit_post = get_post(intval($_GET['uid']));
		if(!empty($unit_post) and 'unit' == $unit_post->post_type) 
			$unit_id =intval($_GET['uid']);
	}
	
	$success = false;
	$ma_message = '';
	
	$url = get_permalink(get_option_tree('ma_ellak_edit_unit'));
	$url .="?uid=".$unit_id;
	
	$current_logo = get_post_meta($unit_id, $ma_prefix . 'unit_logo', true);
	
	if(isset($_POST['ma_ellak_unit_submit']) &&isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {
		
		$title = sanitize_text_field($_POST['ctitle']);
		$description = $_POST['cdescription']; 
		
		$unit = array(
			'ID' => $unit_id ,
			'post_title'	=> $title,
			'post_content'	=> $description,		
		);
		
		$unit_id = wp_update_post($unit);
		
		if($unit_id){
			ma_ellak_unit_save_details($unit_id);
			global $ma_prefix ;
			if ($_FILES and isset($_POST['replacelogo']) and $_POST['replacelogo'] == 'yes' and $current_logo != '' and !empty($current_logo )) {
				foreach ($_FILES as $file => $array) {
					if(!empty($file))
						insert_attachment($file, $unit_id, $ma_prefix . 'unit_logo');
				}
			};
			
			if( $current_logo == '' or empty($current_logo ) and $_FILES ){
				foreach ($_FILES as $file => $array) {
					if(!empty($file))
						insert_attachment($file, $unit_id, $ma_prefix . 'unit_logo');
				}
			}
			$ma_message = '<p class="alert alert-info">H επεξεργασία της Μονάδας Αριστείας ήταν επιτυχής</p>';
			$success = true;

		} else {
			$ma_message = '<p class="alert error-info">Παρουσιάστηκε πρόβλημα και η επεξεργασία δεν ήταν επιτυχής.</p>';
		}
	} 
	
	$unit_post = get_post($unit_id);
?>
<?php 
if(!is_current_user_admin($unit_id)){

		_e('Δεν έχετε δικαίωμα Επεξεργασίας της Μονάδας Αριστείας.','ma-ellak');
	 
} else if($unit_id != 0) { 

?>

	<div class="row-fluid filters">
		<div class="span6">
			<p><?php _e('Επεξεργασία','ma-ellak'); ?>: <a href="<?php echo get_permalink($unit_id) ?>" rel="bookmark" title="<?php echo get_the_title($unit_id);?>" class="btn btn-large btn-link">
				<?php echo get_the_title($unit_id); ?>
			</a></p>
		</div>
   	</div>  
	
   	 <div class="row-fluid event">
		<?php /*---------------------- Form ------------------------------------------*/ ?>
		<div id="ma-message"><?php echo($ma_message); ?> </div>
		<?php if($success){ } else { } ?>
		<div class="yamm-content events">
            <div class="row-fluid">
  
				<form action="<?php echo $url; ?>" method="post" id="ma_ellak_unit_submit_form" enctype="multipart/form-data" class="form-horizontal span12">
					<fieldset class="form-vertical span8 offset2">
					<div class="control-group">
						<label class="control-label span12" for="ctitle"><?php _e('Σύντομος Τίτλος', 'ma-ellak'); ?></label>
						<div class="controls">
						<input type="text" name="ctitle" id="ctitle" class="form-control input-block-level required" value="<?php echo $unit_post->post_title; ?>"  />
						</div>
					</div>
					
					<div class="control-group">
						<label for="cdescription"><?php _e('Περιγραφή της Μονάδας Αριστείας', 'ma-ellak'); ?></label>
						<?php 	
							echo"<br/>";
							wp_editor( $unit_post->post_content, 'cdescription');
						?>
					</div>
					<?php
						global $unit_fields;
						global $ma_prefix ;
					?>
					<div class="control-group">
						<label for="logo"><?php _e('Λογότυπο', 'ma-ellak'); ?></label>
						<input type="file" name="datafile" size="40">
						<?php if($current_logo != '' and !empty($current_logo)) { ?>
							<input type="checkbox" name="replacelogo" value="yes"> <?php _e('Αντικατάσταση Λογότυπου'); ?>
						<?php }?>
						<br /><?php _e('Προτεινόμενη διάσταση'); ?>: 300 Χ 300 pixels;
					</div>
					
					<?php if($current_logo != '' and !empty($current_logo)) { ?>
						<div class="control-group">
							<label for="current_logo"><?php _e('Υπάρχον Λογότυπο', 'ma-ellak'); ?></label>
							<?php global $ma_prefix; ?>
							<img src="<?php echo $current_logo; ?>" width="300" />
						</div>
					<?php }?>
					<?php
						foreach($unit_fields as $field){
						
							if($field['type'] != 'text' and $field['type'] != 'text_medium') continue;
							if($field['id'] == $ma_prefix . 'unit_logo') continue;
							
							$data = get_post_meta($unit_id , $field['id'], true);
						?>
						
						<div class="control-group">
							<label class="control-label span12" for="<?php echo $field['id']; ?>"><?php echo $field['name'] ; ?></label>
							<div class="controls">
							<input type="text" name="<?php echo $field['id']; ?>" id="<?php echo $field['id']; ?>" class="form-control input-block-level required" value="<?php echo $data ; ?>"  />
							</div>
						</div>
						
					<?php } ?>
					<div class="control-group">
						<label class="control-label span12" for="ma_ellak_unit_submit"></label>
						<div class="controls">
							<button type="submit" id="ma_ellak_unit_submit" name="ma_ellak_unit_submit" class="btn btn-primary btn-block"><?php _e('ΕΠΕΞΕΡΓΑΣΙΑ', 'ma-ellak');?></button>
						</div>
					</div>
					<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
					</fieldset>
				</form>
			</div>
		<?php //} /*---------------------- End Form ------------------------------------------*/ ?>
		</div>
	</div>	
<?php } else {   _e('Πρέπει να επιλέξετε Μονάδα Αριστείας πρώτα!','ma-ellak');  }

get_footer(); ?>