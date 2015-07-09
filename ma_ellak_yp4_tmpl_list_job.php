<?php
/*
Template Name: Job - List
*/

get_header();

	if (have_posts()) : while (have_posts()) : the_post();
	endwhile; else: endif;
	wp_reset_query();
	
	global $ma_prefix;
	
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;		
	
	$args = array(
		'posts_per_page' => 5,
		'post_type' => 'job',
		'post_status' => 'publish', 
		'paged' => $paged,
		'suppress_filters' => false
	);
	
	if (isset($_GET['submit'])){
		
		$args['tax_query'] = array();
		$args['tax_query']['relation'] = 'AND';
		
		foreach($_GET as $key=>$value){
			
			if($key == 'keyword' or $key=='submit') continue;
			if( $value == '' or $value == '0' ) continue;
			
			$args['tax_query'][] = array(
				'taxonomy' => $key,
				'field' => 'slug',
				'terms' => $value
			);
		}
	
		if (isset($_GET['keyword']) and $_GET['keyword'] != '')
			add_filter( 'posts_where', 'software_keyword_search', 10, 2 );	
	}
	
	if (isset($_GET['action']) && isset($_GET['st']) && $_GET['st'] !=''){
		$args['meta_query']['relation'] =  'AND';
		$args['meta_query'][] = array( 'key' => $ma_prefix.'job_status', 'value' => $_GET['st'], 'compare' => '=' );
	}
	
	
	//$posts = get_posts($args);
	$my_query = new WP_Query($args);
	
	remove_filter( 'posts_where', 'software_keyword_search', 10, 2 );	
	
?>
<div class="row-fluid">&nbsp;</div>
<div class="row-fluid">
	<div class="span12">
		<ul class="unstyled inline filters">
			<?php 
				$link_page=get_permalink(get_option_tree('ma_ellak_list_jobs'));
			?>
			<?php if (isset($_GET['action']) && $_GET['action']!=''){ ?>
				<li><a href="<?php echo $link_page; ?>?action=list"><?php _e('ΠΙΣΩ ΣΤΗ ΛΙΣΤΑ', 'ma_ellak');?></a></li>
				<li>|</li>
			<?php }?>
			<li>
				<div class="dropdown">
					<a href="<?php echo $link_page; ?>action=status" 
					class="dropdown-toggle <?php if (isset($_GET['action']) && $_GET['action']=='status') echo'active-menu';?>"
					data-toggle="dropdown">
					<?php _e('ΚΑΤΑΣΤΑΣΗ', 'ma_ellak');?> <b class="caret"></b></a>
					<ul class="dropdown-menu">
					<?php
						$aclass=$pclass=$dclass=$iclass='';
						if(isset($_GET['st'])){
							if($_GET['st']=='active') $aclass="class=active-menu";
							else if($_GET['st']=='processed') $pclass="class=active-menu";
							else if($_GET['st']=='done') $dclass="class=active-menu";
							else if($_GET['st']=='inactive') $iclass="class=active-menu";
						}
						echo "<li><a href=\"". $link_page ."?action=status&amp;st=active\" $aclass>" .  __('Ενεργή', 'ma_ellak'). "</a></li>";
						echo "<li><a href=\"". $link_page ."?action=status&amp;st=processed\" $pclass>" .  __('Σε εξέλιξη', 'ma_ellak'). "</a></li>";
						echo "<li><a href=\"". $link_page ."?action=status&amp;st=done\" $dclass>" .  __('Ολοκληρωμένη', 'ma_ellak'). "</a></li>";
						echo "<li><a href=\"". $link_page ."?action=status&amp;st=inactive\" $iclass>" .  __('Μη Ενεργή', 'ma_ellak'). "</a></li>";
					?>
					</ul>
				</div>
			</li>
		</ul>
	</div>
</div>
<div class="row-fluid">
	<div class="span3">
		<h3><?php _e('Αναζήτηση','ma_ellak'); ?></h3>
		<form action="<?php echo get_permalink(get_option_tree('ma_ellak_list_jobs')); ?>" method="get" class="span12" id="softwarefilterform">
			<ul>
				<li>
					<label for="keyword"><?php _e('Αναζήτηση', 'ma_ellak'); ?></label>
					<input type="text" value="<?php echo $_GET['keyword']; ?>" name="keyword" id="keyword" autocomplete="off"  />
				</li>
				<li>
					<label for="jobtype"><?php _e('Τύπος Εργασίας', 'ma_ellak'); ?></label>
					<?php 
						wp_dropdown_categories(
							array(
								'walker' => new ma_ellak_Walker_TaxonomyDropdown,
								'show_option_all' => __('Όλοι οι Τύποι', 'ma_ellak'),
								'value'=>'slug',
								'show_count'=> 0,
								'orderby'=>'name',
								'name'=> 'jobtype',
								'taxonomy'=> 'jobtype',
								'selected' =>  $wp_query->query['jobtype'],
							)							
						); 
					?>
				</li>				
				<li>
					<label for="package"><?php _e('Πακέτα Λογισμικού', 'ma_ellak'); ?></label>
					<?php 
						wp_dropdown_categories(
							array(
								'walker' => new ma_ellak_Walker_TaxonomyDropdown,
								'show_option_all' => __('Όλα τα Πακέτα', 'ma_ellak'),
								'value'=>'slug',
								'show_count'=> 0,
								'orderby'=>'name',
								'name'=> 'package',
								'taxonomy'=> 'package',
								'selected' =>  $wp_query->query['package'],
							)							
						); 
					?>
				</li>
				<li>
					<div class="span12"><input class="btn btn-primary btn-block" name="submit" id="submit" tabindex="5" value="<?php echo attribute_escape(__('Αναζήτηση', 'ma_ellak')); ?>" type="submit"></div>
				</li>
			</ul>
		</form>
	</div>
	
	<div class="span5 char-list">
