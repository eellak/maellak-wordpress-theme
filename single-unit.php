<?php
/**
* Αρχείο Προβολής Στοιχείων Μονάδας Αριστείας
*
* @licence GPL
* @author Fotis Routsis - fotis@routsis.gr
* 
* Project URL http://ma.ellak.gr
*/

  get_header();
	
	global $post;
	$is_current_admin = is_current_user_admin();
	$is_manage_page = false;
	$user_unit_id = $post->ID;
	
	// Accept Member Request
	if(isset($_POST['user_unit_save']) and  $is_current_admin ) { 
	
		$user_id =  esc_attr($_POST['admin_id']);
		$unit_id = esc_attr($_POST['unit_id']);
		
		// Αφαίρεσε το request
		delete_user_meta( $user_id, '_ma_ellak_member_unit_request' );
		
		// Κάνε τον Μέλος στα BP Groups που αντιστοιχίζονται στη ΜΑ
		$bp_group_ids = ma_ellak_get_bp_groups_thema_ids($unit_id);
		if(function_exists('groups_accept_invite')) {
			foreach($bp_group_ids as $bp_group)
				groups_accept_invite( $user_id, $bp_group);
		}
		// Κάνε τον Μέλος στη ΜΑ
		update_user_meta( $user_id, '_ma_ellak_member_unit',  $unit_id );
		
	} 
	
	// Discard Member Request
	if(isset($_POST['user_unit_discard']) and  $is_current_admin ) { 
		$user_id =  esc_attr($_POST['admin_id']);
		$unit_id = esc_attr($_POST['unit_id']);
		
		// Αφαίρεσε το request η τη Συνδρομή
		delete_user_meta( $user_id, '_ma_ellak_member_unit_request' );
		delete_user_meta( $user_id, '_ma_ellak_member_unit' );
	}
	
	if(isset($_GET['members']) or isset($_GET['content']) or isset($_GET['settings'])){ if( $is_current_admin) $is_manage_page = true; }

  if (have_posts()) : while (have_posts()) : the_post();
  ?>
  
        <div class="row-fluid">
          <div class="cols">
            <div class="span4 col side-left">
				
				<?php $details = ma_ellak_get_unit_details('field');  ?>
				<p><img src="<?php echo $details['Λογότυπο']; ?>"></p>
				<p><?php _e('ΣΥΜΜΕΤΕΧΕΙ','ma-ellak'); ?>: 
					<?php 
						$main_thema = get_post_meta( $post->ID, '_ma_unit_main_thema', true);
						/*
						$terms = get_the_terms( $post->ID, 'thema' ); 
						if ( $terms && ! is_wp_error( $terms ) ) : 

						$thema_links = array();

						foreach ( $terms as $term ) {
							if( $term->term_id == $main_thema)
								$thema_links[] = '<strong>'.ma_ellak_get_thema_link($term->term_id, true, true).'</strong>'; // Κύρια
							else
								$thema_links[] = ma_ellak_get_thema_link($term->term_id, true, true); 
								
							
						}
						$themaz = join( ", ", $thema_links );
						echo $themaz; 
						*/						
						$bp_idz = ma_ellak_get_bp_groups_thema_ids();
						$main_list = '';
						$thema_list = '';

						foreach($bp_idz as $bp_id){
		
							$avatar_options = array ( 'item_id' => $bp_id, 'object' => 'group', 'type' => 'full', 'avatar_dir' => 'group-avatars', 'alt' => 'Group avatar', 'css_id' => 1234, 'class' => 'avatar', 'width' => 50, 'height' => 50, 'html' => false );

							$result = bp_core_fetch_avatar($avatar_options);
							
							global $bp;							
							$group = groups_get_group( array( 'group_id' => $bp_id ) );

							if($main_thema == ma_ellak_get_thema_id_by_bp_groups_id($bp_id))
								$main_list .= '<a href="'.get_bloginfo('url').'/'.$bp->groups->slug . '/' . $group -> slug.'" class="thema-list main-thema"><img src="'.$result.'" width="50" ></a>' ;
							
							else
								$thema_list .= '<a href="'.get_bloginfo('url').'/'.$bp->groups->slug . '/' . $group -> slug.'" class="thema-list"><img src="'.$result.'" width="50" ></a>' ;
						}
						echo $main_list.$thema_list;
						/*
					?>
					*/	?>
				</p>
				<br />
				 <h2><?php the_title(); ?></h2>
			 <div class="alert alert-info"> <p>
			<?php 
				echo ma_ellak_is_member_on_unit(); 
				if( $is_current_admin){
					echo '<a href="'.ma_ellak_edit_permalink($post->ID, $post->post_type).'" class="btn btn-success btn-mini ma_ellak_edit">'.__('Επεξεργασία','ma-ellak').'</a>';
				}
			?></p></div>
              <?php the_content(__('(more...)')); ?>
			  <?php /*
              <p>ΣΥΜΜΕΤΟΧΗ <?php //echo ma_ellak_is_member_on_unit(); ?></p>
			  */ ?>
            </div>
            <div class="span8 col side-right">
            <h2><?php the_title(); ?> | Εργασίες Μονάδας Αριστείας</h2>
            <div class="colfirst">
