<?php
/*
Template Name: PressKit - View
*/
?>
<?php get_header(); ?>
<div class="row-fluid">
	<div class="span8">
		<div class="row-fluid">
			<?php 
				echo"<p>";
				echo get_option_tree('ma_ellak_site_description');
				echo"</p>";
			?>
		</div>
		<div class="row-fluid">
			<div class="span6">
			<?php 
			//eikona 
			if(get_option_tree('ma_ellak_site_logo')!=''){
				echo "<h3>";
				echo __("ΛΟΓΟΤΥΠΟ",'ma_ellak');
				echo "</h3>";
				echo "<a href=".get_option_tree('ma_ellak_site_logo').">";
				?>
				<img src="<?php bloginfo('template_directory')?>/images/press/Button_logo_small.png"/>
				<?php 
				echo"</a>";
			}
			
			echo"</div>";
			echo"<div class='span6'>";
			if(get_option_tree('ma_ellak_site_file_description')!=''){
				echo "<h3>";
				echo __("ΠΕΡΙΓΡΑΦΗ",'ma_ellak');
				echo "</h3>";
				echo "<a href=".get_option_tree('ma_ellak_site_file_description')." target='_blank'>";
				
				?>
				<img src="<?php bloginfo('template_directory')?>/images/press/Button_document_small.png"/>
				</a>
				<?php 
			
			}
			echo"</div>";
				
			?>
		</div>
		<div class="row-fluid">&nbsp;</div>
		<div class="row-fluid">
			<div class="span6">
		      <h3><?php _e('Το έργο έως τώρα','ma-ellak');?></h3>
              <?php $data =  ma_ellak_get_number_of_custom_types();?>
              <ul class="unstyled">
              <?php 
              	for($i=0;$i<count($data);$i++){
              		echo"<li>";
              		echo"<span class=\"count rounded\">". $data[$i]['num']."</span> ";
              		if($data[$i]['url']!='#')
              			echo" <a href=".$data[$i]['url'].">".$data[$i]['title']."</a>";
              		else
              			echo $data[$i]['title'];
              		echo"</li>";
              	}
              ?>
              </ul>
			</div><!-- span6  -->
			<div class="span6">
		      <h3><?php _e('Άλλες υπηρεσίες','ma-ellak');?></h3>
              
              <ul>
              
              <?php if(get_option_tree('ma_ellak_moodle')!='') {?>
              	<li><a href="<?php echo get_option_tree('ma_ellak_moodle');?>" target="_blank"><?php echo _e('ΥΠΗΡΕΣΙΑ ΤΗΛΕΚΠΑΙΔΕΥΣΗΣ','ma_ellak');?></a></li>
              <?php }?>
              <?php if(get_option_tree('ma_ellak_redmine')!='') {?>
              	<li><a href="<?php echo get_option_tree('ma_ellak_redmine');?>" target="_blank"><?php echo _e('ΥΠΗΡΕΣΙΑ ΣΥΝΕΡΓΑΣΙΑΣ','ma_ellak');?></a></li>
              <?php }?>
              
              	<?php if(get_option_tree('ma_ellak_view_rss')!=''){?>
              	<li><a href="<?php echo get_option_tree('ma_ellak_view_rss');?>"><?php echo _e('ΌΛΑ ΤΑ ΝΕΑ ΜΕ RSS','ma_ellak');?></a></li>
              	<?php }?>
              	<?php if(get_option_tree('ma_ellak_facebook_share')!='') {?>
              	<li><a href="<?php echo get_option_tree('ma_ellak_facebook_share');?>"><?php echo _e('ΒΡΕΙΤΕ ΜΑΣ ΣΤΟ FACEBOOK','ma_ellak');?></a></li>
              	<?php 
              	}
              	if(get_option_tree('ma_ellak_twitter_user')!=''){?>
              	<li><a href="<?php echo "http://www.twitter.com/".get_option_tree('ma_ellak_twitter_user');?>"><?php echo _e('ΑΚΟΥΣΤΕ ΜΑΣ ΤΟ TWITTER')?></a></li>
              	<?php }?>
              </ul>
			</div><!-- span6  -->
		</div><!-- row-fluid -->
		<div class="row-fluid">
			<div class="span6">
				<h3><?php _e('ΤΕΛΕΥΤΑΙΕΣ ΕΚΔΗΛΩΣΕΙΣ','ma-ellak')?></h3>
					<?php
						echo"<ul class='unstyled'>";
              			$arguments = array(
							'posts_per_page' => 4,
							'post_type' => 'events',
						);
						$unit_posts = get_posts($arguments); 
						foreach( $unit_posts as $post ) {
							setup_postdata($post);
						?>
						  <li>
							<p class='heading'><a href="<?php the_permalink(); ?>" class="btn btn-large btn-link"><?php the_title(); ?></a></p>
							<p class="meta">
							<?php 
							if($post->post_type=='events'){
                                    $data = get_post_meta($post->ID,'_ma_events_type', true);
                                    echo get_posttype_label($post->post_type,$data);
                                    
                            }else 
                                echo get_posttype_label($post->post_type);
                            echo " ";?>
							<span><?php echo ma_ellak_print_thema($cid,'thema');?></span> 
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
			</div><!-- span6 -->
			<div class="span6">
			<h3><?php _e('ΤΕΛΕΥΤΑΙΕΣ ΕΓΓΡΑΦΕΣ','ma-ellak')?></h3>
			<?php
						global  $ma_ellak_content_types; 
						
						unset($ma_ellak_content_types[1]);
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
							<?php echo get_posttype_label($post->post_type); ?>
                            <?php echo ma_ellak_print_thema($cid,'thema');?></span> 
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
			</div><!-- span6 -->
		</div><!-- row-fluid -->
	</div><!-- span8 -->
 	<div class="span4 sidebar">
  				<?php get_sidebar()?>
  	</div><!-- span4 end -->

</div><!-- row-fluid -->
<?php echo social_output();?>
<?php get_footer(); ?>