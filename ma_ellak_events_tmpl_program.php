<?php
/*
Template Name: Event - Program
*/


  /**
  *@desc the event program.
  */

  global $post;
  
  $events_id = $post->ID;//intval($_GET['events_id']);
  if($events_id==0) echo __('Πρέπει να επιλέξετε εκδήλωση για να δείτε το αντίστοιχο πρόγραμμα','ma-ellak');
  else{
  $postData =  get_post($events_id);
  
  if($postData->ID){
  	$meta = get_post_meta($events_id);
  	?>
 	<div class="row-fluid event">
 		<div class="cols">
      <?php 
      if($meta['_ma_event_title_program_desc'][0]){
      	echo  apply_filters('the_content', $meta['_ma_event_title_program_desc'][0]);
      	
      	if($meta['_ma_event_program_pdf'][0]){
      		echo  "<a href='".$meta['_ma_event_program_pdf'][0]."'>";
      		echo  __('Κατεβάστε το αρχείο','ma-ellak');
      		echo"</a>";
      	}
		}
      ?>
      </div>
	</div>
	<div style="clear:both"></div>
     
	<?php

  }
  }  


?>