<h3>Εκδηλώσεις</h3>
            
            <?php
						
						global $ma_ellak_content_types;
						$cid = $post->ID;
						$arguments = array(
							'posts_per_page' => 5,
							'post_type' =>  'events',
							'meta_key' => '_ma_ellak_belongs_to_unit',
							'meta_value' => $cid,
						);
						$unit_posts = get_posts($arguments); 
						foreach( $unit_posts as $post ) { 
							setup_postdata($post); 
						?>
						  <li>
						  <p class="meta">
							
								<span><?php  if($post->post_type=='events'){
				                    $data = get_post_meta($post->ID,'_ma_events_type', true);
				                
				                    echo get_posttype_label($post->post_type,$data);
				                        
				                }else
				                    echo get_posttype_label($post->post_type);
				                ?></span> 
								<small><span><?php echo ma_ellak_print_thema($post->ID,'thema');?></span> <span><?php the_date(); ?></span></p></small>
							<p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><?php ma_ellak_single_edit_permalink($post); ?></p>
							<!--
							<p class="meta">

								<span><?php  if($post->post_type=='events'){
				                    $data = get_post_meta($post->ID,'_ma_events_type', true);
				                
				                    echo get_posttype_label($post->post_type,$data);
				                        
				                }else
				                    echo get_posttype_label($post->post_type);
				                ?></span> 
				                <small><span><?php echo ma_ellak_print_thema($post->ID,'thema');?></span> <span><?php the_date(); ?></span></p></small>-->
						  </li>
				<?php	}
						wp_reset_query();
					?>
					</div>
            <div class="colfirst">
<h3>Βιβλιοθήκη αρχείων</h3>
            
            <?php
						
						global $ma_ellak_content_types;
						$cid = $post->ID;
						$arguments = array(
							'posts_per_page' => 5,
							'post_type' =>  'document',
							'meta_key' => '_ma_ellak_belongs_to_unit',
							'meta_value' => $cid,
						);
						$unit_posts = get_posts($arguments); 
						foreach( $unit_posts as $post ) { 
							setup_postdata($post); 
						?>
						  <li>
						  <p class="meta">
								<span><?php  if($post->post_type=='events'){
				                    $data = get_post_meta($post->ID,'_ma_events_type', true);
				                
				                    echo get_posttype_label($post->post_type,$data);
				                        
				                }else
				                    echo get_posttype_label($post->post_type);
				                ?></span> 
								<small><span><?php echo ma_ellak_print_thema($post->ID,'thema');?></span> <span><?php the_date(); ?></span></p></small>
							<p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><?php ma_ellak_single_edit_permalink($post); ?></p>
							<!--<p class="meta">
								<span><?php  if($post->post_type=='events'){
				                    $data = get_post_meta($post->ID,'_ma_events_type', true);
				                
				                    echo get_posttype_label($post->post_type,$data);
				                        
				                }else
				                    echo get_posttype_label($post->post_type);
				                ?></span> 
								<small><span><?php echo ma_ellak_print_thema($post->ID,'thema');?></span> <span><?php the_date(); ?></span></p></small>-->
						  </li>
				<?php	}
						wp_reset_query();
					?>
					</div>
					<div class="colfirst">
