<?php

  get_header();
  
	global $ma_prefix;

	/* manolis: get all wordpress users. buddypress has no api docs */
	$total_wp_users = count_users();
?>
 <div id="carousel" class="carousel slide">
      <img class="logo absolutionized hidden-tablet hidden-phone" src="<?php echo get_template_directory_uri();?>/images/logo_normal.png" width="283" height="180" alt="Logo Normal" />

      <img class="logo logo-ipad absolutionized hidden-desktop" src="<?php echo get_template_directory_uri();?>/images/logo_ipad.png" width="202" height="128" alt="Logo Ipad" />

      <img src="<?php echo get_template_directory_uri();?>/images/graphic-banner-overlay.png" alt="Logo Overlay" class="caption-overlay"  />

      <div class="carousel-inner">
       <?php 
			$cnt = 0;
			$args = array( 'post_type' => 'slider', 'posts_per_page' => -1, 'suppress_filters'=> false,);
			$myposts = get_posts($args); 
			foreach( $myposts as $post ) { 
				setup_postdata($post); 
				$cnt++;
						
		?>
		 <div class="item <?php if($cnt == 1) echo ' active'; ?>">
			<?php 
			$back_image = get_post_meta($post->ID, $ma_prefix.'slider_image' ,true); 
			if(!empty($back_image) or strlen($back_image)>5){
			?>
			<img src="<?php echo $back_image; ?>" alt="<?php echo apply_filters('the_title',$post->post_title); ?>" class="banner">
		<?php } else { ?>
			 <img src="<?php echo get_template_directory_uri();?>/images/stock-banner-alt.png" alt="<?php echo apply_filters('the_title',$post->post_title); ?>" class="banner">
		<?php } ?>
          <div class="carousel-caption">
            <div class="caption-title">
              <h1><?php echo apply_filters('the_title',$post->post_title); ?></h1>
            </div>
            <div class="caption-body">
              <?php echo apply_filters('the_content',$post->post_content); ?>
						<?php 
						$slider_link = get_post_meta($post->ID, $ma_prefix.'slider_link' ,true); 
						if(!empty($slider_link) or strlen($slider_link)>5){
						?>
							<p><a class="btn btn-large btn-primary" href="<?php echo $slider_link; ?>">
							<?php echo  get_post_meta($post->ID, $ma_prefix.'slider_link_title' ,true); ?></a></p>
						<?php } ?>
            </div><!-- caption-body -->
          </div><!-- carousel-caption -->
        </div><!-- item -->
       <?php }?>
       
      </div><!-- carousel-inner -->
      <a class="left carousel-control" href="#carousel" data-slide="prev"></a>
      <a class="right carousel-control" href="#carousel" data-slide="next"></a>
    </div><!-- carousel -->
    
  <!-- main starts -->
   <div id="main" class="main">
      <div class="container">
               
        <div class="row-fluid">
          <div class="cols clearfix">
            <div class="span4 featurette col stats">
              <h2><?php _e('Το έργο έως τώρα','ma-ellak');?></h2>
              <?php $data =  ma_ellak_get_number_of_custom_types();?>
              <ul class="unstyled">
              <?php 
              
              	for($i=0;$i<count($data);$i++){
              		echo"<li>";
              		echo"<span class=\"count rounded\">". $data[$i]['num']."</span>";
              		echo"<a href=".$data[$i]['url'].">".$data[$i]['title']."</a>";
              		echo"</li>";
              	}
              	
              ?>
                
                <li class="text-right"><img src="<?php echo get_template_directory_uri();?>/images/logo_slim_inverted.png" alt="<?php _e('TΟ ΕΡΓΟ ΣΕ ΑΡΙΘΜΟΥΣ','ma-ellak');?>" /></li>
              </ul>
            </div><!-- span4 feauturette stats -->
            <div class="span4 featurette col events">
              <h2><?php  _e('Εκδηλώσεις','ma-ellak'); ?></h2>
             <div class="datepicker" id="home_calendar">
			   <?php ma_ellak_get_calendar(); ?>			
				</div>
		
				<?php 
				$EventsListId = get_option_tree('ma_ellak_list_event_option_id');
				$EventsUrl=get_permalink($EventsListId) ;
				?>
              <a href="<?php echo $EventsUrl;?>" class="btn btn-tiny btn-inverse btn-more">
				  <?php _e('ΔΕΙΤΕ ΑΝΑΛΥΤΙΚΑ ΟΛΕΣ ΤΙΣ ΕΚΔΗΛΩΣΕΙΣ','ma-ellak');  
				  //echo " ( ".wp_count_posts( 'events' )->publish  ." . __('εκδηλώσεις','ma-ellak' ).' )'; 
				  ?> </a>
            </div><!-- span4 feauturette events -->
			<div class="span4 featurette col users inverse">
              <h2><?php _e('Νέα μέλη','ma-ellak');?></h2>
              <ul class="unstyled mmusers">
			  <?php if ( bp_has_members(  array('type'=> 'newest', 'per_page' => 4, 'max'=> 4 ) )  ) :  while ( bp_members() ) : bp_the_member(); ?>
				<li>
				  <?php 
					$author_meta = get_userdata(bp_get_member_user_id());
					$registration_date = date(MA_DATE_FORMAT, strtotime($author_meta->user_registered));
				?>	
					<p class="thumb pull-left"><?php bp_member_avatar(); /* <img src="<?php echo get_template_directory_uri();?>/images/avatar-default.png" alt=""> */ ?></p> 
					<p class="heading"><a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a></p>
					<p class="meta"><span><strong><?php _e('ΕΓΓΡΑΦΗΚΕ','ma-ellak');?></strong></span> <span><?php echo $registration_date ;  ?></span></p>
                </li>
                <?php endwhile;  else:  endif; ?>   
                </ul>
                <a href="<?php echo $bp->root_domain . '/members/'; ?>" class="btn btn-tiny btn-inverse btn-more">
					<?php _e('ΔΕΙΤΕ ΟΛΑ ΤΑ ΜΕΛΗ','ma-ellak'); ?> (<?php echo $total_wp_users['total_users']; ?>)
				</a>
            </div><!-- span4 featurette users -->
           
          </div><!-- cols -->
        </div><!-- row-fluid -->
        <!-- 2h grammh  -->
        <div class="row-fluid">
          <div class="cols clearfix padded">
            <div class="span4 featurette col">
              <h2><?php _e('Video on demand','ma-ellak');?></h2>
            		<?php 
						ma_ellak_video_get_list_widget(5); 
						$VideoId = get_option_tree('ma_ellak_list_video_option_id');
            		?>
              <a href="<?php echo get_permalink($VideoId);?>" class="btn btn-tiny btn-inverse btn-more"><?php _e('ΔΕΙΤΕ ΟΛΟ ΤΟ VIDEO GALLERY','ma-ellak');  echo " ( ".wp_count_posts( 'video' )->publish ." "; _e('Video','ma-ellak' );?> ) </a>
            </div><!-- featurette -->
            <div class="span4 featurette col news">
              <h2><?php _e('Μέρα με τη μέρα','ma-ellak' ); ?></h2>
              
              <?php
						global  $ma_ellak_content_types; 
						echo"<ul class='unstyled'>";
              			$arguments = array(
							'posts_per_page' => 4,
							'post_type' => $ma_ellak_content_types,
						);
						$unit_posts = get_posts($arguments); 
						foreach( $unit_posts as $post ) {
							setup_postdata($post);
						?>
						  <li>
							<p class='heading'><a href="<?php the_permalink(); ?>" class="btn btn-large btn-link"><?php the_title(); ?></a></p>
							<p class="meta"><span>
							<?php  if($post->post_type=='events'){
                                    $data = get_post_meta($post->ID,'_ma_events_type', true);
                                    echo get_posttype_label($post->post_type,$data);
                                    
                            }else 
                                echo get_posttype_label($post->post_type); ?>
							<?php echo ma_ellak_print_thema($cid,'thema');?></span> 
							<span><?php echo ma_ellak_print_unit_title($post->ID);?></span>
							<span>
							<?php if($post->post_type=='events')
									echo date(MA_DATE_FORMAT,strtotime(get_post_meta( $post->ID, '_ma_event_startdate_timestamp', true )));
								else
									the_date();
								?>	
							</span>
							</p>
						  </li>
				<?php	}
						wp_reset_query();
					?>
             	</ul>
				<?php if(get_option_tree('ma_ellak_all_news')!=''){?>
					<a href="<?php echo get_permalink(get_option_tree('ma_ellak_all_news')); ?>" class="btn btn-tiny btn-inverse btn-more">
						<?php _e('ΔΕΙΤΕ ΤΑ ΤΕΛΕΥΤΑΙΑ ΝΕΑ ','ma-ellak'); ?> 
					</a>
				<?php } ?>
           </div><!-- featurette -->
             <div class="span4 featurette col newsletter inverse">
				<h2><?php _e('Newsletter','ma-ellak');?></h2>
				<?php if (function_exists('wpoi_opt_in')) { wpoi_show_form(); } ?>
            </div><!-- newsletter -->
          </div><!-- cols -->
        </div><!-- row-fluid -->
		
		<div class="row-fluid">
          <div class="span6 text-right">
            <div class="accordion" id="accordion1">
              <div class="accordion-group">
                <div class="accordion-heading">
                  <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne">
                    <h1><?php _e('Θεματικές περιοχές','ma-ellak');?></h1>
                  </a>
                </div><!-- accordion-heading -->
             
                <div id="collapseOne" class="accordion-body collapse">
                  <div class="accordion-inner">
                    <ul class="list-with-icons list-themes unstyled">
						<?php ma_ellak_list_all_thema_as_groups('<li>', '</li>', true); ?>
                    </ul>
                  </div><!-- accordion-inner -->
                </div><!-- collapseOne -->
              </div><!-- accordion-group -->
            </div><!-- accordion -->
          </div><!-- spa6 -->
          <div class="span6 text-left">
            <div class="accordion" id="accordion2">
              <div class="accordion-group">
                <div class="accordion-heading">
                  <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
                    <h1><?php _e('Μονάδες αριστείας','ma-ellak');?></h1>
                  </a>
                </div><!-- accordion-heading -->
                <div id="collapseTwo" class="accordion-body collapse">
                  <div class="accordion-inner">
                    <ul class="list-with-icons list-units unstyled">
						<?php ma_ellak_list_all_units('<li>', '</li>', true); ?>
                    </ul>
                    </div><!-- accordion-inner -->
                </div><!-- collapseOne -->
              </div><!-- accordion-group -->
            </div><!-- accordion -->
          </div><!-- spa6 -->
        </div><!-- row-fludi -->
		
      </div><!-- container -->
    </div><!-- main -->
<?php
  get_footer();
?>
