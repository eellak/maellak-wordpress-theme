<?php
/**
* Αρχείο Προβολής Στοιχείων Βίντεο
*
* @licence GPL
* 
* Project URL http://ma.ellak.gr
*/
	get_header();
	if (have_posts()) : while (have_posts()) : the_post();
		$post_id=get_the_ID();
		$meta = get_post_custom($post_id);
		$video_stream = $meta['_ma_video_events_stream'][0];
	
		if ($meta['_ma_video_date'][0]!='')
			$date_m=date("d.m.Y", strtotime($meta['_ma_video_date'][0]));
		else
			$date_m='';
		
		$url=$meta['_ma_video_url'][0];
		$duration=$meta['_ma_video_duration'][0];
		if (isset($duration)){
			$duration_data=explode(":", $duration);
			$hours=$duration_data[0];
			$minutes=$duration_data[1];
			$seconds=$duration_data[2];

			$dur='';
			$separator=':';
			$hours_n=$minutes_n=$seconds_n='00';
			$dur=$hours_n;
			if ($hours!='')
				$dur=$hours;

			if ($minutes!='')
				$dur.=$separator . $minutes;
			else
				$dur.=$separator . $minutes_n;

			if ($seconds!='')
				$dur.=$separator . $seconds;
			else
				$dur.=$separator . $seconds_n;
		}
		$embed=pv_show_video($url,$post_id,$mode='post');
		$a_embed=str_replace("<","&lt;",$embed);
		$f_embed=str_replace(">", "&gt;", $a_embed);
		$embed_url=ma_ellak_video_get_embedded_video($url);
		$link_list_video_page=get_permalink(get_option_tree('ma_ellak_list_video_option_id'));
		?>
		<div class="row-fluid filters">
			<div class="span6">
				<p><a href="<?php echo $link_list_video_page; ?>"><?php _e('ΠΙΣΩ ΣΤΗ ΛΙΣΤΑ', 'ma-ellak');?></a></p>
			</div>
			<div class="dropdown pull-right">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php _e('ΚΑΤΗΓΟΡΙΕΣ', 'ma-ellak');?><b class="caret"></b></a>
					<ul class="dropdown-menu">
						<?php
							$terms = get_terms('thema',array( 'hide_empty' => false ));
							foreach ( $terms as $term )
								echo "<li><a href=\"". $link_list_video_page ."?action=listthema&term=". $term->term_id ."\">" . $term->name . "</a></li>";
						?>
					</ul>
			</div>
		</div>
		
		<div class="row-fluid">
          <div class="span8">
            <h3><?php echo get_the_title($post_id); ?>
            <?php echo  ma_ellak_single_edit_permalink();?>
            
            </h3>
				<?php ma_ellak_print_unit_title($post_id);?>
				<?php echo ma_ellak_print_thema($post_id,'thema');?>
				<?php echo $date_m; ?>
				<?php if($video_stream){?>
				<br/>
				<?php echo "&nbsp;".__('Σχετική Εκδήλωση','ma-ellak').":";?><a href=<?php echo get_permalink($video_stream);?>/><?php echo get_the_title($video_stream);?></a>
				<?php }?>
          </div>
        </div>
        <div class="row-fluid">
      		<br/>
        </div>
		
        <div class="row-fluid">
          <div class="span8">
            <div class="video-wrap">
              <iframe src="<?php echo $embed_url; ?>" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
            </div>
			
			<?php ma_ellak_social_print_data ($post_id, 'mavideo', 'purple');?>
			<?php 	echo social_output();?>
			<div id="showEmbed" style='display:none;'>
				<p>
				<?php _e('Διαλέξτε τον κώδικα που βρίσκετε στο κουτί για να το χρησιμοποιήσετε στο δικτυακό σας τόπο.','ma-ellak');?>
				</p>
				<textarea rows="5" >
				<?php 
				$embed=pv_show_video($url,$post_id,$mode='post');
				$a_embed=str_replace("<","&lt;",$embed);
				$f_embed=str_replace(">", "&gt;", $a_embed);
				echo $f_embed;
			
				?>
				</textarea>
				
			</div>
			
			<?php if(get_the_content()!='') {?>
            <div class='video snippet'>
	            <div class="txt">
	              <?php echo the_content();?>
	            </div>
            </div>
            <?php } ?>
            <?php echo ma_ellak_print_tags($post_id)?>
            <?php comments_template();?>
            
          </div>
           <div class="span4 sidebar">
  				<?php get_sidebar()?>
  			</div><!-- span4 end -->
		</div>
<?php
	endwhile; else: ?>
		<p>Sorry, no posts matched your criteria.</p>
	<?php
	endif;
	echo"<div class='row-fuid'>&nbsp;</div>";
get_footer();
	
function ma_ellak_video_get_embedded_video($url){
	if (preg_match('/\b(youtube)\.com\b/i', $url)){
		$video_id=explode("http://www.youtube.com/watch?v=", $url);
		$embed_url="https://www.youtube.com/embed/" . $video_id[1];
	}
	else if (preg_match('/\b(vimeo)\.com\b/i', $url)){
		$video_id=explode("http://vimeo.com/", $url);
		$embed_url="https://player.vimeo.com/video/" . $video_id[1];
	}
	return $embed_url;
}
?>
