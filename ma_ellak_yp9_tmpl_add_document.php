<?php
/*
Template Name: Document - Add
*/

	if (! is_user_logged_in()) // Μόνο εγγεγραμμένοι χρήστες μπορούν να είναι εδώ.
		header('Location: '.URL.'');

	$cur_user = wp_get_current_user();
	$success = false;
	$ma_message = '';

	$max_upload = (int)(ini_get('upload_max_filesize'));
	$max_post = (int)(ini_get('post_max_size'));
	$memory_limit = (int)(ini_get('memory_limit'));
	$upload_mb = min($max_upload, $max_post, $memory_limit);

	if(isset($_POST['publish']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {
		global $wpdb, $wpdr;

		$title = sanitize_text_field($_POST['title']);
		if (isset($_POST['description']))
			$description = sanitize_text_field($_POST['description']);
		$author =  sanitize_text_field($_POST['user']); 

		// Ορίζουμε τις κατηγορίες/ταξονομίες
		$tax1=$tax2=$state=array();
		if (!isset($_POST['parent'])){
			if (isset($_POST['tag-select']))
				$tag_list=implode(',', $_POST['tag-select']);
			
			if(isset($_POST['selftags'])){
				$tag_list .= ','.sanitize_text_field($_POST['selftags']);
			}
			
			$tax1=array('post_tag' => $tag_list);
			
			if (isset($_POST['thema-select']))
				$tax2=array('thema' => implode(',', $_POST['thema-select']));
			$state=array('workflow_state' => 'Under Review');
		}
		$tax=array_merge($tax1, $tax2, $state);

		if (!isset($_POST['parent'])){		//Add a new document
			$document = array(
				'post_title'	=> $title,
				'post_excerpt'	=> $description,
				'post_status'	=> 'draft',	// publish, preview, future, etc.
				'post_type'		=> 'document',
				'post_author'	=> $author,
				'tax_input'		=> $tax,
				'post_content'	=> '',
				'comment_status' => 'closed'
			);

			$doc_id = wp_insert_post($document);

			$result=custom_field_document_update($doc_id);
			if ($result=="success"){
				if (!isset($_POST['parent'])){	//new document
					$unit_id =  ma_ellak_get_unit_id();
					if( $unit_id != 0)
						update_post_meta( $doc_id, '_ma_ellak_belongs_to_unit',$unit_id );
				}
				$ma_message = '<p class="message">H καταχώρησή σας ήταν επιτυχής.</p>';
				
				// Ενημέρωσε τους Διαχειριστές της ΜΑ -----------------------------------
				$unit_id = get_post_meta($doc_id, '_ma_ellak_belongs_to_unit', true);
				if($unit_id != 0){
					$mail_message = 'Καταχωρήθηκε Νέο Αρχείο,\r\n\r\n';
					$mail_message .= 'Αφορά το Αρχείο '.get_the_title($doc_id).' ( '.get_permalink($doc_id).' ).\r\n\r\n';
					$mail_message .= 'Επεξεργαστείτε το Αρχείο '.get_permalink(get_option_tree('ma_ellak_update_document'))."?doc_id=".$doc_id.' \r\n\r\n';
					$mail_message .= 'Διαχείριση Δικτυακής Πύλης Μονάδων Αριστείας ΕΛ/ΛΑΚ \r\n\r\n';
					$admin_users = get_users(array('meta_key' => '_ma_ellak_admin_unit', 'meta_value' =>$unit_id ));
					foreach ($admin_users as $user) {
						wp_mail( $user->user_email, 'Μονάδες Αριστείας ΕΛ/ΛΑΚ - Καταχώριση Νέου Αρχείου', $mail_message );
						//echo $user->user_email.' => '.$mail_message;
					}
				}
				$success = true;
			}
			else{
				wp_delete_post($doc_id);
				$ma_message = '<p class="error">Παρουσιάστηκε πρόβλημα και η καταχώρηση δεν ήταν επιτυχής. Ελέγξτε το μέγεθος και το είδος του αρχείου.</p>';
			}
		}
		else{					//Add a new revision to an existing document
			$result=custom_field_document_update();
			//add a new revision
			if ($result=="sucess"){	//upload a revision so the parent document is updated and the document status is "Under Review"
				$obj=get_term_by('name', 'Under Review', 'workflow_state');
				$review_id=$obj->term_id;

				$obj=get_term_by('name', 'Final', 'workflow_state');
				$final_id=$obj->term_id;

				$query="SELECT max(ID) as rev FROM $wpdb->posts WHERE post_parent=". $_POST['parent'];
				$new_id = $wpdb->get_results($query, OBJECT);
				$revision_id=$new_id[0]->rev;
		
				$wpdb->query("UPDATE $wpdb->posts SET post_excerpt='". $description ."', post_content='". $revision_id ."' WHERE ID='". $_POST['parent'] ."'");
				$wpdb->query("UPDATE $wpdb->term_relationships SET term_taxonomy_id='". $review_id ."' WHERE object_id='". $_POST['parent'] ."' AND term_taxonomy_id='". $final_id ."'");
				$ma_message = '<p class="message">H καταχώρησή σας ήταν επιτυχής.</p>';
				$success = true;
			}
			else
				$ma_message = '<p class="error">Παρουσιάστηκε πρόβλημα και η καταχώρηση δεν ήταν επιτυχής. Ελέγξτε το μέγεθος και το είδος του αρχείου.</p>';
		}
	}
?>
<?php get_header();?>
<div class="postWrapper" id="post-<?php the_ID(); ?>">
	<?php while ( have_posts() ) : the_post(); ?>
	<?php endwhile; ?>
	<div class="post">
		<?php /*---------------------- Form ------------------------------------------*/ ?>
		<div id="ma-message"><?php _e($ma_message, 'ma-ellak');?> </div>
		<?php if($success){ } else { ?>
			<form action="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>" method="post" id="post" enctype="multipart/form-data">
				<div class="control-group">
					<label for="title" ><?php 
						if (isset($_GET['doc_id']))
							_e('ΤΙΤΛΟΣ ΕΚΔΟΣΗΣ', 'ma-ellak');
						else
							_e('ΤΙΤΛΟΣ ΑΡΧΕΙΟΥ (*)', 'ma-ellak');
					?></label>
					<div class="controls">
						<?php
						if (isset($_GET['doc_id'])){
							//Create the revision title
							$query="SELECT count(*) as howmany FROM $wpdb->posts WHERE post_parent=". $_GET['doc_id'];
							$revisions = $wpdb->get_results($query, OBJECT);
							$revision_title='Εκδοση ';
							$revision_title.=$revisions[0]->howmany+1;
							?>
							<input type="text" name="title" id="title" class="input-block-level input required" value="<?php echo $revision_title;?>" readonly />
						<?php
						}
						else{
						?>
							<input type="text" name="title" id="title" class="input-block-level input required" value="<?php if(isset($_POST['title'])) echo $_POST['title'];?>"  />
						<?php
						}
						?>
                    </div>
				</div>
				<div class="control-group">
					<label for="description"><?php _e('Περιγραφή αρχείου', 'ma-ellak'); ?></label>
					<?php
						if(isset($_POST['description'])) $content = $_POST['description'];
						else $content='';
						$settings = array( 'media_buttons' => false, 'textarea_rows'=>5 );
						wp_editor( $content, 'description',$settings );
					?>
				</div>
				<div class="control-group">
					<label for="file" ><?php _e('ΠΡΟΣΘΗΚΗ ΑΡΧΕΙΟΥ', 'ma-ellak');?></label>
					<div class="controls">
						<input type="file" name="file" id="file" class="input-block-level input required"/>
						<?php 
							$up="Μέγιστο επιτρεπτό όριο ". $upload_mb ."MB";
							_e($up, 'ma-ellak');
						?>
                    </div>
				</div>
				<div class="control-group">
					<div class="controls">
						<label  class="checkbox inline" for="_ma_document_know">
						<input type="checkbox" name="_ma_document_know" id="_ma_document_know"/>
						<span class="meta"><?php _e('Έχω γνώση του περιεχομένου που αναρτώ (*)', 'ma-ellak'); ?></span>
						</label>
					</div>
				</div>
				<div class="row-fluid"></div>
				<?php
				if (!isset($_GET['doc_id'])){
				?>
				<div class="control-group">
					<label><?php _e('Θεματικές κατηγορίες', 'ma-ellak'); ?></label>
					<?php 						
					echo ma_ellak_add_thema_term_chosebox( 'thema-select', true);
					?>
				</div>
				<div class="control-group">
					<label ><?php _e('Ετικέτες', 'ma-ellak'); ?></label>
					<?php 
						$tagz = get_taxonomy('post_tag'); 
						echo ma_ellak_add_term_chosebox( $tagz, 'tag-select'); 
					?>
					<a href="#" id="addnewtags" style="font-size:90%; font-style:italics;"><?php _e('Προσθέστε δικές σας Ετικέτες αν δεν εντοπίστηκαν παραπάνω.', 'ma-ellak'); ?></a>
						<input type="text" name="selftags" style="display:none;" id="selftags" class="form-control input-block-level" value="<?php if(isset($_POST['selftags'])) echo $_POST['selftags'];?>" placeholder="<?php _e('Χωρίστε με κόμα (,) τις νέες ετικέτες', 'ma-ellak'); ?>" />
				</div>
				
				<input type="hidden" id="revision" name="revision" value="0" />
				<?php
				}
				else{
				?>
				<input type="hidden" id="revision" name="revision" value="1" />
				<?php }?>
				<button id="publish" name="publish" class="btn btn-primary btn-block"><?php _e('Υποβολή', 'ma-ellak'); ?></button>
				<input type="hidden" id="user" name="user" value="<?php echo $cur_user->ID; ?>" />
				<input type="hidden" id="admin" name="admin" value="0" />
				<?php
					if (isset($_GET['doc_id'])){
				?>
					<input type="hidden" id="parent" name="parent" value="<?php echo $_GET['doc_id'];?>" />
				<?php
				}
				?>
				<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
			</form>
		<?php } ?>
		<?php /*---------------------- End Form ------------------------------------------*/ ?>
	</div>
</div>	
<?php get_footer();

function custom_field_document_update($doc_id='') {
	if ($doc_id=='')
		$parent_id=$_POST['parent'];
	else
		$parent_id=$doc_id;
    if(!empty($_FILES['file'])) {
		include_once ABSPATH . 'wp-admin/includes/media.php';
		include_once ABSPATH . 'wp-admin/includes/file.php';
		include_once ABSPATH . 'wp-admin/includes/image.php';

        $file   = $_FILES['file'];
        $upload = wp_handle_upload($file, array('test_form' => false));
        if(!isset($upload['error']) && isset($upload['file'])) {
			$mime = wp_check_filetype( basename($upload['file']), null );
            $title      = $file['name'];
            $ext        = strrchr($title, '.');
            $title      = ($ext !== false) ? substr($title, 0, -strlen($ext)) : $title;
            $attachment = array(
				'post_mime_type'    => $mime['type'],
                'post_title'        => addslashes($title),
                'post_content'      => '',
                'post_status'       => 'inherit',
                'post_parent'       => $doc_id
            );
            $attach_key = 'document_file_id';
            $attach_id  = wp_insert_attachment($attachment, $upload['file'], $_POST['parent']);
            $existing_download = (int) get_post_meta($doc_id, $attach_key, true);

            if(is_numeric($existing_download)) {
                wp_delete_attachment($existing_download);
            }
			$attach_data = wp_generate_attachment_metadata( $attach_id, $_FILES['file']['name'] );
			wp_update_attachment_metadata( $attach_id, $attach_data );
			return "success";
		}
		return $upload['error'];
    }
}
?>
