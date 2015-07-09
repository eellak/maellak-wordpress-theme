<?php
/*
Template Name: Test Email
*/

 if (! is_user_logged_in() or !current_user_can( 'manage_options' )) // Μόνο διαχειριστές μπορούν να είναι εδώ.
	header('Location: '.get_bloginfo('url').''); 
		
get_header();

$message = '';

if(isset($_POST['ma_ellak_test_mail'])) {
	$cfrom = sanitize_text_field($_POST['cfrom']);
	$ccc	= sanitize_text_field($_POST['ccc']);
	$cto	= sanitize_text_field($_POST['cto']);
	$csubject = sanitize_text_field($_POST['csubject']);
	$cmessage = sanitize_text_field($_POST['cmessage']);
	
	$headers = array();
	
	if(!empty($cfrom) and $cfrom != ''){
		$headers[] = 'From: '.$cfrom;
	}
	if(!empty($ccc) and $ccc != ''){
		$headers[] = 'Cc: '.$ccc;
	}
	
	if((!empty($cto) and $cto != '') and
		(!empty($csubject) and $csubject != '')and
			(!empty($cmessage) and $cmessage != '')){
		
		if(wp_mail( $cto, $csubject, $cmessage , $headers))
			$message = 'Το μήνυμα εστάλει επιτυχώς!';
		else
			$message = 'Το μήνυμα ΔΕΝ εστάλει!';
	}
}
    ?>
      
  <div class="row-fluid">
  	<div class="span12">
  	<p  class="meta purple">
  	 <small>Μόνο για δοκιμές</small>
  	</p>
  	<?php if($message != ''){ ?>
		<p  class="alert alert-info"><?php echo $message; ?></p>
		<p  class="alert error-info"><?php print_r($_POST); ?></p>
	<?php }?>
	<?php
		//$video_url = parse_url('https://www.youtube.com/watch?v=fbnaLgCU_7s');
		//print_r($video_url);
	?>
		<form action="<?php echo get_permalink(); ?>" method="post" id="ma_ellak_test_mail_form" enctype="multipart/form-data" class="form-horizontal span12">
			<fieldset class="form-vertical span8 offset2">
				
				<div class="control-group">
					<label class="control-label span12" for="cfrom">Απο</label>
					<div class="controls">
					<input type="text" name="cfrom" id="cfrom" class="form-control input-block-level required" value="<?php if(isset($_POST['cfrom'])) echo $_POST['cfrom'];?>"  />
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label span12" for="cto">Προς *</label>
					<div class="controls">
					<input type="text" name="cto" id="cto" class="form-control input-block-level required" value="<?php if(isset($_POST['cto'])) echo $_POST['cto'];?>"  />
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label span12" for="ccc">CC</label>
					<div class="controls">
					<input type="text" name="ccc" id="ccc" class="form-control input-block-level required" value="<?php if(isset($_POST['ccc'])) echo $_POST['ccc'];?>"  />
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label span12" for="csubject">Θέμα *</label>
					<div class="controls">
					<input type="text" name="csubject" id="csubject" class="form-control input-block-level required" value="<?php if(isset($_POST['csubject'])) echo $_POST['csubject'];?>"  />
					</div>
				</div>
				
				<div class="control-group">
					<label for="cmessage">Μήνυμα *</label>
					<textarea id="cmessage" name="cmessage" style="width: 98%; height: 200px;">
					<?php 	
						if(isset($_POST['cmessage'])) echo $_POST['cmessage'];
					?>
					</textarea>
				</div>
				
				<div class="controls">
					<button type="submit" id="ma_ellak_test_mail" name="ma_ellak_test_mail" class="btn btn-primary btn-block"><?php _e('ΑΠΟΣΤΟΛΗ', 'ma-ellak');?></button>
				</div>
			</fieldset>
		</form>
		<p>Τα πεδία με * είναι υποχρεωτικά!</p>
	</div>
 </div><!-- row-fluid -->
 <div class="row-fluid">
 		<p><?php edit_post_link(__('Edit'), ''); ?></p>
 </div>
<?php    
  get_footer();
?>