<h3>Λογισμικό</h3>
            
            <?php
						
						global $ma_ellak_content_types;
						$cid = $post->ID;
						$arguments = array(
							'posts_per_page' => 5,
							'post_type' =>  'software',
							'meta_key' => '_ma_ellak_belongs_to_unit',
							'meta_value' => $cid,
						);
						$unit_posts = get_posts($arguments); 
						foreach( $unit_posts as $post ) { 
							setup_postdata($post); 
						?>
						  <li>
						  <p class="meta">
								<span><?php  if($post->post_type=='events'){
				                    $data = get_post_meta($post->ID,'_ma_events_type', true);
				                
				                    echo get_posttype_label($post->post_type,$data);
				                        
				                }else
				                    echo get_posttype_label($post->post_type);
				                ?></span> 
								<small><span><?php echo ma_ellak_print_thema($post->ID,'thema');?></span> <span><?php the_date(); ?></span></p></small>
							<p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><?php ma_ellak_single_edit_permalink($post); ?></p>
							<!--<p class="meta">
								<span><?php  if($post->post_type=='events'){
				                    $data = get_post_meta($post->ID,'_ma_events_type', true);
				                
				                    echo get_posttype_label($post->post_type,$data);
				                        
				                }else
				                    echo get_posttype_label($post->post_type);
				                ?></span> 
								<small><span><?php echo ma_ellak_print_thema($post->ID,'thema');?></span> <span><?php the_date(); ?></span></p></small>-->
						  </li>
				<?php	}
						wp_reset_query();
					?>
					</div>
					<div class="colfirst">
