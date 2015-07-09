<?php
/*
Template Name: Characteristic - List
*/

get_header();

	if (have_posts()) : while (have_posts()) : the_post();
	endwhile; else: endif;
	wp_reset_query();
	
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;		
	
	global $ma_prefix;
	$software_post;
	$software_id = 0;
	$to_show=true;
	if(isset($_GET['sid']) and $_GET['sid'] !='' and  $_GET['sid'] !=-1){
		$software_post = get_post(intval($_GET['sid']));
		$to_show=false;
		if(!empty($software_post) and 'software' == $software_post->post_type){ 
			$software_id =intval($_GET['sid']);
			$to_show=true;
		}
	}
	
	$args = array(
		'posts_per_page' =>10 ,
		'post_type' => 'characteristic',
		'post_status' => 'publish', 
		'paged' => $paged,
	);
	
	$args['meta_query'] = array();
	
	// Viewing for certain Software only
	if($software_id != 0){
		$args['meta_query'] = array(
			array(
				'key' => $ma_prefix.'for_software',
				'value' => $software_id,
			)
		);
	}
	
	if (isset($_GET['action']) && $_GET['action']=='popular'){
		$args['meta_key'] = 'ratings_average';
		$args['orderby']  = 'meta_value';
		$args['paged']    = $paged ;
        $args['order']    =  'DESC';
		// Meta args
		//$args['meta_query']['relation'] =  'AND';
		//$args['meta_query'][] = array( 'key' => 'ratings_average', 'compare' => '=' );
	}
	
	if (isset($_GET['action']) && isset($_GET['st']) && $_GET['st'] !=''){
		$args['meta_query']['relation'] =  'AND';
		$args['meta_query'][] = array( 'key' => $ma_prefix.'stage_status', 'value' => $_GET['st'], 'compare' => '=' );
	
	}
	if(isset($_GET['sid'])  && $_GET['sid']> 0){
	$args['meta_query']['relation'] =  'AND';
	$args['meta_query'][] = array( 'key' => $ma_prefix.'for_software', 'value' => $_GET['sid'], 'compare' => '=' );
	}

	$my_query = new WP_Query($args);
	

	
?>
<div class="row-fluid">&nbsp;</div>
<div class="row-fluid">
	<div class="span6">
		<ul class="unstyled inline filters">
			<?php 
				$link_page=get_permalink(get_option_tree('ma_ellak_list_characteristic'));
				if (isset($_GET['sid']) && $_GET['sid']!='' && $_GET['sid']!=-1 ){
					$link_page .= '?sid='.$_GET['sid'].'&';
				}else{
					$link_page .= '?';
				}
			?>
			<?php if (isset($_GET['action']) && $_GET['action']!=''){ ?>
				<li><a href="<?php echo $link_page; ?>action=list"><?php _e('ΠΙΣΩ ΣΤΗ ΛΙΣΤΑ', 'ma-ellak');?></a></li>
				<li>|</li>
			<?php }?>
			<li><a href="<?php echo $link_page; ?>action=list" 
			class="<?php if (isset($_GET['action']) && $_GET['action']=='list') echo'active-menu';?>">
			<?php _e('ΠΡΟΣΦΑΤΑ', 'ma-ellak');?></a></li>
			<li>|</li>
			<li><a href="<?php echo $link_page; ?>action=popular"
			class="<?php if (isset($_GET['action']) && $_GET['action']=='popular') echo'active-menu';?>"><?php _e('ΔΗΜΟΦΙΛΗ', 'ma-ellak'); ?></a></li>
			<li>|</li>
			<li>
				<div class="dropdown">
					<a href="<?php echo $link_page; ?>action=status" 
					class="dropdown-toggle <?php if (isset($_GET['action']) && $_GET['action']=='status') echo'active-menu';?>"
					data-toggle="dropdown"><?php _e('ΚΑΤΑΣΤΑΣΗ', 'ma-ellak');?> <b class="caret"></b></a>
					<ul class="dropdown-menu">
					<?php
						$sclass=$pclass=$dclass='';
						if(isset($_GET['st'])){
							if($_GET['st']=='selected') $sclass="class=active-menu";
							else if($_GET['st']=='processed') $pclass="class=active-menu";
							else if($_GET['st']=='done') $dclass="class=active-menu";
						}
						echo "<li><a href=\"". $link_page ."action=status&st=selected\" $sclass>" .  __('Ανάληψη', 'ma-ellak'). "</a></li>";
						echo "<li><a href=\"". $link_page ."action=status&st=processed\" $pclass>" .  __('Σε εξέλιξη', 'ma-ellak'). "</a></li>";
						echo "<li><a href=\"". $link_page ."action=status&st=done\" $dclass>" .  __('Ολοκληρωμένο', 'ma-ellak'). "</a></li>";
					?>
					</ul>
				</div>
			</li>
			<li>|</li>
			<li>
				<div class="dropdown">
					<a href="<?php echo $link_page; ?>sel=software" 
					class="dropdown-toggle <?php if (isset($_GET['sel']) && $_GET['sel']=='software') echo'active-menu';?>"
					data-toggle="dropdown"><?php _e('ΛΟΓΙΣΜΙΚΟ', 'ma-ellak');?> <b class="caret"></b></a>
					<ul class="dropdown-menu">
					<?php
						$allSoftware = get_all_unique_software();
						if (isset($_GET['sid']) && $_GET['sid']=='')
							echo "<li><a href=\"". $link_page ."sel=software&sid=\" class='active-menu'>" .  __('Όλα', 'ma-ellak'). "</a></li>";
						else	
							echo "<li><a href=\"". $link_page ."sel=software&sid=\">" .  __('Όλα', 'ma-ellak'). "</a></li>";
						for($i=0;$i<count($allSoftware);$i++){
							if (isset($_GET['sid']) && $_GET['sid']==$allSoftware[$i]['id'] && $_GET['sid']!='')
								echo "<li><a href=\"". $link_page ."sel=software&sid=".$allSoftware[$i]['id']."\" class='active-menu'>".$allSoftware[$i]['title']."</a></li>";
							else
								echo "<li><a href=\"". $link_page ."sel=software&sid=".$allSoftware[$i]['id']."\">".$allSoftware[$i]['title']."</a></li>";
						}
					?>
					</ul>
				</div>
			</li>
		</ul>
		
	</div>
	
	<div class="span6">
	<?php if($software_id != 0){ ?>
		<?php echo __('ΑΦΟΡΑ ΤΟ ΛΟΓΙΣΜΙΚΟ','ma-ellak');?>:
			<a href="<?php echo get_permalink($software_id) ?>" rel="bookmark" title="<?php echo get_the_title($software_id);?>" class="btn btn-large btn-link">
				 <?php echo get_the_title($software_id); ?>
			</a>
	<?php } ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span10 char-list">
	
