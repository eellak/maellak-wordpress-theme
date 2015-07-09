<?php

function ma_bp_group_list_admins( $group = false ) {
	global $groups_template;

	if ( empty( $group ) )
		$group =& $groups_template->group;

	if ( !empty( $group->admins ) ) { 
		echo '<a href="'.get_bloginfo('url').'/'.$bp->groups->slug . '/' . $group -> slug.'"><img src="'.$result.'" width="50" ></a>' ;
	?>
	<?php foreach( (array) $group->admins as $admin ) { ?>
		<a href="<?php echo bp_core_get_user_domain( $admin->user_id, $admin->user_nicename, $admin->user_login ) ?>"><?php echo bp_core_fetch_avatar( array( 'width'=> 50, 'height'  => 50, 'item_id' => $admin->user_id, 'email' => $admin->user_email, 'alt' => sprintf( __( 'Profile picture of %s', 'buddypress' ), bp_core_get_user_displayname( $admin->user_id ) ) ) ) ?></a>
	<?php } ?>
	<?php } else {  } ?>
<?php
}

function ma_bp_group_list_mods( $group = false ) {
	global $groups_template;

	if ( empty( $group ) )
		$group =& $groups_template->group;

	if ( !empty( $group->mods ) ) : ?>
			<?php foreach( (array) $group->mods as $mod ) { ?>
					<a href="<?php echo bp_core_get_user_domain( $mod->user_id, $mod->user_nicename, $mod->user_login ) ?>"><?php echo bp_core_fetch_avatar( array( 'width'=> 50, 'height'  => 50, 'item_id' => $mod->user_id, 'email' => $mod->user_email, 'alt' => sprintf( __( 'Profile picture of %s', 'buddypress' ), bp_core_get_user_displayname( $mod->user_id ) ) ) ) ?></a>
			<?php } ?>
<?php else : endif;

}

function add_activity_tab() {
	global $bp;
 
	if(bp_is_group()) {
		bp_core_new_subnav_item( 
			array( 
				'name' => __('Δραστηριότητα','ma-ellak'),
				'slug' => 'ellak-activity', 
				'parent_slug' => $bp->groups->current_group->slug, 
				'parent_url' => bp_get_group_permalink( $bp->groups->current_group ), 
				'position' => 11, 
				'item_css_id' => 'nav-ellak-activity',
				'screen_function' => 'my_groups_page_function_to_show_screen',
				'user_has_access' => 1
			) 
		);
	}
}
add_action( 'bp_setup_nav', 'add_activity_tab', 8 );

function my_groups_page_function_to_show_screen() {
	add_action( 'bp_template_title', 'my_groups_page_function_to_show_screen_title' );
	add_action( 'bp_template_content', 'my_groups_page_function_to_show_screen_content' );
	bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}

function my_groups_page_function_to_show_screen_title() {
	_e('Δραστηριότητα','ma-ellak');
}

