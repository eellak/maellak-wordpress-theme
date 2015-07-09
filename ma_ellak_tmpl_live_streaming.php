<?php

/*
 Template Name: Live Streaming Page
*/
  /**
  *@desc A single blog post See page.php is for a page layout.
  */
ma_ellak_streaming_redirect();
  get_header();
  ?>
    <?php 
  if (have_posts()) : while (have_posts()) : the_post();
  $ProgramPostId =get_option_tree('ma_ellak_view_event_program_option_id');
  $ParticipationFormPostId = get_option_tree('ma_ellak_view_event_option_id');
  $cid = $_GET['eventId'];
  $postdata = get_post($cid);
  $meta = get_post_meta($cid);
  
  $start = $meta['_ma_event_startdate_timestamp'][0]?strtotime($meta['_ma_event_startdate_timestamp'][0]):'';
  $starttime = $meta['_ma_event_startdate_time'][0]?$meta['_ma_event_startdate_time'][0]:'';
  
  $startd = date(MA_DATE_FORMAT,$start);
  $endd = $meta['_ma_event_enddate_timestamp'][0]?date(MA_DATE_FORMAT,strtotime($meta['_ma_event_enddate_timestamp'][0])):'';
  $endtime = $meta['_ma_event_enddate_time'][0]?$meta['_ma_event_enddate_time'][0]:'';
  
  $SdateD = date('d',$start);
  $SdateM = date('m',$start);
  $event_type = $meta ['_ma_events_type'][0];
  $place = $meta ['_ma_event_place'][0];
  $address=$meta['_ma_event_address'][0];
  $participation_form = $meta['_ma_events_participate'][0]=='no'?'':esc_url( get_permalink($ParticipationFormPostId) ).'?events_id='.$cid;
  $program = strlen($meta['_ma_event_title_program_desc'][0])<6?'':$meta['_ma_event_title_program_desc'][0];
  $thistime = strtotime($startd);
  $currenttime= strtotime(date(MA_DATE_FORMAT));
  $Urls = get_post_meta($cid,'eventslive');
  ?>
  
  <div class="row-fluid filters">
          <div class="span6">
            <p><a href="<?php echo get_permalink(get_option_tree('ma_ellak_list_event_option_id'))?>">ΠΙΣΩ ΣΤΗ ΛΙΣΤΑ</a></p>
          </div>
   </div>
   <div class="row-fluid event">
		  	<div class="cols">
		  		<div class="span8 offset2 col">
		  			<div class="">
					  
				    <?php 
					// FOTIS for Proof of concept: USE ONLY THE XXXXXXXXXXXXXXX from the youtube.com/watch?v=XXXXXXXXXXXXX
				  //  ma_ellak_print_streaming ($cid);
					//echo ' <iframe width="100%" height="600px"  src="'.$Urls[0][0][_ma_ellak_event_url].'" frameborder="0" allowfullscreen></iframe>';
					echo '<iframe scrolling="no"  name="video_frame" src="'.$Urls[0][0]['_ma_ellak_event_url'].'#left" width="640" height="360" frameborder="0" style="height: 360px; border: 0px none; width: 640px; margin-top: 0; margin-left: -20px; "></iframe>';
					?>
					</div>
		 		</div><!-- span4 col -->
		 		<div class="span7 text col">
					  <h3><a href="<?php echo $postdata->guid; ?>" rel="bookmark" 
				  	title="<?php the_title_attribute($cid);?>" class="btn btn-large btn-link"><?php echo $postdata->post_title; ?></a>
				  	<a href="?ical&eid=<?php echo$cid; ?>" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/btn_ical.png" width="24" height="15" alt="ical"/></a></h3>
				  	  <p  class="meta purple">
					  <?php get_event_type_label($event_type);?>
					  <?php ma_ellak_print_unit_title($cid); ?> 
					  <?php echo ma_ellak_print_thema($cid,'thema');?>
					  </strong> 
					  <?php echo $startd ." ". $starttime; if($endd) echo" - ". $endd ." ". $endtime;?></p>
					  <p  class="meta purple">
					  <?php if($place){?>
					  <?php echo __( 'ΣΤΟ', 'ma-ellak' );?>  
					  <strong class="magenta"><?php echo $place?></strong> 
					  <?php }?>
					  <?php if($address)?>
					  <strong ><?php echo $address;?></strong></p>
					 
					  <?php  the_excerpt_max_charlength(240);?>
					  
					  
					  <p>&nbsp;</p>
					
				</div><!-- span8 text col -->
		  	</div><!-- cols -->
	  </div><!-- row-fluid event -->
	 
	  
  <div class="back-purple">
  	<div class="container">
  		<div class="row-fluid">
  			<ul class="nav nav-tabs span10 offset2">

  				<li class="active">
  					<a href="#tab-1" data-toggle="tab"><?php echo  __('ΠΕΡΙΓΡΑΦΗ','ma-ellak');?></a>
  				</li>
  				<?php if(strlen($program)>6){?>
  					<li><a href="#tab-2"><?php echo __('ΠΡΟΓΡΑΜΜΑ','ma-ellak')?></a></li>
  				<?php }?>
  			</ul>
  		</div>
  	</div>
  </div>
  <div class="back-gray">
        <div class="container">
          <div class="row-fluid">
           <div class="tab-content span8 offset1">
              <div id="tab-1" class="tab-pane active">
              	<?php 
              	echo  apply_filters('the_content', $postdata->post_content);
              	 
              	?>
              </div>
              
              <?php if(strlen($program)>6){?>
              <div id="tab-2" class="tab-pane">

				  <?php 
					echo  apply_filters('the_content', 'hello');
					
					if($meta['_ma_event_program_pdf'][0]){
						echo  "<a href='".$meta['_ma_event_program_pdf'][0]."'>";
						echo  __('Κατεβάστε το αρχείο','ma-ellak');
						echo"</a>";
					}
		
				  ?>

              </div>
              <?php }?>
             </div>
           </div>
         </div>
       </div>
	 
	 <?php echo social_output();?>
     
	<?php
  endwhile; else: ?>

		<p>Sorry, no posts matched your criteria.</p>

<?php
  endif;
  
  get_footer();

?>