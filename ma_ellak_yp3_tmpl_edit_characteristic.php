<?php
/*
Template Name: Characteristic - Edit
*/

	 if (! is_user_logged_in()) // Μόνο εγγεγραμμένοι χρήστες μπορούν να είναι εδώ.
		header('Location: '.URL.''); 
	get_header();
	
	
	$gnorisma_post;
	$gnorisma_id = 0;
	if(isset($_GET['gid']) and $_GET['gid'] !=''){
		$gnorisma_post = get_post(intval($_GET['gid']));
		if(!empty($gnorisma_post) and 'characteristic' == $gnorisma_post->post_type) 
			$gnorisma_id =intval($_GET['gid']);
	}
	
	$success = false;
	$ma_message = '';
	
	$url = get_permalink(get_option_tree('ma_ellak_edit_characteristic'));
	$url .="?gid=".$gnorisma_id;
	

?>
<?php 
if(!ma_ellak_user_can_edit_post($gnorisma_post)){

		_e('Δεν έχετε δικαίωμα Επεξεργασίας του Λειτουργικού Χαρακτηριστικού/Γνωρίσματος','ma-ellak');
	 
}else if($gnorisma_id != 0){

	if(isset($_POST['ma_ellak_characteristic_submit']) &&isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {
		
		$title = sanitize_text_field($_POST['ctitle']);
		$description = $_POST['cdescription']; 
		$status =  sanitize_text_field($_POST['gstatus']);
		$allowcomments = sanitize_text_field($_POST['allowcomments']);
		
		$characteristic = array(
			'ID' => $gnorisma_id ,
			'post_title'	=> $title,
			'post_content'	=> $description,		
			'post_status'	=> $status, 	// publish, preview, future, etc.
			'comment_status' => $allowcomments,
		);
		
		$characteristic_id = wp_update_post($characteristic);
		
		if($characteristic_id){
			ma_ellak_characteristic_save_details($characteristic_id);
			$ma_message = '<p class="alert alert-info">H επεξεργασία του Γνωρίσματος/Λειτουργικού Χαρακτηριστικού ήταν επιτυχής</p>';
			$success = true;

		} else {
			$ma_message = '<p class="alert error-info">Παρουσιάστηκε πρόβλημα και η επεξεργασία δεν ήταν επιτυχής.</p>';
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
	
	$gnorisma_post = get_post(intval($_GET['gid']));

global $ma_prefix;

$software_id = get_post_meta($gnorisma_id, $ma_prefix.'for_software', true);
$type = get_post_meta($gnorisma_id, $ma_prefix.'characteristic_type', true);
$status =  get_post_meta($gnorisma_id, $ma_prefix.'stage_status', true);
$acceptance =  get_post_meta($gnorisma_id, $ma_prefix.'characteristic_acceptance', true);
$gstatus = $gnorisma_post->post_status;
$allowcomments  = $gnorisma_post->comment_status;
$track = get_post_meta($gnorisma_id, $ma_prefix.'track_change_url', true);
?>

	<div class="row-fluid filters">
		<div class="span6">
			<p>
				<a href="<?php echo get_permalink($software_id) ?>" rel="bookmark" title="<?php echo get_the_title($software_id);?>" class="btn btn-large btn-link">
					<?php echo __('ΑΦΟΡΑ ΤΟ ΛΟΓΙΣΜΙΚΟ','ma-ellak');?>: <?php echo get_the_title($software_id); ?>
				</a>
				<?php if($gstatus == 'publish'){ ?>
					&nbsp; &nbsp; | &nbsp; &nbsp;
					<a href="<?php echo get_permalink($gnorisma_id) ?>" rel="bookmark" title="<?php echo get_the_title($gnorisma_id);?>" class="btn btn-large btn-link">
						<?php echo __('ΠΡΟΒΟΛΗ ΤΟΥ ΓΝΩΡΙΣΜΑΤΟΣ','ma-ellak');?>
					</a>
				<?php } ?>
			</p>
		</div>
   	</div>  
	
   	 <div class="row-fluid event">
		<?php /*---------------------- Form ------------------------------------------*/ ?>
		<div id="ma-message" class="span8 offset2"><?php echo($ma_message); ?> </div>
		<?php if($success){ } else { }
			
			?>
		<div class="yamm-content events">
            <div class="row-fluid">
  
				<form action="<?php echo $url; ?>" method="post" id="ma_ellak_characteristic_submit_form" enctype="multipart/form-data" class="form-horizontal span12">
					<fieldset class="form-vertical span8 offset2">
					<div class="control-group">
						<label class="control-label span12" for="ctitle"><?php _e('Τίτλος', 'ma-ellak'); ?></label>
						<div class="controls">
						<input type="text" name="ctitle" id="ctitle" class="form-control input-block-level required" value="<?php echo $gnorisma_post->post_title; ?>"  />
						</div>
					</div>
					
					<div class="control-group">
						<label for="cdescription"><?php _e('Πλήρης Περιγραφή τους Γνωρίσματος/Λειτουργικού Χαρακτηριστικού', 'ma-ellak'); ?></label>
						<?php 	
							echo"<br/>";
							wp_editor( $gnorisma_post->post_content, 'cdescription');
						?>
					</div>
					<div class="control-group">
						<label class="control-label span12" for="_ma_characteristic_type"><?php _e('Τύπος', 'ma-ellak'); ?></label>
						<div class="controls">
							<select class="_ma_characteristic_type" name="_ma_characteristic_type">
								<option value=""><?php _e('Επιλέξτε', 'ma-ellak'); ?></option>
								<option value="gnorisma" <?php if($type == 'gnorisma') echo 'selected="selected"'; ?>><?php _e('Λειτουργικό Γνώρισμα', 'ma-ellak'); ?></option>
								<option value="characteristic" <?php if($type == 'characteristic') echo 'selected="selected"'; ?>><?php _e('Χαρακτηριστικό', 'ma-ellak'); ?></option>
							</select>
						</div>
					</div>
					
					<?php 
					// If is post admin of the Software
					$software_post = get_post($software_id);
					if(ma_ellak_user_is_post_admin($software_post )){ ?>
					<div class="admineditor back-gray">
						<div class="row-fluid">
							<div class="span4">
								<div class="control-group">
									<label class="control-label span12" for="_ma_stage_status"><?php _e('Εξέλιξη', 'ma-ellak'); ?></label>
									<div class="controls">
										<select class="_ma_characteristic_type" id="stage_status" name="_ma_stage_status">
											<option value=""><?php _e('Επιλέξτε', 'ma-ellak'); ?></option>
											<option value="selected" <?php if($status == 'selected') echo 'selected="selected"'; ?>><?php _e('Ανάληψη', 'ma-ellak'); ?></option>
											<option value="processed" <?php if($status == 'processed') echo 'selected="selected"'; ?>><?php _e('Σε εξέλιξη', 'ma-ellak'); ?></option>
											<option value="done" <?php if($status == 'done') echo 'selected="selected"'; ?>><?php _e('Ολοκληρωμένο', 'ma-ellak'); ?></option>
										</select>
									</div>
								</div>
							</div>
							<div class="span4">
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
							<div class="span4">
								<div class="control-group">
									<label class="control-label span12" for="_ma_characteristic_type"><?php _e('Κατάσταση', 'ma-ellak'); ?></label>
									<div class="controls">
										<select class="gstatus" name="gstatus">
											<option value=""><?php _e('Επιλέξτε', 'ma-ellak'); ?></option>
											<option value="draft" <?php if($gstatus == 'draft') echo 'selected="selected"'; ?>><?php _e('Προσχέδιο', 'ma-ellak'); ?></option>
											<option value="publish" <?php if($gstatus == 'publish') echo 'selected="selected"'; ?>><?php _e('Δημοσιευμένο', 'ma-ellak'); ?></option>
										</select>
									</div>
								</div>
							</div>
							
							<div class="span11">
								<div class="control-group">
									<label class="control-label span12" for="_ma_track_change_url"><?php _e('Σύνδεσμος Αποθετηρίου (Ticket URL)', 'ma-ellak'); ?></label>
									<div class="controls">
									<input type="text" name="_ma_track_change_url" id="_ma_track_change_url" class="form-control input-block-level" value="<?php echo $track; ?>"  />
									</div>
								</div>
							</div>
							
							<div class="span12" id="acceptance">
								<div class="control-group">
									<div class="controls">
										<label for="_ma_characteristic_acceptance"><?php _e('Σύντομη περιγραφή ως προς την Αποδοχή/Ολοκλήρωση ή Ενσωμάτωση της πρότασης.', 'ma-ellak'); ?></label>
										<?php 	
											echo"<br/>";
											wp_editor( $acceptance , '_ma_characteristic_acceptance');
										?>
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
					$comments = get_comments($args);
					?>
					<div class="comment-editor">
						<div class="row-fluid">
							<div class="span12">
								<div id="comment_head_edit"><?php  _e('Σχόλια προς Επεξεργασία', 'ma-ellak'); ?> <span><?php echo count($comments); ?></span></div>
							</div>
						</div>
						<?php $class_comm = 'hideme' ; if(isset($_GET['comment'])) $class_comm = 'openme'; ?>
						<ul id="comment_list_admin" class="<?php echo $class_comm  ; ?>">
			<?php		foreach($comments as $comment) { 
							echo '<li><div class="author_name">'.$comment->comment_author . '</div><div class="comment_content">' . $comment->comment_content.'</div>';
							echo '<div class="comment_actions">';
							echo '<a class="btn btn-tiny btn-more action-comment discard-comment pull-right" href="'.$url.'&comment='.$comment->comment_ID.'&status=discard#comment_list_admin" >'.__('Ανεπιθύμητο', 'ma-ellak').'</a>';
							echo '<a class="btn btn-tiny btn-more action-comment approve-comment pull-right" href="'.$url.'&comment='.$comment->comment_ID.'&status=approve#comment_list_admin" >'.__('Έγκριση', 'ma-ellak').'</a>';
							echo '</li>';
						}  ?>
						</ul>
					</div>
					<?php } ?>
					
					<div class="control-group">
						<label class="control-label span12" for="ma_ellak_characteristic_submit"></label>
						<div class="controls">
							<button type="submit" id="ma_ellak_characteristic_submit" name="ma_ellak_characteristic_submit" class="btn btn-primary btn-block"><?php _e('ΕΠΕΞΕΡΓΑΣΙΑ', 'ma-ellak');?></button>
						</div>
					</div>
					<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
					</fieldset>
				</form>
			</div>
			<?php 
				if(is_anonymous_author($gnorisma_id))?>
				<div class="row-fluid anon-msg">
					<div class="span8 offset2">
						* <?php _e('Καταχωρήθηκε απο Ανώνυμο Χρήστη.','ma-ellak');?>
					</div>
				</div>
			<?php ?>
		<?php //} /*---------------------- End Form ------------------------------------------*/ ?>
		</div>
	</div>	
<?php } else {   _e('Πρέπει να επιλέξετε Λειτουργικό Χαρακτηριστικό/Γνώρισμα πρώτα!','ma-ellak');  }

get_footer(); ?>