function my_groups_page_function_to_show_screen_content() { 
	
	global $bp;
	$guid = $bp->group->id;
	$thema_id = ma_ellak_get_thema_id_by_bp_groups_id(bp_get_group_id());
	
	$paged = 1;
	
	if(isset($_GET['pg']) and  $_GET['pg']!='' and is_numeric($_GET['pg']))
		$paged = trim($_GET['pg']);
	
	global  $ma_ellak_content_types; 
	echo"<div class='tab-pane active'>";
	echo"<ul class='unstyled'>";
	$arguments = array(
		'posts_per_page' => 5,
		'post_type' => $ma_ellak_content_types,
		'paged'=>$paged,
		'tax_query' => array(
			array(
			  'taxonomy' => 'thema',
			  'field' => 'id',
			  'terms' => $thema_id,
			)
		  )
	);
	
	$arguments_all = array(
		'posts_per_page' => -1,
		'post_type' => $ma_ellak_content_types,
		'tax_query' => array(
			array(
			  'taxonomy' => 'thema',
			  'field' => 'id',
			  'terms' => $thema_id,
			)
		  )
	);
	
	$arguments_pag = array(
			'posts_per_page' => 5,
		'post_type' => $ma_ellak_content_types,
		'paged'=>$paged,
			'tax_query' => array(
					array(
							'taxonomy' => 'thema',
							'field' => 'id',
							'terms' => $thema_id,
					)
			)
	);
	
	$all_posts = get_posts($arguments_all); 
	$my_query = new WP_Query($arguments_pag);
	$unit_posts = get_posts($arguments); 
	
	$startpost=1;
	$startpost=5*($paged - 1)+1;
	$endpost = (5*$paged < count($all_posts) ? 5*$paged : count($all_posts));
	?>
	
	<?php 
	foreach( $unit_posts as $poster ) {
		setup_postdata($poster); 
	?>
		<li>
			<p><a href="<?php echo doc_permalink($poster->ID); ?>" class="btn btn-large btn-link"><?php echo get_the_title($poster->ID); ?></a></p>
			<p class="meta">
				<span><?php if($poster->post_type=='events'){
                                    $data = get_post_meta($poster->ID,'_ma_events_type', true);
                                    echo get_posttype_label($poster->post_type,$data);
                                    
                            }else 
                                echo get_posttype_label($poster->post_type);?></span> 
				<span><?php echo ma_ellak_print_unit_title($poster->ID);?></span>
				<span>
				<?php 
					if($poster->post_type=='events')
						echo date(MA_DATE_FORMAT,strtotime(get_post_meta( $poster->ID, '_ma_event_startdate_timestamp', true )));
					else
						echo date(MA_DATE_FORMAT,strtotime($poster->post_date)); 
				?>	
				</span>
			</p>
		</li>
<?php	}

	echo '</ul>';

	if( $my_query->max_num_pages>1){
		pagination_buddy(false, false, $my_query);
	}
	
	wp_reset_query();
	echo "</div>";
} 

// Εκτυπώνει τα νούμερα των σελίδων ανάλογα με τον αριθμό των αποτελεσμάτων για κάθε αντικείμενο και εκτελεί το pagination
// Είσοδος:
// 1. $max_page ο αριθμός των σελίδων που προκύπτουν ανάλογα με τον αριθμό των αποτελεσμάτων
// 2. $paged ο αριθμός της εκάστοτε σελίδας
// 3. $wp_query το query που τρέχει για κάθε σελίδα
function pagination_buddy($max_page, $paged, $wp_query){
	?>
	<div class="row-fluid">
		<div class="pagination pagination-centered">
			<ul>
			<?php
				if ( !$max_page )
					$max_page = $wp_query->max_num_pages;
				if(isset($_GET['pg']) and  $_GET['pg']!='' and is_numeric($_GET['pg']))
					$paged = trim($_GET['pg']);
				if ( !$paged )
					$paged = 1;
				
				$nextpage = intval($paged) + 1;
				$current_page = max( 1, $paged );
				
				
				echo'<li><a class="first page button" href="'.bp_get_group_permalink( $bp->groups->current_group ).'ellak-activity/?pg=1">&laquo;</a></li>';
				$prevPage = ($current_page-1 > 0 ? $current_page-1 : 1);
				echo'<li><a class="previous page button" href="'.bp_get_group_permalink( $bp->groups->current_group ).'ellak-activity/?pg='.$prevPage.'">&lsaquo;</a></li>';
				for ($i=1; $i<=$max_page; $i++){
					if ($i==$paged)
						echo"<li class=\"active\">";
					else
						echo"<li>";
					echo"<a href=".bp_get_group_permalink( $bp->groups->current_group )."ellak-activity/?pg=".$i.">";
					echo $i ." ";
					echo"</a></li>";
				}
				$nextPage = $current_page+1 <= $wp_query->max_num_pages ? $current_page+1 : $wp_query->max_num_pages;
				echo "<li><a class='next page button' 
				href=".bp_get_group_permalink( $bp->groups->current_group )."ellak-activity/?pg=".$nextPage.">&rsaquo;</a></li>";
				echo"<li><a class='last page button' href=".bp_get_group_permalink( $bp->groups->current_group )."ellak-activity/?pg=".$wp_query->max_num_pages.">&raquo;</a></li>";
				
			?>
			
			</ul>
		</div> <!--closing links_of_posts div -->
	</div>
<?php
}
?>