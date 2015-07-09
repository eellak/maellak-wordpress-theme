<?php
/*
Template Name: Event - Update
*/
   if (! is_user_logged_in()) // Μόνο εγγεγραμμένοι χρήστες μπορούν να είναι εδώ.
		header('Location: '.URL.''); 
   get_header();
 	
	$cur_user = wp_get_current_user();
	if(strpos($_SERVER['HTTP_REFERER'], '?id')==false)	$UrlReferrer = $_SERVER['HTTP_REFERER'];
	
	$success = false;
	$ma_message = '';
	if(isset($_GET['id'])){
	$currentID= sanitize_text_field($_GET['id']);
	$chekcData = get_post( $currentID);
	if(!ma_ellak_user_can_edit_post($chekcData)){
	
		_e('Δεν έχετε δικαίωμα Επεξεργασίας της Εκδήλωσης','ma-ellak');
	}else if( !isset($chekcData) || 'events'!=$chekcData->post_type){
		$ma_message = '<p class="error">Η ΕΚΔΗΛΩΣΗ ΠΟΥ ΠΡΟΣΠΑΘΕΙΤΕ ΝΑ ΕΠΕΞΕΡΓΑΣΤΕΙΤΕ ΔΕΝ ΥΠΑΡΧΕΙ.</p>';
		echo $ma_message;
	}else{	
	
		if(isset($_POST['ma_ellak_event_submit']) &&isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {
			
			$title = sanitize_text_field($_POST['titlez']);
			$description = $_POST['descriptionz']; 
			$author =  sanitize_text_field($_POST['userz']); 
			//$event_title_program_desc = sanitize_text_field($_POST['event_title_program_desc']); 
			$tag_list = implode(',', $_POST['tag-select']);
			if(isset($_POST['selftags'])){
				$tag_list .= ','.sanitize_text_field($_POST['selftags']);
			}
			// Ορίζουμε τις κατηγορίες/ταξονομίες
			$tax = array('post_tag' => $tag_list, 'thema' => implode(',', $_POST['thema-select']));
			
			$pub_status =  sanitize_text_field($_POST['gstatus']);
			//if(isset($_POST['gstatus'])) $pub_status = 'publish';
			$event = array(
				'ID'           => $currentID,
				'post_title'	=> $title,
				'post_content'	=> $description,
				'tax_input'		=> $tax, 		
				'post_status'	=> $pub_status, 	// publish, preview, future, etc.
				'post_type'		=> 'events', 	
				'post_author'	=> $author 
			);
			
			// Καταχωρούμε το Λογισμικό
			$event_id = wp_update_post($event);
			
			//echo $event_id;
			
			if($event_id){
				// Αποθηκεύουμε τα post meta
				ma_ellak_events_save_details($event_id);
				
				// Redirect αν το θέλουμε (πχ στο δημοσιευμένο άρθρο). 
				//wp_redirect( home_url() ); exit;
				$ma_message = '<p class="message">H καταχώρησή σας ήταν επιτυχής.</p>';
				$ma_message .='Μπορείτε να γυρίσετε στην σελίδα που ήσασταν πατώντας <a href='.$_POST['pagerefferer'].'>εδώ</a>';
				$success = true;
				
				// Αποστολή email στον διαχειριστή/υπεύθυνο
			$unit_id =  ma_ellak_get_unit_id();
			
			if( $unit_id != 0)
				update_post_meta( $event_id, '_ma_ellak_belongs_to_unit',$unit_id );
			
			} else {
				$ma_message = '<p class="error">Παρουσιάστηκε πρόβλημα και η καταχώρησή Δεν ήταν επιτυχής.</p>';
			}
		} 
		
	
	?>
	
	
	<div class="postWrapper" id="post-<?php the_ID(); ?>">
	<?php 
	
	?>
		
		<div class="post">
			<?php /*---------------------- Form ------------------------------------------*/ ?>
			<div id="ma-message"><?php echo($ma_message); ?> </div>
			<?php if($success){ } else { 
					  $data = get_post($currentID);
					  $meta = get_post_meta($currentID);
				?>
				<form action="<?php echo esc_url( get_permalink( get_the_ID() ) )."?id=".$currentID; ?>" method="post" id="ma_ellak_event_submit_form">
					<div class="control-group">
						<label for="titlez" ><?php _e('ΤΙΤΛΟΣ ΕΚΔΗΛΩΣΗΣ (*)', 'ma-ellak'); ?></label>
						<div class="controls">
							<input type="text" name="titlez" id="titlez" class="input-block-level input required" value="<?php if(isset($data->post_title)) echo $data->post_title;?>" class="required" />				
	                    </div>
					</div>
					
					<div class="control-group">
						<label for="descriptionz"><?php _e('Πλήρης Περιγραφή εκδήλωσης', 'ma-ellak'); ?></label>
					<?php 	
						echo"<br/>";
						if(isset($data->post_content)) $content = $data->post_content;
						wp_editor( $content, 'descriptionz');
					?>
					<span class="help-block"><?php echo __('Αναλυτική περιγραφή της εκδήλωσης','ma-ellak')?></span>
					</div>
			
					<div class="control-group">
						<label for="thema-select"><?php _e('Θεματική', 'ma-ellak'); ?></label>
						<?php 						
							//$thema = get_taxonomy('thema'); 
							//echo ma_ellak_add_term_chosebox( $thema, 'thema-select', true); 
							$post_terms =wp_get_post_terms( $currentID, 'thema');
							$i=0;
							foreach ($post_terms as $term){
								$arrayTerms[$i]= $term->term_id;
								$i++;
							}
							echo ma_ellak_add_thema_term_chosebox( 'thema-select', true, $arrayTerms); 
						?>
					</div>
					
					<div class="control-group">
						<label for="tag-select"><?php _e('Ετικέτες', 'ma-ellak'); ?></label>
						<?php 
						$terms = array();
						foreach (wp_get_post_terms($currentID, 'post_tag')  as $term)
							$terms[]= $term->slug;
						$tagz = get_taxonomy('post_tag');
						echo ma_ellak_add_term_chosebox( $tagz, 'tag-select', false, $terms );
						
						?>
						<a href="#" id="addnewtags" style="font-size:90%; font-style:italics;"><?php _e('Προσθέστε νέες Ετικέτες αν δεν εντοπίζονται παραπάνω.', 'ma-ellak'); ?></a>
						<input type="text" name="selftags" style="display:none;" id="selftags" class="form-control input-block-level" value="<?php if(isset($_POST[$field['selftags']])) echo $_POST[$field['selftags']];?>" placeholder="<?php _e('Χωρίστε με κόμα (,) τις νέες ετικέτες', 'ma-ellak'); ?>" />
				
					</div>
					<div class="row-fluid">
						<div class="span4">
							<div class="control-group">
								<label for="_ma_events_type"><?php _e('Τύπος εκδήλωσης', 'ma-ellak'); ?></label>
								<select name="_ma_events_type" id="_ma_events_type" class="required" class="input-block-level">
									<?php 
										 
									?>
									<option value="event" <?php if($meta['_ma_events_type'][0]=='event') echo "selected='selected'";?>>Εκδήλωση</option>
									 <option value="seminar" <?php if($meta['_ma_events_type'][0]=='seminar') echo "selected='selected'";?> >Σεμινάριο</option>
									 <option value="seminar1" <?php if($meta['_ma_events_type'][0]=='seminar1') echo "selected='selected'";?>>Κύκλος Εκπαίδευσης</option>
									 <option value="school"  <?php if($meta['_ma_events_type'][0]=='school') echo "selected='selected'";?>>Σχολείο Ανάπτυξης Κώδικα</option>
									 <option value="meeting"  <?php if($meta['_ma_events_type'][0]=='meeting') echo "selected='selected'";?>>Ημερίδα</option>
									 <option value="summerschool"  <?php if($meta['_ma_events_type'][0]=='summerschool') echo "selected='selected'";?>>Θερινό σχολείο</option>
 								</select>
								</div>
							</div><!-- span6 -->
							<div class="span4">
								<div class="control-group">
							
								<label for="_ma_events_participate"><?php _e('Δήλωση συμμετοχής;', 'ma-ellak'); ?></label>
								<select name="_ma_events_participate" id="_ma_events_participate" class="required" class="input-block-level">
									<option value="no"  <?php if(!isset($meta['_ma_events_participate'][0])) echo "selected='selected'";?>>Όχι</option>
									<option value="yes"  <?php if($meta['_ma_events_participate'][0]=='yes') echo "selected='selected'";?>>Ναι</option>
								</select>
						</div>
							</div><!-- span6 -->
						<div class="span4">
								
						<div class="control-group">
						<div class="controls">
							<label  class="checkbox inline" for="_ma_event_evaluation">
							<input type="checkbox" name="_ma_event_evaluation" id="_ma_event_evaluation" 
							<?php if(isset($meta['_ma_event_evaluation'][0]) && $meta['_ma_event_evaluation'][0]=='on') echo "checked='checked'";?>
							/>
							<span class="meta"><?php _e('Θέλετε να αξιολογηθεί μετά το πέρας;', 'ma-ellak');  ?></span>
							</label>
						</div>
						</div>
							</div><!-- span6 -->
					</div><!-- row-fluid -->
					
						<div class="row-fluid">
							<div class="span6">
								<div class="control-group">
									<label for="_ma_event_place"><?php _e('Χώρος', 'ma-ellak'); ?></label>
									<div class="controls">
										<input type="text" name="_ma_event_place" id="_ma_event_place" class="input-block-level input " 
										value="<?php if(isset($meta['_ma_event_place'][0])) echo $meta['_ma_event_place'][0];?>" />
									</div>
								</div>
							</div><!-- span6 -->
							<div class="span6">
							
								<div class="control-group">
									<label for="_ma_event_address"><?php _e('Διεύθυνση', 'ma-ellak'); ?></label>
									<input type="text" name="_ma_event_address" id="_ma_event_address" class="input-block-level input " 
										value="<?php if(isset($meta['_ma_event_address'][0])) echo $meta['_ma_event_address'][0];?>"  />
								</div>
							</div><!-- span6 -->
						</div>
						<div class="row-fluid">
							<div class="span3">
								<div class="control-group">
									<label for="_ma_event_startdate_timestamp"><?php _e('Ημερομηνία έναρξης (*)', 'ma-ellak'); ?></label>
									<input class="cmb_datepicker  input-block-level" type="text" name="_ma_event_startdate_timestamp" 
									id="_ma_event_startdate_timestamp" value="<?php echo $meta['_ma_event_startdate_timestamp'][0];?>">
								</div>	
							</div><!-- span6 -->
							<div class="span3">
								<div class="control-group">
								<label for="_ma_event_startdate_time"><?php _e('Ώρα έναρξης', 'ma-ellak'); ?></label>
								<input class="cmb_timepicker text_time input-block-level" type="text" name="_ma_event_startdate_time" id="_ma_event_startdate_time"  autocomplete="OFF" value="<?php echo $meta['_ma_event_startdate_time'][0];?>">
								</div>
							</div><!-- span6 -->
							<div class="span3">
								<div class="control-group">
							<label for="_ma_event_enddate_timestamp"><?php _e('Ημερομηνία Λήξης  (*)', 'ma-ellak'); ?></label>
							<input class="cmb_datepicker  input-block-level" type="text" name="_ma_event_enddate_timestamp" id="_ma_event_enddate_timestamp" value="<?php echo $meta['_ma_event_enddate_timestamp'][0];?>">
						</div>	
							</div><!-- span6 -->
							<div class="span3">
								<div class="control-group">
							<label for="_ma_event_enddate_time"><?php _e('Ώρα λήξης', 'ma-ellak'); ?></label>
							<input class="cmb_timepicker text_time input-block-level" type="text" name="_ma_event_enddate_time" id="_ma_event_enddate_time"  autocomplete="OFF" value="<?php echo $meta['_ma_event_enddate_time'][0];?>">
						</div>
							</div><!-- span6 -->
						</div><!-- row-fluid -->
							
						<div class="control-group">
						<label for="_ma_event_title_program_desc"><?php _e('Πρόγραμμα εκδήλωσης', 'ma-ellak'); ?></label>
					<?php 	
						echo"<br/>";
						if(isset($meta['_ma_event_title_program_desc'][0])) $contentProg = $meta['_ma_event_title_program_desc'][0];
							
						wp_editor( $contentProg, '_ma_event_title_program_desc');
					?>
					<span class="help-block"><?php echo __('Αναλυτική περιγραφή της εκδήλωσης','ma-ellak')?></span>
					</div>
					
					
						<div class="control-group">
						<div class="controls">
							<label  class="checkbox inline" for="_ma_video_know">
							<input type="checkbox" name="_ma_event_live" id="_ma_event_live" 
							<?php if(isset($meta['_ma_event_live'][0]) && $meta['_ma_event_live'][0]=='on') echo "checked='checked'";?>
							/>
							<span class="meta"><?php _e('Έχει live;', 'ma-ellak');  ?></span>
							</label>
						</div>
					</div>
					
						<div id="meta_inner">
					   
					    </div>
		   				<span class="add btn btn-info btn-xs"><?php echo __('Προσθήκη Ζωντανής Σύνδεσης','ma-ellak'); ?></span>
		   				<br/><br/>
		   				 <?php 
					    $eventsLive = get_post_meta($currentID,'eventslive',true);
					    $c = 0;
					    //if($events)
					    if($eventsLive)
					    	if ( count( $eventsLive ) >= 0 ) {
					    	foreach( $eventsLive as $event ) {
					    
					    		if ( isset( $event['_ma_ellak_event_url'] ) ) {
					    			printf( '<p> <div class="row-fluid"><div class="span1"><label>ΣΥΝΔΕΣΜΟΣ	</label></div><div class="span3">
									<input type="text" name="eventz[%1$s][_ma_ellak_event_url]" value="%2$s" id="_ma_ellak_event_url%1$s" class="required url"  /> </div>
									<div class="span1"><label>ΤΙΤΛΟΣ</label> </div><div class="span3">
									<input type="text" name="eventz[%1$s][_ma_ellak_event_url_title]" id="_ma_ellak_event_url_title%1$s"  value="%3$s" class="required"  />
									<input type="hidden" name="eventz[%1$s][_ma_ellak_event_views]" id="_ma_ellak_event_views%1$s"  value="%4$s" readonly width="10" size="3"/><span class="remove">%5$s</span></p>', $c, $event['_ma_ellak_event_url'],$event['_ma_ellak_event_url_title'],$event['_ma_ellak_event_views'], 
									"</div><div class='span2'><span class='remove btn btn-danger btn-xs'> - Αφαίρεση</span></div></div></p>" );
					    			$c = $c +1;
					    		}
					    	}
					    }
					    ?>
					    <input type="hidden" name="eventslistcounter" id="eventslistcounter" value="<?php echo $c;?>"/>
		   				<span id="here"></span>
		   				
					<br/><br/>
					
					<?php if(ma_ellak_user_is_post_admin($chekcData)){ ?>
					<div class="row-fluid admineditor back-gray">
						<div class="span5 offset1">
							<div class="control-group">
								<label class="control-label span12" for="gstatus"><?php _e('Κατάσταση', 'ma-ellak'); ?></label>
								<div class="controls">
									<?php $gstatus = $chekcData->post_status; ?>
									<select class="gstatus" name="gstatus">
										<option value=""><?php _e('Επιλέξτε', 'ma-ellak'); ?></option>
										<option value="draft" <?php if($gstatus == 'draft') echo 'selected="selected"'; ?>><?php _e('Προσχέδιο', 'ma-ellak'); ?></option>
										<option value="publish" <?php if($gstatus == 'publish') echo 'selected="selected"'; ?>><?php _e('Δημοσιευμένο', 'ma-ellak'); ?></option>
									</select>
								</div><!-- controls -->
							</div><!-- control-group -->
						</div><!-- span5 offset1 -->
					</div><!-- row-fluid admineditor back-gray -->
					
					<?php }?>
					<br/>
				
	                <button id="ma_ellak_event_submit" name="ma_ellak_event_submit" class="btn btn-primary btn-block"><?php _e('Υποβολή', 'ma-ellak'); ?></button>
						
					<input type="hidden" id="userz" name="userz" value="<?php echo $cur_user->ID; ?>" />
					<input type="hidden" id="pagerefferer" name="pagerefferer" value="<?php echo $UrlReferrer;?>"/>
					<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
				</form>

<?php if ($meta['_ma_event_evaluation'][0]=='on'){ ?>
				<script type="text/javascript">
<!--
function doSearchEvaluate(){
	jQuery('#ttevaluate').datagrid('load',{
		name: jQuery('#nameeval').val(),
		email: jQuery('#emaileval').val()
	});
}
//-->
</script>
 <h3>Οι Αξιολογήσεις <a href="<?php echo get_permalink(get_option_tree('ma_ellak_event_evaluations_xls'))."?eid=".$currentID;?>"><img src="<?php bloginfo('template_directory'); ?>/images/xls.png" alt="excel format"/></a>
 </h3>
	<div id="#tbevaluate" style="padding:3px">
		<span><?php _e('Επώνυμο','ma-ellak')?>:</span>
		<input id="nameeval" style="line-height:26px;border:1px solid #ccc">
		<span><?php _e('Email','ma-ellak')?>:</span>
		<input id="emaileval" style="line-height:26px;border:1px solid #ccc">
		<a href="#evaluations" class="easyui-linkbutton" plain="true" 
		onclick="doSearchEvaluate()"><?php _e('Αναζήτηση','ma-ellak')?></a>
	</div>
		<a name="evaluations"></a>
		<table id="ttevaluate" title="<?php _e('Συμμετοχές','ma-ellak')?>" class="easyui-datagrid" 
		url="<?php echo get_bloginfo('template_directory')."/";?>ma_ellak_event_get_evaluations.php?event_id=<?php echo $currentID;?>&"
		toolbar="#tbevaluate" pagination="true"
		rownumbers="true" fitColumns="true" singleSelect="true">
			<thead>
			<tr>
			<th field="id" width="50" ><?php _e('Α/Α','ma-ellak')?></th>
			<th field="ma_impressions" width="50" sortable="true"><?php _e('Εικόνα','ma-ellak')?></th>
			<th field="ma_speakers" width="50" sortable="true"><?php _e('Ομιλητές','ma-ellak')?></th>
			<th field="ma_material" width="50" sortable="true"><?php _e('Υλικό','ma-ellak')?></th>
			<th field="ma_organizers" width="50" sortable="true"><?php _e('Οργάνωση','ma-ellak')?></th>
			<th field="ma_age" width="50" sortable="true"><?php _e('Ηλικία','ma-ellak')?></th>
			<th field="ma_sex" width="50" sortable="true"><?php _e('Φύλο','ma-ellak')?></th>
			<th field="ma_comments" width="50" sortable="true"><?php _e('Σχόλιο','ma-ellak')?></th>
			<th field="name" width="50" sortable="true"><?php _e('Όνομα','ma-ellak')?></th>
			<th field="surname" width="50" sortable="true"><?php _e('Επώνυμο','ma-ellak')?></th>
			<th field="ma_phone" width="50" ><?php _e('Τηλέφωνο','ma-ellak')?></th>
			<th field="email" width="50" sortable="true"><?php _e('Email','ma-ellak')?></th>
			</tr>
			</thead>
		</table>
		   <br/><br/>
 <?php }?>
				
				
<?php if ($meta['_ma_events_participate'][0]=='yes'){ ?>
<script type="text/javascript">
<!--
function doSearch(){
	jQuery('#tt').datagrid('load',{
		name: jQuery('#name').val(),
		email: jQuery('#email').val()
	});
}
//-->
</script>
 <h3>Οι συμμετέχοντες <a href="<?php echo get_permalink(get_option_tree('ma_ellak_event_participants_xls'))."?eid=".$currentID;?>"><img src="<?php bloginfo('template_directory'); ?>/images/xls.png" alt="excel format"/></a>
 </h3>
	<div id="tb" style="padding:3px">
		<span><?php _e('Επώνυμο','ma-ellak')?>:</span>
		<input id="name" style="line-height:26px;border:1px solid #ccc">
		<span><?php _e('Email','ma-ellak')?>:</span>
		<input id="email" style="line-height:26px;border:1px solid #ccc">
		<a href="#participants" class="easyui-linkbutton" plain="true" onclick="doSearch()"><?php _e('Αναζήτηση','ma-ellak')?></a>
	</div>
<a name="participants"></a>
<table id="tt" title="<?php _e('Συμμετοχές','ma-ellak')?>" class="easyui-datagrid" 
url="<?php echo get_bloginfo('template_directory')."/";?>ma_ellak_event_get_participants.php?event_id=<?php echo $currentID;?>&"
toolbar="#tb" pagination="true"
rownumbers="true" fitColumns="true" singleSelect="true">
	<thead>
	<tr>
	<th field="id" width="50" ><?php _e('Α/Α','ma-ellak')?></th>
	<th field="name" width="50" sortable="true"><?php _e('Όνομα','ma-ellak')?></th>
	<th field="surname" width="50" sortable="true"><?php _e('Επώνυμο','ma-ellak')?></th>
	<th field="email" width="50" sortable="true"><?php _e('Email','ma-ellak')?></th>
	<th field="ma_position" width="50" sortable="true"><?php _e('Θέση','ma-ellak')?></th>
	<th field="ma_institute" width="50" sortable="true"><?php _e('Φορέας','ma-ellak')?></th>
	<th field="ma_phone" width="50" ><?php _e('Τηλέφωνο','ma-ellak')?></th>
	<th field="ma_bio" width="50" ><?php _e('Βιογραφικό','ma-ellak')?></th>
	</tr>
	</thead>
</table>
   
 <br/><br/>
 <?php } ?>
 
 
			<?php } ?>
			
			
			<?php /*---------------------- End Form ------------------------------------------*/ ?>
	
		
	</div>
	</div>
	
	<?php 
		}
	}else //if isset $_GET 
		_e('ΠΡΕΠΕΙ ΝΑ ΔΙΑΛΕΞΕΤΕ ΤΗΝ ΕΚΔΗΛΩΣΗ ΠΟΥ ΘΕΛΕΤΕ ΝΑ ΑΝΑΝΕΩΣΕΤΕ','ma-ellak');
   
   get_footer(); 
?>