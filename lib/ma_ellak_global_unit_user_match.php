<?php
/**
* Σελίδα Ορισμού Χρηστών ανά Μονάδα Αριστείας
*
* @licence GPL
* @author Fotis Routsis - fotis@routsis.gr
* 
* Project URL http://ma.ellak.gr
*/

if ( ! current_user_can('edit_others_posts') )  // Τουλάχιστον Επιπέδου Editor ο χρήστης
	wp_die( __('Δεν είστε πιστοποιημένος γι\' αυτή την ενέργεια.', 'ma-ellak') );

if(isset($_POST['user_unit_save'])) { 
	
	$user_id =  esc_attr($_POST['admin_id']);
	$unit_id = esc_attr($_POST['unit_id']);
	
	if(current_user_can('activate_plugins')){	// Ο Υπερ-Διαχειριστής ορίζει Διαχειριστές ΜΑ
		
		// Κάνε τον Μέλος στα BP Groups που αντιστοιχίζονται στη ΜΑ
		$bp_group_ids = ma_ellak_get_bp_groups_thema_ids($unit_id);
		if(function_exists('groups_accept_invite')) {
			foreach($bp_group_ids as $bp_group){
				groups_accept_invite( $user_id, $bp_group);
				$member = new BP_Groups_Member( $user_id, $bp_group );
				$member->promote( 'mod' ); 
			}
		}
		
		update_user_meta( $user_id, '_ma_ellak_admin_unit',  $unit_id );
		
	} else if (current_user_can('edit_others_posts'))	{ // Ο Διαχειριστές ΜΑ ορίζει Μέλη ΜΑ
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
}

// Αφαιρεί τον Διαχειριστή απο τη Μονάδα Αριστείας 
if(isset($_POST['user_unit_delete'])) {   
	
	$user_id =  esc_attr($_POST['admin_id']);
	$unit_id = esc_attr($_POST['unit_id']);
	
	if(current_user_can('activate_plugins')){	// Ο Υπερ-Διαχειριστής ορίζει Διαχειριστές ΜΑ
		
		// Κάνε τον Μέλος στα BP Groups που αντιστοιχίζονται στη ΜΑ
		$bp_group_ids = ma_ellak_get_bp_groups_thema_ids($unit_id);
		if(function_exists('groups_accept_invite')) {
			foreach($bp_group_ids as $bp_group){
				$member = new BP_Groups_Member( $user_id, $bp_group );
				$member-> demote();  // Τον βγάζουμε απο Διαχειριστής της ΜΑ. 
				groups_accept_invite( $user_id, $bp_group);
			}
		}
		// Αφαίρεσέ τον απο Διαχειριστή
		delete_user_meta( $user_id, '_ma_ellak_admin_unit' );
		// Κάνε τον Μέλος στη ΜΑ
		update_user_meta( $user_id, '_ma_ellak_member_unit',  $unit_id );
	}
}

?>
	
<div class="wrap">
	<div class="icon32" id="icon-options-general"><br></div>	
	<h2><?php _e('Καταχώριση Χρηστών ανα Μονάδα Αριστείας', 'ma-ellak'); ?></h2>
	<br /><br />
	<table class="form-table">
		<tbody>	
		<?php
			if ( current_user_can('activate_plugins') ) { // Είναι Υπέρ-διαχειριστής, οπότε ορίζω τους Διαχ. των ΜΑ. ?>
			
			<tr valign="top">
				<th scope="row"><strong><?php _e('Μονάδα Αριστείας','ma-ellak'); ?></strong></th>
				<td><strong><?php _e('Διαχειριστές Μονάδας Αριστείας','ma-ellak'); ?></strong></td>
				<td><?php _e('Προσθήκη Νέου Διαχειριστή','ma-ellak'); ?></td>
			</tr>	
		<?php	// Πάρε όλες τις Μονάδες Αριστείας
				$args = array( 'posts_per_page' => -1, 'post_type'=>'unit' );
				$unitz = get_posts( $args );
				
				// Πάρε όλους τους Διαχειριστές των Μονάδων Αριστείας
				$users = get_users('role=editor&fields=all_with_meta');
				
				$already_set = array();
				foreach ( $unitz as $unit ){ ?>

					<tr valign="top">
						<th scope="row"><strong><?php edit_post_link($unit->post_title, '', '', $unit->ID); ?></strong></th>
						<td>
							<ul>
							<?php 
								foreach ($users as $user) {
									$user_unit_id = get_user_meta( $user->ID, '_ma_ellak_admin_unit', true ); 
									
									if(!empty($user_unit_id) and $user_unit_id != 0)
										$already_set[] = $user->ID;
									
									if($user_unit_id == $unit->ID){	
										echo '<li>' ; ?>
										<form style="float: left; margin-right: 20px;" action="#" method="post" enctype="multipart/form-data" name="user_unit_form" id="user_unit_form">
											<input type="hidden" name="admin_id" value="<?php echo $user->ID; ?>" />
											<input type="hidden" name="unit_id" value="<?php echo $unit->ID; ?>" />
											<input class="button" type="submit" name="user_unit_delete" value="<?php _e('Αφαίρεση','ma-ellak'); ?>" />
										</form>
									<?php
										echo  $user->display_name .' (<a href="'.get_edit_user_link( $user->ID ).'">'.$user->user_email.'</a>) ' ;
										echo '</li>';
									}
								}
							?>
							</ul>
						</td>
						<td>
							<form action="#" method="post" enctype="multipart/form-data" name="user_unit_form" id="user_unit_form">
								<select name="admin_id" size="1">
								<?php 
									foreach ($users as $user) {
										if(!in_array($user->ID , $already_set) )
										echo '<option value="' . $user->ID . '" >' . $user->display_name .' ('.$user->user_email.')' . '</option>';
									}
								?>
								</select>
								<input type="hidden" name="unit_id" value="<?php echo $unit->ID; ?>" />
								<input class="button-primary" type="submit" name="user_unit_save" value="<?php _e('Προσθήκη','ma-ellak'); ?>" />
							</form>
						</td>
					</tr>
				<?php }
				
			} else if ( current_user_can('edit_others_posts') ) { // Είναι Διαχειριστής Μονάδας Αριστείας 
				$cur_user = wp_get_current_user();
				$user_id = $cur_user->ID; 
				
				// Είναι διαχειριστής σε Μονάδα Αριστείας ;
				$user_unit_id = get_user_meta( $user_id, '_ma_ellak_admin_unit', true ); 

				if(!empty($user_unit_id) and $user_unit_id != 0){
				
					$new_users = get_users(array('meta_key' => '_ma_ellak_member_unit_request', 'meta_value' => $user_unit_id));
					$current_users = get_users(array('meta_key' => '_ma_ellak_member_unit', 'meta_value' => $user_unit_id));
			?>
				
					<tr valign="top">
						<th scope="row"><strong><?php _e('Νέες Αιτήσεις Συμμετοχής','ma-ellak'); ?></strong></th>
						<td><ul>
						<?php
							foreach ($new_users as $user) {
								echo '<li>' . $user->display_name .' ('.$user->user_email.') ' ; ?>
								
								<form action="#" method="post" enctype="multipart/form-data" name="user_unit_form" id="user_unit_form">
									<input type="hidden" name="admin_id" value="<?php echo $user->ID; ?>" />
									<input type="hidden" name="unit_id" value="<?php echo $user_unit_id; ?>" />
									<input class="button-primary" type="submit" name="user_unit_save" value="<?php _e('Αποδοχή','ma-ellak'); ?>" />
								</form>
						<?php
								echo '</li>';
							}
						?>
						</ul></td>
					</tr>
					<tr valign="top">
						<th scope="row"><strong><?php _e('Υπάρχοντα Μέλη','ma-ellak'); ?></strong></th>
						<td><ul>
						<?php
							foreach ($current_users as $user) {
								echo '<li>' . $user->display_name .' ('.$user->user_email.') ' . '</li>';
							}
						?>
						</ul></td>
					</tr>
	<?php
				} else {
					_e('Δεν έχετε οριστεί διαχειριστής σε Μονάδα Αριστείας','ma-ellak');
				}
			}
		?>
		</tbody>
	</table>			
</div>