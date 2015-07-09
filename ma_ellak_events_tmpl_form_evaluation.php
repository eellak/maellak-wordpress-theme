<?php
/*
Template Name: Event - Evaluation
*/

	// if (! is_user_logged_in()) // Μόνο εγγεγραμμένοι χρήστες μπορούν να είναι εδώ.
//		header('Location: '.URL.''); 
	 
	$cur_user = wp_get_current_user();
	
	$success = false;
	$ma_message = '';
	if(isset($_POST['ma_ellak_events_evaluation_submit']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {
		global $wpdb;
		
		if( function_exists( 'cptch_check_custom_form' ) && cptch_check_custom_form() === true ) {
					
		$name = sanitize_text_field($_POST['namez']);
		$surname = sanitize_text_field($_POST['surnamez']);
		$email = sanitize_text_field($_POST['emailz']);
		$events_id = intval($_POST['events_id']);
		$ma_position = sanitize_text_field($_POST['ma_position']);
		$ma_institute = sanitize_text_field($_POST['ma_institute']);
		$ma_phone = sanitize_text_field($_POST['ma_phone']);
		$mamaterial =  sanitize_text_field($_POST['mamaterial']);
		$maspeakers =  sanitize_text_field($_POST['maspeakers']);
		$maimpresssions =  sanitize_text_field($_POST['maimpresssions']);
		$maorganizers = sanitize_text_field($_POST['maorganizers']);
		$manexttime = sanitize_text_field($_POST['manexttime']);
		$macomments = sanitize_text_field($_POST['macomments']);
		$masex= sanitize_text_field($_POST['masex']);
		$maage = sanitize_text_field($_POST['maage']);
		$now  = new DateTime(); 
		$datesubmited = $now->format('Y-m-d H:i:s'); 
		
		//Collect the data
		$evaluation = array(
				'events_id'	=> $events_id,
				'ma_impressions'=>$maimpresssions,
				'ma_speakers'=>$maspeakers,
				'ma_material'=>$mamaterial,
				'ma_organizers'=>$maorganizers,
				'ma_nexttime'=>$manexttime,
				'name'	=> $name,
				'surname'	=> $surname,
				'email'		=> $email,	
				'ma_position'=>$ma_position,			
				'ma_institute'=>$ma_institute,			
				'ma_phone'=>$ma_phone,
				
				'ma_comments'=>$macomments,
				'ma_datetime'=> $datesubmited ,
				'ma_sex'=>$masex,
				'ma_age'=>$maage,
				
		);
	
		$format= array('%d','%d','%d','%d','%d','%d','%s','%s','%s','%s','%s','%s','%s', '%s', '%d', '%d' );
		
		// Καταχωρούμε τη συμμετοχή 
		$wpdb->insert( 'ma_events_evaluation', $evaluation ,$format);
		$wpdb->show_errors();
		$id = $wpdb->insert_id;
		
		if($id){
			
			$ma_message = '<p class="message">H καταχώριση σας ήταν επιτυχής.</p>' ;
			$success = true;
			
			// Αποστολή email στον διαχειριστή/υπεύθυνο
			$email_message = 'Νέα συμμετοχή με όνομα: '.$name;
			// wp_mail( 'email@ma.ellak.gr', '[Λογισμικό] Νέα καταχώριση', $email_message);
		} else {
			$ma_message .= '<p class="error">Παρουσιάστηκε πρόβλημα και η καταχώριση δεν ήταν επιτυχής.</p>';
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

	if(!isset($chekcData) || $chekcData->post_type!='events' || $custom['_ma_event_evaluation'][0]!='on'){
		$ma_message = '<p class="error">Η ΕΚΔΗΛΩΣΗ ΠΟΥ ΠΡΟΣΠΑΘΕΙΤΕ ΝΑ ΑΞΙΟΛΟΓΗΣΕΤΕ ΔΕΝ ΥΠΑΡΧΕΙ Η ΔΕΝ ΕΧΕΙ ΕΝΕΡΓΟΠΟΙΗΜΕΝΗ ΤΗΝ ΔΙΑΔΙΚΑΣΙΑ ΑΞΙΟΛΟΓΗΣΗΣ.</p>';
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
		
			$url = get_permalink(get_option_tree('ma_ellak_view_participation_option_id'));
			$url .="?events_id=".$events_id;
			?>
		<div class="yamm-content events">
            <div class="row-fluid">
        
			<form action="<?php echo $url; ?>" method="post" id="ma_ellak_software_submit_form" enctype="multipart/form-data" class="form-horizontal span12">
				<fieldset class="form-vertical span7 offset2">
				
				<div class="control-group">
					<label><?php _e('Πώς σας φάνηκε η εκδήλώση/σεμινάριο;','ma-ellak')?></label>
					<div class="controls">
					<label class="radio inline">
					 <input type="radio" id="inlineCheckbox1" name="maimpresssions" value="1"> <?php _e('Κακή', 'ma-ellak'); ?>
					</label>
					<label class="checkbox inline">
					  <input type="radio" id="inlineCheckbox2" name="maimpresssions" value="2"> <?php _e('Μέτρια', 'ma-ellak'); ?>
					</label>
					<label class="checkbox inline">
					  <input type="radio" id="inlineCheckbox3" name="maimpresssions" value="3">  <?php _e('Καλή', 'ma-ellak'); ?>
					</label>
					<label class="checkbox inline">
					  <input type="radio" id="inlineCheckbox4" name="maimpresssions" value="4">  <?php _e('Πολύ Καλή', 'ma-ellak'); ?>
					</label>
					<label class="checkbox inline">
					  <input type="radio" id="inlineCheckbox5" name="maimpresssions" value="5">  <?php _e('Άριστη', 'ma-ellak'); ?>
					</label>
					</div>
				</div>
				<br/>
				<div class="control-group">
					<label><?php _e('Πώς σας φάνηκε το επίπεδο των ομιλητών;','ma-ellak')?></label>
					<div class="controls">
					<label class="radio inline">
					 <input type="radio" id="maspeakers1" name="maspeakers" value="1"> <?php _e('Κακό', 'ma-ellak'); ?>
					</label>
					<label class="checkbox inline">
					  <input type="radio" id="maspeakers2" name="maspeakers" value="2"> <?php _e('Μέτριο', 'ma-ellak'); ?>
					</label>
					<label class="checkbox inline">
					  <input type="radio" id="maspeakers3" name="maspeakers" value="3">  <?php _e('Καλό', 'ma-ellak'); ?>
					</label>
					<label class="checkbox inline">
					  <input type="radio" id="maspeakers4" name="maspeakers" value="4">  <?php _e('Πολύ Καλό', 'ma-ellak'); ?>
					</label>
					<label class="checkbox inline">
					  <input type="radio" id="maspeakers5" name="maspeakers" value="5">  <?php _e('Άριστο', 'ma-ellak'); ?>
					</label>
					</div>
				</div>
				<br/>
				<div class="control-group">
					<label><?php _e('Πώς σας φάνηκε το συνοδευτικό υλικό;','ma-ellak')?></label>
					<div class="controls">
					<label class="radio inline">
					 <input type="radio" id="mamaterial1" name="mamaterial" value="1"> <?php _e('Κακό', 'ma-ellak'); ?>
					</label>
					<label class="checkbox inline">
					  <input type="radio" id="mamaterial2" name="mamaterial" value="2"> <?php _e('Μέτριο', 'ma-ellak'); ?>
					</label>
					<label class="checkbox inline">
					  <input type="radio" id="mamaterial3" name="mamaterial" value="3">  <?php _e('Καλό', 'ma-ellak'); ?>
					</label>
					<label class="checkbox inline">
					  <input type="radio" id="mamaterial4" name="mamaterial" value="4">  <?php _e('Πολύ Καλό', 'ma-ellak'); ?>
					</label>
					<label class="checkbox inline">
					  <input type="radio" id="mamaterial5" name="mamaterial" value="5">  <?php _e('Άριστο', 'ma-ellak'); ?>
					</label>
					</div>
				</div>
				<br/>
				
				<div class="control-group">
					<label><?php _e('Πώς σας φάνηκε η οργάνωση της εκδήλώσης/σεμιναρίου;','ma-ellak')?></label>
					<div class="controls">
					<label class="radio inline">
					 <input type="radio" id="maorganizers1" name="maorganizers" value="1"> <?php _e('Κακή', 'ma-ellak'); ?>
					</label>
					<label class="checkbox inline">
					  <input type="radio" id="maorganizers2" name="maorganizers" value="2"> <?php _e('Μέτρια', 'ma-ellak'); ?>
					</label>
					<label class="checkbox inline">
					  <input type="radio" id="maorganizers3" name="maorganizers" value="3">  <?php _e('Καλή', 'ma-ellak'); ?>
					</label>
					<label class="checkbox inline">
					  <input type="radio" id="maorganizers4" name="maorganizers" value="4">  <?php _e('Πολύ Καλή', 'ma-ellak'); ?>
					</label>
					<label class="checkbox inline">
					  <input type="radio" id="maorganizers5" name="maorganizers" value="5">  <?php _e('Άριστη', 'ma-ellak'); ?>
					</label>
					</div>
				</div>
				<br/>
				<div class="control-group">
					<label><?php _e('Θα παρακολουθούσατε αντίστοιχη εκδήλωσης/σεμινάριο;','ma-ellak')?></label>
					<div class="controls">
					<label class="radio inline">
					 <input type="radio" id="manexttime1" name="manexttime" value="1"> <?php _e('NAI', 'ma-ellak'); ?>
					</label>
					<label class="checkbox inline">
					  <input type="radio" id="manexttime2" name="manexttime" value="2"> <?php _e('OXI', 'ma-ellak'); ?>
					</label>
					</div>
				</div>
				<br/>
				<div class="control-group">
				<div class="controls">
				<label for="macomments"><?php _e('Σημειώστε κάποιο σχόλιο σας!');?></label>
				<textarea name="macomments" rows="3"></textarea>
				</div>
				</div>
				<br/>
				<div class="control-group">
					<label><?php _e('Φύλο;','ma-ellak')?></label>
					<div class="controls">
					<label class="radio inline">
					 <input type="radio" id="masex1" name="masex" value="1"> <?php _e('Άνδρας', 'ma-ellak'); ?>
					</label>
					<label class="checkbox inline">
					  <input type="radio" id="masex2" name="masex" value="2"> <?php _e('Γυναίκα', 'ma-ellak'); ?>
					</label>
					</div>
				</div>
				<br/>
				<div class="control-group">
					<label><?php _e('Ηλικία;','ma-ellak')?></label>
					<div class="controls">
					<label class="radio inline">
					 <input type="radio" id="maage1" name="maage" value="1"> <?php _e('20-30', 'ma-ellak'); ?>
					</label>
					<label class="checkbox inline">
					  <input type="radio" id="maage2" name="maage" value="2"> <?php _e('30-40', 'ma-ellak'); ?>
					</label>
					<label class="checkbox inline">
					  <input type="radio" id="maage3" name="maage" value="3"> <?php _e('40-50', 'ma-ellak'); ?>
					</label>
					</div>
				</div>
				<br/>
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
					<label class="control-label span12" for="emailz"><?php _e('Ηλεκτρονικό ταχυδρομείο', 'ma-ellak'); ?>(*)</label>
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
			
				<div class="control-group">
				<?php if( function_exists( 'cptch_display_captcha_custom' ) ) { echo "<input type='hidden' name='cntctfrm_contact_action' value='true' />"; echo cptch_display_captcha_custom(); } ?>
				
				</div>
				<input type="hidden" id="events_id" name="events_id" value="<?php echo $events_id; ?>" />
				 <div class="control-group">
                          <label class="control-label span12" for="ma_ellak_events_evaluation_submit"></label>
                          <div class="controls">
                            <button type="submit" id="ma_ellak_events_evaluation_submit" name="ma_ellak_events_evaluation_submit" class="btn btn-primary btn-block"><?php _e('ΥΠΟΒΟΛΗ', 'ma-ellak');?></button>
                          </div>
                        </div>
				</fieldset>
				
				
				<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
			</form>
			</div>
			
		<?php } ?>
		<?php } //no events_id // !isset($chekcData) || $checkData->post_type!='events' || $custom['_ma_event_evaluation']!='on' ?>
		<?php /*---------------------- End Form ------------------------------------------*/ ?>
	</div>
</div>	
<?php } //no events_id ?> 

<?php get_footer(); ?>