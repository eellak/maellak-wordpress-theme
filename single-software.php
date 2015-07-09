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
	
  if (have_posts()) : while (have_posts()) : the_post();
  global $post;
  
  $logo = get_post_meta($post->ID, $ma_prefix . 'software_logo', true);
  $website = get_post_meta($post->ID, $ma_prefix . 'software_website_url', true);
  $repository  = get_post_meta($post->ID, $ma_prefix . 'software_repository_url', true);
  $current = get_post_meta( $post->ID, 'software_used_by', true );
  $numOfComments = get_comments_number( $post->ID );
  
  if(empty($current) or $current == '')
	$current = 0;
  ?>
  
        <div class="row-fluid">
          <div class="cols">
           <div class="span5 characteristic-sidebar software-sidebar">
				
				<?php if(!empty($logo)){ ?>
					<p><img src="<?php echo $logo; ?>"></p>
				<?php } ?>
				
				<div class="characteristic-views">
					<?php the_ratings();?>
					<?php 
						$views = ma_ellak_show_statistics(get_the_ID(), 'software');
						if (!isset($views))
							$views=0;
					?>
					<i class="icon-eye-open"></i> <?php echo $views; ?> 
					<?php if(function_exists('like_counter_p')) { like_counter_p(''); } ?>
					<?php if(function_exists('dislike_counter_p')) { dislike_counter_p(''); } ?>
					
				</div>
				
				<ul class="characteristic-details">
					<li><span><?php _e('Το έχουν χρησιμοποιήσει', 'ma-ellak'); ?></span>&nbsp;&nbsp;&nbsp;<?php echo  $current; ?></li>
					<li><span><?php _e('Ημερομηνία Καταχώρισης', 'ma-ellak'); ?></span>&nbsp;&nbsp;&nbsp;<?php echo the_date(MA_DATE_FORMAT); ?></li>
					<?php if(!empty($website)){ ?>
						<li><span><?php _e('Ιστοσελίδα', 'ma-ellak'); ?></span>
							<a href="<?php echo $website; ?>" target="_blank"><?php _e('Προβολή', 'ma-ellak'); ?></a>
						</li>
						<?php } ?>
					<?php if(!empty($repository)){ ?>
						<li><span><?php _e('Αποθετήριο', 'ma-ellak'); ?></span>
							<a href="<?php echo $repository; ?>" target="_blank"><?php _e('Προβολή', 'ma-ellak'); ?></a>
						</li>
					<?php } ?>
					<?php 
						$type = wp_get_post_terms(get_the_ID(), 'type');
						if(count($type) != 0){ ?>
					<li><span><?php _e('Κατηγορία Λογισμικού', 'ma-ellak'); ?></span>&nbsp;&nbsp;&nbsp;<?php 
							foreach ($type  as $term)
								echo '<div class="term_item">'.$term->name .'</div>' ; ?>
					</li>
					<?php } ?>
					<?php if(ma_ellak_return_unit_title(get_the_ID())!=''){?>
					<li><span><?php _e('Μονάδα Αριστείας', 'ma-ellak'); ?></span>&nbsp;&nbsp;&nbsp;<?php
							echo '<div class="term_item">' ;
							ma_ellak_print_unit_title(get_the_ID());
							echo "</div>";
					?>
					<?php } ?>
					</li>
					
					<?php 
						$thema = wp_get_post_terms(get_the_ID(), 'thema');
						if(count($thema) != 0){ ?>
					<li><span><?php _e('Θεματικές κατηγορίες', 'ma-ellak'); ?></span>&nbsp;&nbsp;&nbsp;<?php 
								echo '<div class="term_item">' ; 
								 echo ma_ellak_print_thema(get_the_ID(),'thema');
								 echo "</div>";
								 ?>
					</li>
					<?php } ?>
					
					<?php 
						$nace = wp_get_post_terms(get_the_ID(), 'nace');
						if(count($nace) != 0){ ?>
					<li><span><?php _e('Τομείς Επιχειρηματικής Δραστηριότητας', 'ma-ellak'); ?></span>&nbsp;&nbsp;&nbsp;<?php 
							foreach ($nace  as $term)
								echo '<div class="term_item">'.$term->name .'</div>' ; ?>
					</li>
					<?php } ?>
					
					<?php 
						$licence = wp_get_post_terms(get_the_ID(), 'licence');
						if(count($licence) != 0){ ?>
					<li><span><?php _e('Άδεια Χρήσης', 'ma-ellak'); ?></span>&nbsp;&nbsp;&nbsp;<?php 
							foreach ($licence  as $term)
								echo '<div class="term_item">'.$term->name .'</div>' ; ?>
					</li>
					<?php } ?>
				
					<?php 
						$frascati = wp_get_post_terms(get_the_ID(), 'frascati');
						if(count($frascati) != 0){ ?>
					<li><span><?php _e('Επιστημονικά Πεδία', 'ma-ellak'); ?></span>&nbsp;&nbsp;&nbsp;<?php 
							foreach ($frascati  as $term)
								echo '<div class="term_item">'.$term->name .'</div>' ; ?>
					</li>
					<?php } ?>
					
					<?php 
						$package = wp_get_post_terms(get_the_ID(), 'package');
						if(count($package) != 0){ ?>
					<li><span><?php _e('Πακέτα Λογισμικού', 'ma-ellak'); ?></span>&nbsp;&nbsp;&nbsp;<?php 
							foreach ($package  as $term)
								echo '<div class="term_item">'.$term->name .'</div>' ; ?>
					</li>
					<?php } ?>
					
					<p class=""><?php ma_ellak_single_edit_permalink(); ?></p>
				</ul>
				
            </div>
			
            <div class="span7 col side-right">
				<h2><?php the_title(); ?></h2>
				<?php echo social_output();  ?><br />
				<div class="alert alert-info"> <p>
					<?php
						echo 'Το έχουν χρησιμοποιήσει <strong>'. $current.'</strong>. '; 
						echo ma_ellak_get_used_by(); 
					?></p>
				</div>
				<?php the_content(__('(more...)')); ?>
				<?php the_tags('<div class="taglist">Ετικέτες: ',' &bull; ','</div>'); ?>
            </div>
          </div>
        </div>
		
	</div>
      <div class="back-purple">
        <div class="container">
          <div class="row-fluid">
            <ul class="nav nav-tabs span12">
				<?php if(!isset($_GET['comment'])) { ?>
					<li class="active"><a href="#tab-1" data-toggle="tab"><?php _e('ΧΑΡΑΚΤΗΡΙΣΤΙΚΑ','ma-ellak'); ?></a></li>
				<?php } else { ?>
					<li><a href="#tab-1" data-toggle="tab"><?php _e('ΧΑΡΑΚΤΗΡΙΣΤΙΚΑ','ma-ellak'); ?></a></li>
				<?php } ?>
				<?php if(!isset($_GET['comment'])) { ?>
					<li><a href="#tab-2"><?php _e('ΕΝΑΛΛΑΚΤΙΚΟ ΓΙΑ','ma-ellak'); ?></a></li>
					<li><a href="#tab-3"><?php _e('ΒΕΛΤΙΣΤΕΣ ΠΡΑΚΤΙΚΕΣ','ma-ellak'); ?></a></li>
					<li><a href="#tab-4"><?php _e('ΣΧΟΛΙΑ','ma-ellak'); ?></a></li>
				<?php } else { ?>
					<li<?php if($_GET['comment'] == 'alternative') echo ' class="active"'; ?>><a href="#tab-2"><?php _e('ΕΝΑΛΛΑΚΤΙΚΟ ΓΙΑ','ma-ellak'); ?></a></li>
					<li<?php if($_GET['comment'] == 'bpractice') echo ' class="active"'; ?>><a href="#tab-3"><?php _e('ΒΕΛΤΙΣΤΕΣ ΠΡΑΚΤΙΚΕΣ','ma-ellak'); ?></a></li>
					<li<?php if($_GET['comment'] == 'comment') echo ' class="active"'; ?>><a href="#tab-4"><?php _e('ΣΧΟΛΙΑ','ma-ellak'); ?></a></li>
				<?php } ?>
				<li><a href="#tab-5"><?php _e('ΓΝΩΡΙΣΜΑΤΑ','ma-ellak'); ?></a></li>
				<li><a href="#tab-6"><?php _e('ΥΠΕΥΘΥΝΟΣ','ma-ellak'); ?></a></li>
            </ul>
          </div>
        </div>
      </div>
	  <?php
		$scomment_list = '';
		$salternative_list = '';
		$sbpractice_list = '';
		$args = array(
			'status' => 'approve',
			'post_id' =>  $post->ID , // use post_id, not post_ID
		);	
							
		$scomments = get_comments($args);
		if ( count($scomments ) > 0 ) {
			foreach ($scomments as $comment) {
	
				$type = get_comment_meta( $comment->comment_ID, 'type',  true );
				$meta_title = get_comment_meta( $comment->comment_ID, 'title',  true );
				//if($meta_title=='') continue;
				$comment_content = '<li id="comment-'.$comment->comment_ID.'">';
				if(!empty($type) and $type =='alternative'){
					$meta_title = get_comment_meta( $comment->comment_ID, 'title',  true );
					$comment_content .= '<div class="comment_meta">' .'<span class="mob" >'.__('Τίτλος', 'ma-ellak') .': </span>'. $meta_title.'</div>';	
				}
				if(!empty($type) and $type =='bpractice'){
					$meta_title = get_comment_meta( $comment->comment_ID, 'title',  true );
					$organisation = get_comment_meta( $comment->comment_ID, 'organisation',  true );
					$comment_content .= '<div class="comment_meta">' .'<span class="mob">'.__('Τίτλος', 'ma-ellak').': </span>'. $meta_title.'</div>';
					$comment_content .= '<div class="comment_meta">'.'<span class="petrol">' .__('Φορέας', 'ma-ellak').': </span>'. $organisation.'</div>';
				}
				
				//get_avatar( $comment, 32 );
				$comment_content .= '<div class="comment_content">' . $comment->comment_content.'</div>';
				if(!empty($comment->comment_author))
					$comment_content .= '<div class="comment_author"><a href="'.$comment->comment_author_url.'">'.$comment->comment_author.'</a> @ ';
				else {
					$user = get_user_by('ID', $comment->user_id);
					$member_id = bp_core_get_userid( $user->user_login );
					$comment_content .= '<div class="comment_author"><a href="'.bp_core_get_user_domain( $member_id ).'">'.bp_core_get_user_displayname( $member_id ).'</a> @ ';
				}
				
				$comment_content .= mysql2date('j M Y',$comment->comment_date);
				$comment_content .= '</div></li>';
				
				if(!empty($type) and $type =='alternative')
					$salternative_list .= $comment_content;
				elseif(!empty($type) and $type =='bpractice')
					$sbpractice_list .= $comment_content;
				else 
					$scomment_list .= $comment_content;
			}
		}
	  ?>

      <div class="back-gray" id="buddypress">
        <div class="container">
          <div class="row-fluid">
            <div class="tab-content span12">
              <div id="tab-1" class="tab-pane<?php if(!isset($_GET['comment'])) echo ' active'; ?>">
				<div class="row-fluid">
					<div class="span8 offset4">
						<?php echo apply_filters('the_content', get_post_meta($post->ID, $ma_prefix . 'software_specifications', true)); ?>
					</div>
				</div>
              </div>
			  
			  <div id="tab-2" class="tab-pane<?php if(isset($_GET['comment']) and $_GET['comment']=='alternative') echo ' active'; ?>">
				<div class="row-fluid">
					<div class="span4">
						<?php if ( comments_open() ) : ?>
							<h3 id="postcomment"><?php _e('Υποβάλετε Εναλλακτική'); ?></h3>
							<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
								<p><?php printf(__('Πρέπει να είστε να  <a href="%s">είστε συνδεδεμένοι </a> για να υποβάλετε εναλλακτική.'), get_option('siteurl')."/wp-login.php?redirect_to=".urlencode(get_permalink()));?></p>
							<?php else : ?>
							
								<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform-alter">
								<?php if ( $user_ID ) : ?>
									<p><?php printf(__('Συνδεδεμένος ως %s.'), '<a href="'.get_option('siteurl').'/wp-admin/profile.php">'.$user_identity.'</a>'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Αποσύνδεση από το λογαριασμό') ?>"><?php _e('Αποσύνδεση &raquo;'); ?></a></p>
								<?php else : ?>
									<div class="row-fluid">
										<p class="span6">
											<label for="author"><small><?php _e('Όνομα'); ?> <?php if ($req) _e('(υποχρεωτικό)'); ?></small></label>
											<input class="span12" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" type="text">
										</p>
										<p class="span6">
											  <label for="email"><small><?php _e('Mail (δεν θα δημοσιευτεί)');?> <?php if ($req) _e('(υποχρεωτικό)'); ?></small></label>
											  <input class="span12" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" type="text">
										 </p>
									</div>
								<?php endif; ?>
									<p class="span12">
										<label for="email"><small><?php _e('Τίτλος (*)', 'ma-ellak'); ?> <?php if ($req) _e('(υποχρεωτικό)'); ?></small></label>
										<input class="span12" name="ctitle" id="ctitle" value="" size="22" tabindex="3" type="text">
									</p>
									<p><textarea name="comment" placeholder="Περιγραφή (*)" class="span12" id="comment"  rows="10" tabindex="4"></textarea></p>
									<?php do_action('comment_form', $post->ID); ?>
									<div class="actions"><div class="span5 offset4"><input class="btn btn-primary btn-block" name="submit" id="submit" tabindex="5" value="<?php echo attribute_escape(__('Υποβολή Εναλλακτικής', 'ma-ellak')); ?>" type="submit"></div></div>
									<p></p>
									<p><input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" /></p>
									<p><input type="hidden" name="ctype" value="alternative" /></p>
									<input type="hidden" name="redirect_to" value="<?php echo get_permalink(); ?>/?comment=alternative#buddypress" />
									
								</form>
							<?php endif; ?>
						<?php endif; ?>
					</div>
					<div class="span8">
						<?php if(isset($_GET['comment']) and $_GET['comment']=='alternative'){ ?>
							<div class="alert alert-info"><p><?php _e('Η Εναλλακτική υποβλήθηκε επιτυχώς. Στην περίπτωση που δεν εμφανίζεται στην ακόλουθη λίστα θα δημοσιευθεί μόλις εγκριθεί απο τον Διαχειριστή.', 'ma-ellak') ?></p></div>
						<?php } ?>
						<?php if ( $salternative_list  != '' ) { echo	'<ul id="scommentlist">'.$salternative_list.'</ul>'; } ?>
					</div>
				</div>
              </div>
			  
			  <div id="tab-3" class="tab-pane<?php if(isset($_GET['comment']) and $_GET['comment']=='bpractice') echo ' active'; ?>">
				<div class="row-fluid">
					<div class="span4">
						<?php if ( comments_open() ) : ?>
							<h3 id="postcomment"><?php _e('Υποβάλετε Βέλτιστη Πρακτική'); ?></h3>
							<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
								<p><?php printf(__('Πρέπει να είστε να  <a href="%s">είστε συνδεδεμένοι </a> για να υποβάλετε Βέλτιστη Πρακτική.'), get_option('siteurl')."/wp-login.php?redirect_to=".urlencode(get_permalink()));?></p>
							<?php else : ?>
							
								<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform-praktikh">
								<?php if ( $user_ID ) : ?>
									<p><?php printf(__('Συνδεδεμένος ως %s.'), '<a href="'.get_option('siteurl').'/wp-admin/profile.php">'.$user_identity.'</a>'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Αποσύνδεση από το λογαριασμό') ?>"><?php _e('Αποσύνδεση &raquo;'); ?></a></p>
								<?php else : ?>
									<div class="row-fluid">
										<p class="span6">
											<label for="author"><small><?php _e('Όνομα'); ?> <?php if ($req) _e('(υποχρεωτικό)'); ?></small></label>
											<input class="span12" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" type="text">
										</p>
										<p class="span6">
											  <label for="email"><small><?php _e('Mail (δεν θα δημοσιευτεί)');?> <?php if ($req) _e('(υποχρεωτικό)'); ?></small></label>
											  <input class="span12" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" type="text">
										 </p>
									</div>
								<?php endif; ?>
									<p class="span12">
										<label for="email"><small><?php _e('Τίτλος (*)', 'ma-ellak'); ?> <?php if ($req) _e('(υποχρεωτικό)'); ?></small></label>
										<input class="span12 required" name="ctitle" id="ctitle" value="" size="22" tabindex="3" type="text">
									</p>
									<p class="span12">
										<label for="email"><small><?php _e('Οργανισμός', 'ma-ellak'); ?> <?php if ($req) _e('(υποχρεωτικό)'); ?></small></label>
										<input class="span12" name="corganisation" id="corganisation" value="" size="22" tabindex="3" type="text">
									</p>
									<p><textarea name="comment" placeholder="Περιγραφή (*)" class="span12" id="comment"  rows="10" tabindex="4"></textarea></p>
									<?php do_action('comment_form', $post->ID); ?>
									<div class="actions"><div class="span5 offset4"><input class="btn btn-primary btn-block" name="submit" id="submit" tabindex="5" value="<?php echo attribute_escape(__('Υποβολή Πρακτικής', 'ma-ellak')); ?>" type="submit"></div></div>
									<p></p>
									<p><input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" /></p>
									<p><input type="hidden" name="ctype" value="bpractice" /></p>
									<input type="hidden" name="redirect_to" value="<?php echo get_permalink(); ?>/?comment=bpractice#buddypress" />
									
								</form>
							<?php endif; ?>
						<?php endif; ?>
					</div>
					<div class="span8">
						<?php if(isset($_GET['comment']) and $_GET['comment']=='bpractice'){ ?>
							<div class="alert alert-info"><p><?php _e('Η Βέλτιστη Πρακτική υποβλήθηκε επιτυχώς. Στην περίπτωση που δεν εμφανίζεται στην ακόλουθή λίστα θα δημοσιευθεί μόλις εγκριθεί απο τον Διαχειριστή.', 'ma-ellak') ?></p></div>
						<?php } ?>
						<?php if ( $sbpractice_list  != '' ) { echo	'<ul id="scommentlist">'.$sbpractice_list.'</ul>'; } ?>
					</div>
				</div>
              </div>
             
			  <div id="tab-4" class="tab-pane<?php if(isset($_GET['comment']) and $_GET['comment']=='comment') echo ' active'; ?>">
				<div class="row-fluid">
					<div class="span4">
						<?php if ( comments_open() ) : ?>
							<h3 id="postcomment"><?php _e('Leave a comment'); ?></h3>
							<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
								<p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.'), get_option('siteurl')."/wp-login.php?redirect_to=".urlencode(get_permalink()));?></p>
							<?php else : ?>
							
								<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
								<?php if ( $user_ID ) : ?>
									<p><?php printf(__('Συνδεδεμένος ως %s.'), '<a href="'.get_option('siteurl').'/wp-admin/profile.php">'.$user_identity.'</a>'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Αποσύνδεση από το λογαριασμό') ?>"><?php _e('Αποσύνδεση &raquo;'); ?></a></p>
								<?php else : ?>
									<div class="row-fluid">
										<p class="span6">
											<input class="span12" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" type="text">
											<label for="author"><small><?php _e('Όνομα'); ?> <?php if ($req) _e('(υποχρεωτικό)'); ?></small></label>
										</p>
										<p class="span6">
											  <input class="span12" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" type="text">
											  <label for="email"><small><?php _e('Mail (δεν θα δημοσιευτεί)');?> <?php if ($req) _e('(υποχρεωτικό)'); ?></small></label>
										 </p>
									</div>
								<?php endif; ?>
									<p><textarea name="comment" placeholder="Η άποψή σας (*)" class="span12" id="comment"  rows="10" tabindex="4"></textarea></p>
									<?php do_action('comment_form', $post->ID); ?>
									<div class="actions"><div class="span5 offset4"><input class="btn btn-primary btn-block required" name="submit" id="submit" tabindex="5" value="<?php echo attribute_escape(__('Submit Comment')); ?>" type="submit"></div></div>
									<p></p>
									<p><input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" /></p>
									<input type="hidden" name="redirect_to" value="<?php echo get_permalink(); ?>/?comment=comment#buddypress" />
									
								</form>
							<?php endif; ?>
						<?php endif; ?>
					</div>
					<div class="span8">
						<?php if(isset($_GET['comment']) and $_GET['comment']=='comment'){ ?>
							<div class="alert alert-info"><p><?php _e('Το Σχόλιό σας υποβλήθηκε επιτυχώς. Στην περίπτωση που δεν εμφανίζεται στην ακόλουθή λίστα θα δημοσιευθεί μόλις εγκριθεί απο τον Διαχειριστή.', 'ma-ellak') ?></p></div>
						<?php } ?>
						<?php if ( $scomment_list  != '' ) { echo	'<ul id="scommentlist">'.$scomment_list.'</ul>'; } ?>
					</div>
				</div>
              </div>
			  
			  <div id="tab-5" class="tab-pane">
				<div class="row-fluid">
					<div class="span3 offset2 act-characteristics">
						<p>
						<?php
							if(get_option_tree('ma_ellak_submit_characteristic')!='')
								echo '<a href="'.get_permalink(get_option_tree('ma_ellak_submit_characteristic'))."?sid=".get_the_ID().'" class="btn button acomment-reply bp-primary-action" />'.__('Υποβάλετε Γνώρισμα', 'ma-ellak').'</a>';
							if(get_option_tree('ma_ellak_list_characteristic')!='')
							 	echo '<a href="'.get_permalink(get_option_tree('ma_ellak_list_characteristic'))."?sid=".get_the_ID().'" class="btn  button fav bp-secondary-action" />'.__('Όλα τα Γνωρίσματα', 'ma-ellak').'</a>';
							if(get_option_tree('ma_ellak_list_characteristic_rss')!='')
								echo '<a href="'.get_permalink(get_option_tree('ma_ellak_list_characteristic_rss'))."?sid=".get_the_ID().'" class="btn  button fav bp-secondary-action" target="_blank" />'.__('Eξαγωγή Γνωρισμάτων (RSS)', 'ma-ellak').'</a>';
							
							 if(ma_ellak_user_is_post_admin()){
							 	 if(get_option_tree('ma_ellak_list_characteristic_unapproved')!='')
							 	 echo '<a href="'.get_permalink(get_option_tree('ma_ellak_list_characteristic_unapproved'))."?sid=".get_the_ID().'" class="btn  button unfav bp-secondary-action" />'.__('Μη Δημοσιευμένα Γνωρίσματα', 'ma-ellak').'</a>';
								 if(get_option_tree('ma_ellak_list_characteristic_export')!='')
								 echo '<a href="'.get_permalink(get_option_tree('ma_ellak_list_characteristic_export'))."?sid=".get_the_ID().'" class="btn  button fav bp-secondary-action" target="_blank" />'.__('Eξαγωγή Γνωρισμάτων (xls)', 'ma-ellak').'</a>';
							 }
						?>
						</p>
					</div>
					<div class="span6">
						<?php echo show_latest_characteristics(get_the_ID(), 10,__('Τελευταία Γνωρίσματα', 'ma-ellak') ); ?>
					</div>
				</div>
              </div>
			  
			  <div id="tab-6" class="tab-pane">
				<div class="row-fluid">
					<div class="span8 offset4">
						<?php echo apply_filters('the_content', get_post_meta($post->ID, $ma_prefix . 'software_contact', true)); ?>
					</div>
				</div>
              </div>
			  
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