<?php

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
  $EvaluationFormPostId = get_option_tree('ma_ellak_view_participation_option_id');
  $cid = get_the_ID();
  $post_item = get_post_type($cid);
  $meta = get_post_meta(get_the_ID());
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
  
  $today = strtotime(date(MA_DATE_FORMAT));
  
  if($meta['_ma_event_evaluation'][0]=='on' && $today>=strtotime($endd))
  	$evaluation_form = esc_url(get_permalink($EvaluationFormPostId)).'?events_id='.get_the_ID();
  if($meta['_ma_events_participate'][0]=='yes' && $today < strtotime($endd))
  $participation_form = $meta['_ma_events_participate'][0]=='no'?'':esc_url( get_permalink($ParticipationFormPostId) ).'?events_id='.get_the_ID();
  $program = strlen($meta['_ma_event_title_program_desc'][0])<6?'':$meta['_ma_event_title_program_desc'][0];
  $thistime = strtotime($startd);
  $currenttime= strtotime(date(MA_DATE_FORMAT));
 	//echo $currenttime ." Thistime=". $currenttime;
 	
  $argsQuery=array(
  		'post_type' => 'video',
  		'post_status' => 'publish',
  		'caller_get_posts'=> 1,
  		'meta_key' => '_ma_video_events_stream',
  		'orderby' => 'meta_value',
  		'order' => 'ASC',
  		'meta_query' => array(
  				'relation' => 'AND',
  				array(
  						'key' => '_ma_video_events_stream',
  						'value'=> $cid,
  						'compare' => '=',
  							
  				)
  		)
  			
  );
  $video_query = new WP_Query($argsQuery);
  
   ?>
  
  <div class="row-fluid filters">
          <div class="span6">
            <p><a href="<?php echo get_permalink(get_option_tree('ma_ellak_list_event_option_id'))?>">ΠΙΣΩ ΣΤΗ ΛΙΣΤΑ</a></p>
          </div>
   </div>
   <div class="row-fluid event">
		  	<div class="cols">
		  		<div class="span4 col">
		  			<div class="boxed-in text-center the-date">
					  	<h3 class="white"><?php echo  $SdateD;?></h3>
					  	<h4 class="magenta"><?php echo  ma_ellak_events_return_month($SdateM);?></h4>
					</div>
		 		</div><!-- span4 col -->
		 		<div class="span8 text col">
					  <h3><a href="<?php the_permalink() ?>" rel="bookmark" 
				  	title="<?php the_title_attribute();?>" class="btn btn-large btn-link"><?php the_title(); ?></a>
				  	<a href="?ical&eid=<?php echo$cid; ?>" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/btn_ical.png" width="24" height="15" alt="ical"/></a>
				  	<?php echo  ma_ellak_single_edit_permalink();?>
				  	</h3>
				  	  <p  class="meta purple">
					  <?php get_event_type_label($event_type);
						?>
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
					   <div class="under">
          		    	<?php ma_ellak_social_print_data ($cid, 'events', 'listview');?>
	          		  </div>
					  <p>&nbsp;</p>
					  <?php 
					  if($participation_form){
					  	echo"<p><strong><a href='".$participation_form."' class='btn btn-primary btn-block'>";
					  	echo __('Δήλωση Συμμετοχής','ma-ellak');
					  	echo"</a></strong></p>";
					  
					  }
					  
					  if($evaluation_form){
					  	echo"<p><strong><a href='".$evaluation_form."' class='btn btn-primary btn-block'>";
					  	echo __('Αξιολογήστε','ma-ellak');
					  	echo"</a></strong></p>";
					  		
					  }
					  ?>
					  <?php if($meta['_ma_event_live'][0]=='on'){ ?>
						<div class="alert alert-info"> <p><?php echo __('Η εκδήλωση ειναι προγραμματισμένη να έχει <strong>Live Streaming</strong>.','ma-ellak')?></p></div>
					<?php
					  } ?>
					  <?php ma_ellak_print_tags();?>
						
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
				
				<?php if( $video_query->have_posts() ) {?>
  					<li><a href="#tab-3"><?php echo __('ΣΧΕΤΙΚΑ ΒΙΝΤΕΟ','ma-ellak')?></a></li>
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
              	echo  apply_filters('the_content', get_post($post->ID)->post_content);
              	?>
              </div>
              
              <?php if(strlen($program)>6){?>
              <div id="tab-2" class="tab-pane">
              	<?php include('ma_ellak_events_tmpl_program.php');?>
              </div>
              <?php }?>
			  
			  <?php
				if( $video_query->have_posts() ) {
			?>
				<div id="tab-3" class="tab-pane">
			<?php
					$count=0;
					while ($video_query->have_posts()) : $video_query->the_post();
					$videoId= get_the_ID();
					?>
					<?php echo "<br/>&nbsp;".__('Σχετικό Video','ma-ellak')." : ";?><a href=<?php echo get_permalink($videoId);?>/><?php echo get_the_title($videoId);?></a>
					<?php 
					endwhile; ?>
				</div>
			<?php
				}
			  ?>
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