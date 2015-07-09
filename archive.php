<?php

  /**
  *@desc A single blog post See page.php is for a page layout.
  */

  get_header();
  
  
  ?>
  <div class="row-fluid">
  <div class="span8">
  
  

  <?php 
  if (have_posts()) : while (have_posts()) : the_post();
	$start = strtotime(get_the_date());
	$startd = date(MA_DATE_FORMAT,$start);
	$SdateD = date('d',$start);
	$SdateM = date('m',$start);
	$Sdate = explode('/',$startd);
	
  ?>

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
	       title="<?php the_title();?>" class="btn btn-large btn-link"><?php the_title(); ?></a></h3>
	       <p  class="meta purple">
	     
	       <?php echo ma_ellak_print_unit_title($cid);?>  
		       <?php echo ma_ellak_print_thema($cid,'thema');?>
	       <?php echo $startd; if($endd) echo"-". $endd;?></p>
	       <?php  the_excerpt_max_charlength(240);?>
	       
	    </div><!-- span8 text col -->
	     </div><!-- cols -->
	   </div><!-- row-fluid event -->
	    <div class="row-fluid">
 			<p><?php //edit_post_link(__('Edit'), ''); ?></p>
 			
		</div>
	
	<?php
	  endwhile; else: ?>
  		<p> <?php _e('Δεν υπάρχει περιεχόμενο','ma-ellak');?></p>
  		 <?php endif; ?>
  </div><!-- span8 -->
  	<div class="span4 sidebar">
  		<?php get_sidebar()?>
		<br/><br/>
  		</div><!-- span4 end -->
 </div><!-- row-fluid -->
 <?php 
 next_posts_link(); 
 previous_posts_link();
 ?>
<?php

  get_footer();

?>