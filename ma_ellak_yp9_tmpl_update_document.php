<?php
/*
Template Name: Document - Update
*/

	if (! is_user_logged_in()) // Μόνο εγγεγραμμένοι χρήστες μπορούν να είναι εδώ.
		header('Location: '.URL.'');

	$cur_user = wp_get_current_user();
	if(strpos($_SERVER['HTTP_REFERER'], '?doc_id')==false)	$UrlReferrer = $_SERVER['HTTP_REFERER'];
	$success = false;
	$ma_message = '';
	global $wpdb;
	$result="fail";

	$max_upload = (int)(ini_get('upload_max_filesize'));
	$max_post = (int)(ini_get('post_max_size'));
	$memory_limit = (int)(ini_get('memory_limit'));
	$upload_mb = min($max_upload, $max_post, $memory_limit);
	get_header();
	if (!isset($_GET['doc_id'])){
		$ma_message = '<p class="error">TO EΓΓΡΑΦΟ ΠΟΥ ΠΡΟΣΠΑΘΕΙΤΕ ΝΑ ΕΠΕΞΕΡΓΑΣΤΕΙΤΕ ΔΕΝ ΥΠΑΡΧΕΙ.</p>';
		echo $ma_message;
	}else{
		$doc_id= sanitize_text_field($_GET['doc_id']);
		
		if(isset($_POST['publish']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {
			global $wpdb, $wpdr;

			$title = sanitize_text_field($_POST['title']);
			if (isset($_POST['description']))
				$description = sanitize_text_field($_POST['description']);
			$author =  sanitize_text_field($_POST['user']); 

			$pub_status='private';
			if(isset($_POST['_ma_document_status'])) $pub_status = 'publish';

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
				if ($pub_status=='publish')
					$state=array('workflow_state' => 'Final');
				else
					$state=array('workflow_state' => 'Under Review');
			}
			$tax=array_merge($tax1, $tax2, $state);
			
			/*echo"<BR>*********TAXONOMIES**********<br>";
			print_r($tax);
			echo"<BR>*********TAXONOMIES**********<br>";*/
		
			$document = array(
				'ID'			=> $doc_id,
				'post_title'	=> $title,
				'post_excerpt'	=> $description,
				'post_status'	=> $pub_status,	// publish, preview, future, etc.
				'post_type'		=> 'document',
				'post_author'	=> $author,
				'tax_input'		=> $tax,
				'post_content'	=> '',
				'comment_status' => 'closed'
			);
			if ($_FILES['file']['size']!=0){	//in case of update user might not want to update the file
				$result=custom_field_document_update_($doc_id);
				if ($result!="success")
					$ma_message = '<p class="error">Παρουσιάστηκε πρόβλημα και η καταχώρηση δεν ήταν επιτυχής. Ελέγξτε το μέγεθος και το είδος του αρχείου.</p>';
				else{
					$doc_id = wp_update_post($document);
					$ma_message = 'Η ανανέωση του αρχείου ήταν επιτυχής.';
					$ma_message .='Μπορείτε να γυρίσετε στην σελίδα που ήσασταν πατώντας <a href='.$_POST['pagerefferer'].'>εδώ</a>';
					$success = true;
					
					/* Ενημέρωσε τους Διαχειριστές της ΜΑ -----------------------------------
					$unit_id = get_post_meta($doc_id, '_ma_ellak_belongs_to_unit', true);
					if($unit_id != 0){
						$mail_message = 'Καταχωρήθηκε Νέο Αρχείο - Επεξεργασία,\r\n\r\n';
						$mail_message .= 'Αφορά το Αρχείο '.get_the_title($doc_id).' ( '.get_permalink($doc_id).' ).\r\n\r\n';
						$mail_message .= 'Επεξεργαστείτε το Αρχείο '.get_permalink(get_option_tree('ma_ellak_update_document'))."?doc_id=".$doc_id.' \r\n\r\n';
						$mail_message .= 'Διαχείριση Δικτυακής Πύλης Μονάδων Αριστείας ΕΛ/ΛΑΚ \r\n\r\n';
						$admin_users = get_users(array('meta_key' => '_ma_ellak_admin_unit', 'meta_value' =>$unit_id ));
						foreach ($admin_users as $user) {
							wp_mail( $user->user_email, 'Μονάδες Αριστείας ΕΛ/ΛΑΚ - Καταχώριση Νέου Αρχείου - Επεξεργασία', $mail_message );
							//echo $user->user_email.' => '.$mail_message;
						}
					}
					*/
				}
			}else{
				$doc_id = wp_update_post($document);
				$rquery="SELECT max(ID) AS lrevision FROM $wpdb->posts WHERE post_parent=". $doc_id;
				$lrevisions = $wpdb->get_results($rquery, OBJECT);
				$lrevision_id=$lrevisions[0]->lrevision;	//the data to be updated are for the last revision of the document

				$wpdb->query("UPDATE $wpdb->posts SET post_mime_type='". $_POST['mime_type'] ."' WHERE ID='". $lrevision_id ."'");
				//echo"<BR>UPDATE $wpdb->posts SET post_mime_type='". $_POST['mime_type'] ."' WHERE ID='". $lrevision_id ."'";

				$aquery="SELECT meta_value FROM $wpdb->postmeta WHERE post_id='". $_POST['revision_id'] ."' AND meta_key='_wp_attached_file'";
				//echo"<BR>". $aquery;
				$attachment_file = $wpdb->get_results($aquery, OBJECT);
				//print_r($attachment_file);
				$attachment_filename=$attachment_file[0]->meta_value;

				$wpdb->query( $wpdb->prepare(  
						"INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) VALUES(%d, %s, %s)",
						array(
							$lrevision_id,
							'_wp_attached_file',
							$attachment_filename
						)
				));

				$ma_message = 'Η ανανέωση του αρχείου ήταν επιτυχής.';
				$ma_message .='Μπορείτε να γυρίσετε στην σελίδα που ήσασταν πατώντας <a href='.$_POST['pagerefferer'].'>εδώ</a>';
				$success = true;
			}//end of else
			if ($success){	//upload a revision so the parent document is updated and the document status is "Under Review"					
				$wpdb->query("UPDATE $wpdb->posts SET post_content='". $lrevision_id ."' WHERE ID='". $doc_id ."'");
				//echo "<BR>UPDATE $wpdb->posts SET post_content='". $lrevision_id ."' WHERE ID='". $doc_id ."'<BR>";
				if ($pub_status!='publish'){
					$obj=get_term_by('name', 'Under Review', 'workflow_state');
					$review_id=$obj->term_id;
					$obj=get_term_by('name', 'Final', 'workflow_state');
					$final_id=$obj->term_id;

					$wpdb->query("UPDATE $wpdb->term_relationships SET term_taxonomy_id='". $review_id ."' WHERE object_id='". $doc_id ."' AND term_taxonomy_id='". $final_id ."'");
					//echo "<BR>UPDATE $wpdb->term_relationships SET term_taxonomy_id='". $review_id ."' WHERE object_id='". $doc_id ."' AND term_taxonomy_id='". $final_id ."'<BR>";
				}//if publish
				$ma_message = '<p class="message">H καταχώρησή σας ήταν επιτυχής.</p>';
				$ma_message .='Μπορείτε να γυρίσετε στην σελίδα που ήσασταν πατώντας <a href='.$_POST['pagerefferer'].'>εδώ</a>';
				$success = true;
			}//if success
		}//if isset(publish)
		
?>

<div class="postWrapper" id="post-<?php the_ID(); ?>">
	<?php while ( have_posts() ) : the_post(); ?>
	<?php endwhile; ?>
	<div class="post">
		<?php /*---------------------- Form ------------------------------------------*/ ?>
		<div id="ma-message"><?php _e($ma_message, 'ma-ellak');?> </div>
		<?php if($success){  
			
		}else{ ?>
			<form action="<?php echo esc_url( get_permalink( get_the_ID() ) ) ."?doc_id=". $doc_id; ?>" method="post" id="post" enctype="multipart/form-data">
				<?php
				$document_data=get_post($doc_id);
				$doc_title=$document_data->post_title;
				$doc_description=$document_data->post_excerpt;
				$doc_tags =wp_get_post_terms($doc_id, 'post_tag');
				$doc_thema =wp_get_post_terms($doc_id, 'thema');

				$query="SELECT max(ID) AS revision_id, post_mime_type FROM $wpdb->posts WHERE post_parent=". $doc_id;
				$revisions = $wpdb->get_results($query, OBJECT);
				$revision_id=$revisions[0]->revision_id;	//the data to be updated are for the last revision of the document
				$mime_type=$revisions[0]->post_mime_type;
				echo"<input type=\"hidden\" id=\"revision_id\" name=\"revision_id\" value=\"". $revision_id ."\" />";
				echo"<input type=\"hidden\" id=\"mime_type\" name=\"mime_type\" value=\"". $mime_type ."\" />";
				
				?>
				<div class="control-group">
					<label for="title" ><?php _e('ΤΙΤΛΟΣ ΑΡΧΕΙΟΥ (*)', 'ma-ellak');?></label>
					<div class="controls">
						<input type="text" name="title" id="title" class="input-block-level input required" value="<?php echo $doc_title;?>"  />
                    </div>
				</div>
				<div class="control-group">
					<label for="description"><?php _e('Περιγραφή αρχείου', 'ma-ellak'); ?></label>
					<?php
						if(isset($doc_description)) $content = $doc_description;
						else $content='';
						$settings = array( 'media_buttons' => false, 'textarea_rows'=>5 );
						wp_editor( $content, 'description',$settings );
					?>
				</div>
				<div class="control-group">
					<label for="file" ><?php _e('ΑΛΛΑΓΗ ΑΡΧΕΙΟΥ', 'ma-ellak');?></label>
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
						<input type="checkbox" name="_ma_document_know" id="_ma_document_know" checked/>
						<span class="meta"><?php _e('Έχω γνώση του περιεχομένου που αναρτώ (*)', 'ma-ellak'); ?></span>
						</label>
					</div>
				</div>
				<div class="row-fluid"></div>
				<div class="control-group">
					<label><?php _e('Θεματικές κατηγορίες', 'ma-ellak'); ?></label>
					<?php
					$i=0;
					foreach ($doc_thema as $term){
						$arrayTerms[$i]= $term->term_id;
						$i++;
					}
					echo ma_ellak_add_thema_term_chosebox( 'thema-select', true, $arrayTerms);
					?>
				</div>
				<div class="control-group">
					<label ><?php _e('Ετικέτες', 'ma-ellak'); ?></label>
					<?php 
						$i=0;
						foreach ($doc_tags as $term){
							$arrayTermsTags[$i]= $term->slug;
							$i++;
						}
						$tagz = get_taxonomy('post_tag');
						echo ma_ellak_add_term_chosebox( $tagz, 'tag-select',false,$arrayTermsTags);
					?>
					<a href="#" id="addnewtags" style="font-size:90%; font-style:italics;"><?php _e('Προσθέστε νέες Ετικέτες αν δεν εντοπίζονται παραπάνω.', 'ma-ellak'); ?></a>
						<input type="text" name="selftags" style="display:none;" id="selftags" class="form-control input-block-level" value="<?php if(isset($_POST[$field['selftags']])) echo $_POST[$field['selftags']];?>" placeholder="<?php _e('Χωρίστε με κόμα (,) τις νέες ετικέτες', 'ma-ellak'); ?>" />
				</div>
				<div class="control-group">
						<div class="controls">
							<label  class="checkbox inline" for="_ma_document_status">
							<input type="checkbox" name="_ma_document_status" id="_ma_document_status" 
							<?php if(isset($document_data->post_status) && $document_data->post_status=='publish') echo "checked='checked'";?>
							/>
							<span class="meta"><?php _e('Να δημοσιευτεί;', 'ma-ellak');  ?></span>
							</label>
						</div>
				</div>

				<button id="publish" name="publish" class="btn btn-primary btn-block"><?php _e('Υποβολή', 'ma-ellak'); ?></button>
				<input type="hidden" id="user" name="user" value="<?php echo $cur_user->ID; ?>" />
				<input type="hidden" id="admin" name="admin" value="0" />
				<input type="hidden" id="update" name="update" value="1" />
				<input type="hidden" id="pagerefferer" name="pagerefferer" value="<?php echo $UrlReferrer;?>"/>
				<input type="hidden" id="revision" name="revision" value="0" />
				<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
			</form>
			
		<?php /*---------------------- End Form ------------------------------------------*/ 
	}
		}
		?>
	</div>
</div>
<?php ?>
<?php get_footer();

function custom_field_document_update_($doc_id='') {
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
            //$filetype   = wp_check_filetype(basename($upload['file']), null);
			$mime = wp_check_filetype( basename($upload['file']), null );
            $title      = $file['name'];
            $ext        = strrchr($title, '.');
            $title      = ($ext !== false) ? substr($title, 0, -strlen($ext)) : $title;
            $attachment = array(
				//'post_mime_type'    => $wp_filetype['type'],
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
            //update_post_meta($post->ID, $attach_key, $attach_id);
			return "success";
		}
		return $upload['error'];
    }
}
?>