<?php
		//foreach($posts as $post){ 
	if( $my_query->have_posts() && $to_show==true ) {
			while ($my_query->have_posts()) : $my_query->the_post();
			
				//setup_postdata($post);
				$cid= get_the_ID();
				$post = get_post($cid);
				$meta=get_post_meta($post->ID);
				//get the number of stars
				$stars=$meta['ratings_average'][0];
				if (!isset($stars))
					$stars=0;
				//get the number of views	
				$views=ma_ellak_show_statistics($post->ID, 'characteristic');
				if (!isset($views))
					$views=0;
				$numOfComments = get_comments_number( $post->ID );
				global $ma_prefix;
				$gnorisma_id = get_the_ID();
				$type = get_post_meta($gnorisma_id, $ma_prefix.'characteristic_type', true);
				$status =  get_post_meta($gnorisma_id, $ma_prefix.'stage_status', true);
			
		?>
			<div class="row-fluid event">
				<div class="cols">
					<div class="span2 col" >
							<h3 class="magenta" style="float:right"><i class="icon-star"></i> <?php echo $stars;?></h3>
					</div>
					<div class="span10 text col">
						<h3><a href="<?php echo get_permalink($post->ID); ?>" rel="bookmark" title="<?php the_title();?>" class="btn btn-large btn-link"><?php the_title(); ?></a>
						<?php 
								if(!empty($status)){
									echo get_status_name($status);
								}
						?>
						</h3>
						<p  class="meta purple seletype">
							<?php if(!empty($type)){
									echo "<p><span class='mob'>";
									if($type=='gnorisma') _e('Γνώρισμα', 'ma-ellak');
									else _e('Χαρακτηριστικό', 'ma-ellak');
									echo "</span></p>";
								}?>
							<?php _e('ΑΦΟΡΑ ΤΟ', 'ma-ellak'); ?>&nbsp;&nbsp;</span>
							<?php echo get_about_software(); ?>
							<?php echo get_all_about_software();?>
						</p>
						 <?php  the_excerpt_max_charlength(250);?>
						<p>	
							<i class="icon-eye-open"></i> <?php echo $views; ?>&nbsp;&nbsp;&nbsp;&nbsp;
							<i class="icon-comments"><?php echo $numOfComments ?></i>
						</p>
					</div>
				</div>
			</div>
	  		<?php //}
			endwhile;
			if( $my_query->max_num_pages>1){
				pagination(false, false, $my_query);
			}
			
		}else {//no posts to show or to_show=false
			_e('Δεν υπάρχουν Γνωρίσματα ή Χαρακτηριστικά με αυτά τα κριτήρια.', 'ma_ellak');
		}
		wp_reset_query();  // Restore global post data stomped by the_post().
		?>
	</div><!-- span8 -->
  	<div class="span4">
		<?php  //echo show_latest_characteristics(); ?>
	</div>
	
 </div>

<?php
  get_footer();
?>