<h3>Βίντεο</h3>
            
            <?php
						
						global $ma_ellak_content_types;
						$cid = $post->ID;
						$arguments = array(
							'posts_per_page' => 5,
							'post_type' =>  'video',
							'meta_key' => '_ma_ellak_belongs_to_unit',
							'meta_value' => $cid,
						);
						$unit_posts = get_posts($arguments); 
						foreach( $unit_posts as $post ) { 
							setup_postdata($post); 
						?>
						  <li>
						  <p class="meta">
								<span><?php  if($post->post_type=='events'){
				                    $data = get_post_meta($post->ID,'_ma_events_type', true);
				                
				                    echo get_posttype_label($post->post_type,$data);
				                        
				                }else
				                    echo get_posttype_label($post->post_type);
				                ?></span> 
				                
								<small><span><?php echo ma_ellak_print_thema($post->ID,'thema');?></span> <span><?php the_date(); ?></span></p></small>
							<p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><?php ma_ellak_single_edit_permalink($post); ?></p>
							<!--<p class="meta">
								<span><?php  if($post->post_type=='events'){
				                    $data = get_post_meta($post->ID,'_ma_events_type', true);
				                
				                    echo get_posttype_label($post->post_type,$data);
				                        
				                }else
				                    echo get_posttype_label($post->post_type);
				                ?></span> 
								<small><span><?php echo ma_ellak_print_thema($post->ID,'thema');?></span> <span><?php the_date(); ?></span></p></small>-->
						  </li>
				<?php	}
						wp_reset_query();
					?>
					</div>
					
            <!--
              <h2><?php the_title(); ?></h2>
			 <div class="alert alert-info"> <p>
			<?php 
				echo ma_ellak_is_member_on_unit(); 
				if( $is_current_admin){
					echo '<a href="'.ma_ellak_edit_permalink($post->ID, $post->post_type).'" class="btn btn-success btn-mini ma_ellak_edit">'.__('Επεξεργασία','ma-ellak').'</a>';
				}
			?></p></div>
              <?php the_content(__('(more...)')); ?>
			  <?php /*
              <p>ΣΥΜΜΕΤΟΧΗ <?php //echo ma_ellak_is_member_on_unit(); ?></p>
			  */ ?>
			  -->
            </div>
          </div>
		  
        </div>
		
	</div>
	
      <div class="back-purple">
        <div class="container">
          <div class="row-fluid">
            <ul class="nav nav-tabs span10 offset2">
              <li<?php if(!$is_manage_page ) echo ' class="active"'; ?>><a href="#tab-1" data-toggle="tab"><?php _e('ΔΡΑΣΤΗΡΙΟΤΗΤΑ','ma-ellak'); ?></a></li>
              <li><a href="#tab-2"><?php _e('ΕΠΙΚΟΙΝΩΝΙΑ','ma-ellak'); ?></a></li>
              <li><a href="#tab-3"><?php _e('ΜΕΛΗ','ma-ellak'); ?></a></li>
			  <?php if( $is_current_admin){ ?><li<?php if($is_manage_page ) echo ' class="active green"'; else echo ' class="green"' ?>><a href="#tab-4" class="green"><?php _e('ΔΙΑΧΕΙΡΙΣΗ','ma-ellak'); ?></a></li><?php } ?>
            </ul>
          </div>
        </div>
      </div>

      <div class="back-gray" id="buddypress">
        <div class="container">
          <div class="row-fluid">
            <div class="tab-content span10 offset2">
              <div id="tab-1" class="tab-pane<?php if(!$is_manage_page ) echo ' active'; ?>">
                <ul class="unstyled">
					<?php
						/*
						$query_string .= '&primary_id='.ma_ellak_get_bp_groups_id_by_thema($main_thema).'&per_page=20'; 
						if ( bp_has_activities(  bp_ajax_querystring( 'activity' ).$query_string ) ) :  
							while ( bp_activities() ) : bp_the_activity(); 
								locate_template( array( 'single-unit-activity-entry.php' ), true, false ); 
							endwhile;  
						endif;  
						*/
						global $ma_ellak_content_types;
						$cid = $post->ID;
						$arguments = array(
							'posts_per_page' => 20,
							'post_type' =>  $ma_ellak_content_types,
							'meta_key' => '_ma_ellak_belongs_to_unit',
							'meta_value' => $cid,
						);
						$unit_posts = get_posts($arguments); 
						foreach( $unit_posts as $post ) { 
							setup_postdata($post); 
						?>
						  <li>
							<p><a href="<?php the_permalink(); ?>" class="btn btn-large btn-link"><?php the_title(); ?></a><?php ma_ellak_single_edit_permalink($post); ?></p>
							<p class="meta">
								<span><?php  if($post->post_type=='events'){
				                    $data = get_post_meta($post->ID,'_ma_events_type', true);
				                
				                    echo get_posttype_label($post->post_type,$data);
				                        
				                }else
				                    echo get_posttype_label($post->post_type);
				                ?></span> 
								<span><?php echo ma_ellak_print_thema($post->ID,'thema');?></span> <span><?php the_date(); ?></span></p>
						  </li>
				<?php	}
						wp_reset_query();
					?>
                </ul>
              </div>
              <div id="tab-2" class="tab-pane">
                
                 <?php foreach($details as $key=>$value){
						if($key == 'Λογότυπο') continue;
						else if ($value!=''){
							echo'<div class="row-fluid">';
							echo '<div class="span3 left"><strong>'. $key.': </strong></div>';
							echo '<div class="pull-left">';
							if($key=='Ιστοσελίδα') 
								echo '<a href="'.$value.'" target="blank">'.$value.'</a>'; 
							else if($key=='eΜail') 
								echo '<a href="mailto:'.$value.'" target="blank">'. str_replace('@',' ΑΠΟ ',$value).'</a>'; 
							else
								echo $value;
							echo'</div>';
							echo'</div>';
						}
					
					}  ?>
               
               
              </div>
              <div id="tab-3" class="tab-pane">
			  <h4><?php _e('ΔΙΑΧΕΙΡΙΣΤΕΣ','ma-ellak'); ?></h4>
				<?php 
					$current_users = get_users(array('meta_key' => '_ma_ellak_admin_unit', 'meta_value' => $cid )); 
					foreach ($current_users as $user) {
							//echo '<li>' . $user->display_name .' ('.$user->user_email.') ' . '</li>'; ?>
							<?php $member_id = bp_core_get_userid( $user->user_login ) ?>
							<div class="unit_member_avatar">
								<a href="<?php echo bp_core_get_user_domain( $member_id ) ?>" title="<?php echo bp_core_get_user_displayname( $member_id ) ?>">
								<?php echo bp_core_fetch_avatar ( array( 'item_id' => $member_id, 'type' => 'full', 'width' => 75, 'height' => 75 ) ) ?></a>
								<span><?php echo $user->display_name ;?></span>
							</div>
			<?php		}
					?>
				<hr />
				<h4><?php _e('ΜΕΛΗ','ma-ellak'); ?></h4>
                    <?php 
						$current_users = get_users(array('meta_key' => '_ma_ellak_member_unit', 'meta_value' => $cid )); 
						foreach ($current_users as $user) {
							//echo '<li>' . $user->display_name .' ('.$user->user_email.') ' . '</li>'; ?>
							<?php $member_id = bp_core_get_userid( $user->user_login ) ?>
							<?php if( $is_current_admin){ ?>
								<form action="#" method="post" enctype="multipart/form-data" name="user_unit_form" id="user_unit_form">
							<?php } ?>
									<div class="unit_member_avatar">
										<a href="<?php echo bp_core_get_user_domain( $member_id ) ?>" title="<?php echo bp_core_get_user_displayname( $member_id ) ?>">
										<?php echo bp_core_fetch_avatar ( array( 'item_id' => $member_id, 'type' => 'full', 'width' => 75, 'height' => 75 ) ) ?></a>
										<span><?php echo $user->display_name ;?></span><br />
										<?php if( $is_current_admin){ ?>
												<input type="hidden" name="admin_id" value="<?php echo $user->ID; ?>" />
												<input type="hidden" name="unit_id" value="<?php echo $user_unit_id; ?>" />
												<input class="button-primary" type="submit" name="user_unit_discard" value="<?php _e('Διαγραφή','ma-ellak'); ?>" />
										<?php } ?>
									</div>
							<?php if( $is_current_admin){ ?>
								</form>
							<?php } ?>
			<?php		}
					?>
              </div>
			  <?php if( $is_current_admin){ ?>
              <div id="tab-4" class="tab-pane<?php if($is_manage_page ) echo ' active '; ?>">
				  <div class="item-list-tabs no-ajax" id="subnav" role="navigation">
					<ul>
						<li<?php if(isset($_GET['members'])) echo ' class="current"'; ?>><a href="<?php the_permalink(); ?>?members"><?php _e('Αιτήσεις Μελών', 'ma-ellak'); ?></a></li>
						<li<?php if(isset($_GET['content'])) echo ' class="current"'; ?>><a href="<?php the_permalink(); ?>?content"><?php _e('Καταχωρίσεις προς Δημοσίευση', 'ma-ellak'); ?></a></li>
					</ul>
				</div>
                
				<div class="row-fluid">
				<?php
					if(isset($_GET['members'])){
						$new_users = get_users(array('meta_key' => '_ma_ellak_member_unit_request', 'meta_value' => $user_unit_id));
						foreach ($new_users as $user) { ?>
							<?php $member_id = bp_core_get_userid( $user->user_login ) ?>
							<form action="#" method="post" enctype="multipart/form-data" name="user_unit_form" id="user_unit_form">
								<div class="unit_member_avatar">
									<a href="<?php echo bp_core_get_user_domain( $member_id ) ?>" title="<?php echo bp_core_get_user_displayname( $member_id ) ?>">
									<?php echo bp_core_fetch_avatar ( array( 'item_id' => $member_id, 'type' => 'full', 'width' => 75, 'height' => 75 ) ) ?></a>
									<span><?php echo $user->display_name; ?></span><br />
									<input type="hidden" name="admin_id" value="<?php echo $user->ID; ?>" />
									<input type="hidden" name="unit_id" value="<?php echo $user_unit_id; ?>" />
									<input class="button-primary" type="submit" name="user_unit_save" value="<?php _e('Αποδοχή','ma-ellak'); ?>" />
									<input class="button-primary" type="submit" name="user_unit_discard" value="<?php _e('Απόρριψη','ma-ellak'); ?>" />
								</div>
							</form>
							
					<?php
						
						}
					}
				?>
				<?php
					if(isset($_GET['content'])){
						echo"<div class='row-fluid'>";
						
						global $ma_ellak_content_types;
						$cid = $post->ID;
						$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
						
						$arguments = array(
							'posts_per_page' =>10,
							'post_status' => 'draft',
							'paged'=>$paged,
							'post_type' =>  $ma_ellak_content_types,
							'meta_key' => '_ma_ellak_belongs_to_unit',
							'meta_value' => $cid,
						);
						
						$my_query = new WP_Query($arguments);
						if( $my_query->have_posts() ) {
							?>
							<div class="row-fluid">
							<ul class="unstyled">
							<?php 
							while ($my_query->have_posts()) : $my_query->the_post();
							$cid= get_the_ID();
							$post = get_post( get_the_ID() );
							?>
							<li>
								<p class="heading"><a href="<?php echo ma_ellak_edit_permalink($post->ID, $post->post_type); ?>" class="btn btn-large btn-link"><?php the_title(); ?></a>
								<a href="<?php echo ma_ellak_edit_permalink($post->ID, $post->post_type); ?>" class="btn btn-success btn-mini ma_ellak_edit"><?php _e('Επεξεργασία', 'ma-ellak'); ?></a></p>
							<p class="meta"><span><?php echo ma_ellak_print_thema($post->ID,'thema');?></span> 
							<span><?php the_date(); ?></span></p>
						  </li>
							
							<?php 
							endwhile;
							?></ul>
							</div>
							<?php 
							if( $my_query->max_num_pages>1){
								pagination(false, false, $my_query);
							}
							echo"</div>";
						}else __('Δεν υπάρχουν εγγραφές προς το παρόν','maellak');
						wp_reset_query();
					}
				?>
                </div>
              </div>
			 <?php } ?>
            </div>
          </div>
        </div>
      </div>
		
<?php 
	endwhile; else: ?>
		<p>Sorry, no posts matched your criteria.</p>
<?php
  endif;
  get_footer();
?>
