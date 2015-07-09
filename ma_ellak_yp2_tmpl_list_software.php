<?php
/*
Template Name: Software - List
*/

get_header();

	if (have_posts()) : while (have_posts()) : the_post();
	endwhile; else: endif;
	wp_reset_query();
	
	global $ma_prefix;
	
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;		
	
	$args = array(
		'posts_per_page' => 5,
		'post_type' => 'software',
		'post_status' => 'publish', 
		'paged' => $paged,
		'suppress_filters' => false
	);
	
	$args['meta_query'] = array();
		
	if (isset($_GET['action']) && $_GET['action']=='popular'){
		$args['meta_key'] = 'software_used_by';
		$args['orderby']  = 'meta_value';
        $args['order']    =  'DESC';
	}
	
	if (isset($_GET['submit'])){
		
		$args['tax_query'] = array();
		$args['tax_query']['relation'] = 'AND';
		
		foreach($_GET as $key=>$value){
			
			if($key == 'keyword' or $key=='submit' ) continue;
				
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

	$my_query = new WP_Query($args);
	remove_filter( 'posts_where', 'software_keyword_search', 10, 2 );	
	
?>
<div class="row-fluid">&nbsp;</div>
<div class="row-fluid"><div class="span12">
	<ul class="unstyled inline filters">
		<?php 
			$link_page=get_permalink(get_option_tree('ma_ellak_list_software'));
			if (isset($_GET['sid']) && $_GET['sid']!='')
				$link_page .= '?sid='.$_GET['sid'].'&';
			else
				$link_page .= '?';
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
		<li><a href="<?php bloginfo('rss2_url'); ?>?post_type=software" 
			title="<?php _e('Syndicate this site using RSS'); ?>" target="blank">RSS</a></li>
		<li>|</li>
		<li><a href="<?php bloginfo('atom_url'); ?>?post_type=software" 
			title="<?php _e('Syndicate this site using ATOM'); ?>" target="blank">ATOM</a></li>
						 
			
	</ul>
</div></div>

<div class="row-fluid">
	<div class="span7 char-list offset1">
<?php
		//foreach($posts as $post){ setup_postdata($post);
	if( $my_query->have_posts()) {
		while ($my_query->have_posts()) : $my_query->the_post();
			
			$cid= get_the_ID();
			$post = get_post($cid);
			$meta=get_post_meta($post->ID);
		
		$stars=$meta['ratings_average'][0];
		if (!isset($stars))
			$stars=0;
			
		$views=ma_ellak_show_statistics($post->ID, 'characteristic');
		if (!isset($views))
			$views=0;
			
		$numOfComments = get_comments_number( $post->ID );
		$num_user_edit = 0;
		$num_user_edit = get_post_meta($post->ID, 'software_used_by', true);
		$logo = get_post_meta($post->ID, $ma_prefix . 'software_logo', true);
		
	?>
		<div class="row-fluid event">
			<div class="cols">
			
				<div class="span3 col">
					<?php
						if(!empty($logo))
							echo '<div class="text-center the-date"><a href="'.get_permalink($post->ID).'" title="'.get_the_title().'"><img src="'.$logo.'" /></a></div>' ; 
						else
							echo '<div class="boxed-in text-center the-date"></div>';
					?>
				</div>
				
				<div class="span8 text col">
					<h3><a href="<?php echo get_permalink($post->ID); ?>" rel="bookmark" title="<?php the_title();?>" class="btn btn-large btn-link"><?php the_title(); ?></a></h3>
					<p  class="meta purple seletype">
						<?php ma_ellak_print_unit_title($post->ID);?>
						<?php echo ma_ellak_print_thema($post->ID,'thema');?> 
					</p>
					 <?php  //the_excerpt_max_charlength(250);?>
					<p>	
						<i class="icon-star"></i> <?php echo $stars;?>&nbsp;&nbsp;&nbsp;&nbsp;
						<i class="icon-eye-open"></i> <?php echo $views; ?>&nbsp;&nbsp;&nbsp;&nbsp;
						<i class="icon-comments"></i> <?php echo $numOfComments; ?>&nbsp;&nbsp;&nbsp;&nbsp;
						<i class="icon-download-alt"></i> <?php echo $num_user_edit; ?>
					</p>
				</div>
			</div>
		</div>
		<?php //}
			endwhile;
			
			
		}else {//no posts to show or to_show=false
			_e('Δεν υπάρχουν Γνωρίσματα ή Χαρακτηριστικά με αυτά τα κριτήρια.', 'ma_ellak');
		}
  		
		
		?>
	</div><!-- span8 -->
	
  	<div class="span4">
		<h4><?php _e('Φίλτρα Αναζήτησης'); ?></h4>
		<form action="<?php echo get_permalink(get_option_tree('ma_ellak_list_software')); ?>" method="get" class="span12" id="softwarefilterform">
			<ul>
				<li>
					<label for="keyword"><?php _e('Αναζήτηση', 'ma-ellak'); ?></label>
					<input type="text" value="<?php echo $_GET['keyword']; ?>" name="keyword" id="keyword" autocomplete="off"  />
				</li>
				<li>
					<label for="type"><?php _e('Κατηγορία Λογισμικού', 'ma-ellak'); ?></label>
					<?php 
						wp_dropdown_categories(
							array(
								'walker' => new ma_ellak_Walker_TaxonomyDropdown,
								'show_option_all' => __('Όλες οι Κατηγορίες', 'ma-ellak'),
								'value'=>'slug',
								'show_count'=> 0,
								'orderby'=>'name',
								'name'=> 'type',
								'taxonomy'=> 'type',
								'selected' =>  $wp_query->query['type'],
							)							
						); 
					?>
				</li>
				<li>
					<label for="thema"><?php _e('Θεματική', 'ma-ellak'); ?></label>
					<?php 
						wp_dropdown_categories(
							array(
								'walker' => new ma_ellak_Walker_TaxonomyDropdown,
								'show_option_all' => __('Όλες οι Θεματικές', 'ma-ellak'),
								'value'=>'slug',
								'show_count'=> 0,
								'orderby'=>'name',
								'name'=> 'thema',
								'taxonomy'=> 'thema',
								'selected' =>  $wp_query->query['thema'],
							)							
						); 
					?>
				</li>
				<li>
					<label for="nace"><?php _e('Τομείς Επιχειρηματικής Δραστηριότητας', 'ma-ellak'); ?></label>
					<?php 
						wp_dropdown_categories(
							array(
								'walker' => new ma_ellak_Walker_TaxonomyDropdown,
								'show_option_all' => __('Όλοι οι Τομείς', 'ma-ellak'),
								'value'=>'slug',
								'show_count'=> 0,
								'orderby'=>'name',
								'name'=> 'nace',
								'taxonomy'=> 'nace',
								'selected' =>  $wp_query->query['nace'],
							)							
						); 
					?>
				</li>
				
				<li>
					<label for="licence"><?php _e('Άδεια Χρήσης', 'ma-ellak'); ?></label>
					<?php 
						wp_dropdown_categories(
							array(
								'walker' => new ma_ellak_Walker_TaxonomyDropdown,
								'show_option_all' => __('Όλες οι Άδειες', 'ma-ellak'),
								'value'=>'slug',
								'show_count'=> 0,
								'orderby'=>'name',
								'name'=> 'licence',
								'taxonomy'=> 'licence',
								'selected' =>  $wp_query->query['licence'],
							)							
						); 
					?>
				</li>
				<li>
					<label for="frascati"><?php _e('Επιστημονικά Πεδία', 'ma-ellak'); ?></label>
					<?php 
						wp_dropdown_categories(
							array(
								'walker' => new ma_ellak_Walker_TaxonomyDropdown,
								'show_option_all' => __('Όλα τα Πεδία', 'ma-ellak'),
								'value'=>'slug',
								'show_count'=> 0,
								'orderby'=>'name',
								'name'=> 'frascati',
								'taxonomy'=> 'frascati',
								'selected' =>  $wp_query->query['frascati'],
							)							
						); 
					?>
				</li>
				
				<li>
					<label for="package"><?php _e('Πακέτα Λογισμικού', 'ma-ellak'); ?></label>
					<?php 
						wp_dropdown_categories(
							array(
								'walker' => new ma_ellak_Walker_TaxonomyDropdown,
								'show_option_all' => __('Όλα τα Πακέτα', 'ma-ellak'),
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
					<div class="span12"><input class="btn btn-primary btn-block" name="submit" id="submit" tabindex="5" value="<?php echo attribute_escape(__('Εφαρμογή', 'ma-ellak')); ?>" type="submit"></div>
				</li>
			</ul>
		</form>
	</div>
	<?php 
	if( $my_query->max_num_pages>1){
		pagination(false, false, $my_query);
	}
			?>
 </div>

<?php
  get_footer();
?>