<?php

	if( $my_query->have_posts()) {
		while ($my_query->have_posts()) : $my_query->the_post();
			
		$cid= get_the_ID();
		$post = get_post($cid);

global $ma_prefix;
	//	foreach($posts as $post){ 
	//		setup_postdata($post);
		
		$views=ma_ellak_show_statistics($post->ID, 'job');
		if (!isset($views))
			$views=0;
		
		$AllData = get_post_meta($post->ID);
		$job_foreas = $AllData['_ma_job_contact_point_foreas'][0];
		$job_expiration = $AllData['_ma_job_expiration'][0];
		$job_status = $AllData['_ma_job_status'][0];
		?>
		<div class="row-fluid event">
			<div class="cols">				
				<div class="span11 back-purple jobslist">
				<?php 	echo get_job_status_name($job_status); ?>
					<h3><a href="<?php echo get_permalink($post->ID); ?>" rel="bookmark" title="<?php the_title();?>" ><?php the_title(); ?></a></h3>
					<?php
						if ($job_foreas!=''){
					?>
					<p  class="meta black strong">
						<strong><?php _e('ΦΟΡΕΑΣ', 'ma_ellak'); ?></strong>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo  $job_foreas;?>
					</p>
					<?php
					}
					?>
					<?php
						if($job_expiration!=''){?>
							<strong><?php _e('Ημερομηνία λήξης', 'ma_ellak'); ?></strong>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo  mysql2date('j/m/Y',$job_expiration);?>
					<?php }?>
					
					<p  class="meta black strong"></p>
					 <?php  //the_excerpt_max_charlength(250);?>
					<p>	
						<i class="icon-eye-open"></i> <?php echo $views; ?>&nbsp;&nbsp;&nbsp;&nbsp;
					</p>
					<p>
						<?php 
							$jobtype = wp_get_post_terms(get_the_ID(), 'jobtype');
							if(count($jobtype) != 0){ ?>
						<li><span><strong><?php _e('Τύπος Εργασίας', 'ma_ellak'); ?></strong></span>&nbsp;&nbsp;&nbsp;<?php 
								foreach ($jobtype  as $term)
									echo ''.$term->name .'' ; ?>
						</li>
						<?php } ?>
					</p>
					<p>
						<?php 
							$package = wp_get_post_terms(get_the_ID(), 'package');
							if(count($package) != 0){ ?>
						<li><span><strong><?php _e('Πακέτα Λογισμικού', 'ma_ellak'); ?></strong></span>&nbsp;&nbsp;&nbsp;<?php 
								foreach ($package  as $term)
									echo '&nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;'.$term->name .'' ; ?>
						</li>
						<?php } ?>
					</p>
				</div>
			</div>
		</div>
  		<?php //}
			endwhile;
	
	}else{
	
			_e('Δεν εντοπίστηκε Προσφορά με αυτά τα κριτήρια.', 'ma_ellak');
		}
		?>
	</div>
		
	<div class="span4 featurette col stats">
       <?php $stats = get_job_stats();?>
       <ul class="unstyled">
       <li><span class="count rounded"><?php echo $stats['all']; ?></span> <?php _e('Όλες','ma_ellak');?></li>
       <li><span class="count rounded"><?php echo $stats['active']; ?></span> <?php _e('Ενεργές','ma_ellak');?></li>
       <li><span class="count rounded"><?php echo $stats['processed']; ?></span> <?php _e('Σε εξέλιξη','ma_ellak');?></li>
       <li><span class="count rounded"><?php echo $stats['done']; ?></span> <?php _e('Ολοκληρωμένες','ma_ellak');?></li>
       <li><span class="count rounded"><?php echo $stats['inactive']; ?></span> <?php _e('Μη Ενεργές','ma_ellak');?></li>
    	</ul>
   </div>
   
  
  <?php 
	if( $my_query->max_num_pages>1){
		pagination(false, false, $my_query);
	}
			?>
	
 </div>
 
<?php
echo social_output();

  get_footer();
?>