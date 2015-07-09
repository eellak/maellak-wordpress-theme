<?php

  /**
  *@desc Included at the bottom of post.php and single.php, deals with all comment layout
  */
?>
<div class="row-fluid">
<div class="span8">
 <?php 
  if ( !empty($post->post_password) && $_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) :
?>
<p><?php _e('Συμπληρώστε τον κωδικό σας για να δείτε το σχόλιο.'); ?></p>
<?php return; endif; ?>

<h3 id="comments"><?php comments_number(__('Κανένα σχόλιο'), __('1 Σχόλιο'), __('% Σχόλια')); ?>
<?php if ( comments_open() ) : ?>
	<a href="#postcomment" title="<?php _e("Αφήστε το σχόλιο σας!"); ?>">&raquo;</a>
<?php endif; ?>
</h3>

<?php if ( $comments ) : ?>
<ol id="commentlist">

<?php foreach ($comments as $comment) : ?>
	<li id="comment-<?php comment_ID() ?>">
  <?php echo get_avatar( $comment, 32 ); ?>  
	<?php comment_text() ?>
	<p><cite><?php comment_type(__('Σχόλια'), __('Trackback'), __('Pingback')); ?> <?php _e('by'); ?> <?php comment_author_link() ?> &#8212; <?php comment_date() ?> @ <a href="#comment-<?php comment_ID() ?>"><?php comment_time() ?></a></cite> <?php edit_comment_link(__("Edit This"), ' |'); ?></p>
	</li>

<?php endforeach; ?>

</ol>

<?php else : // If there are no comments yet ?>
	<p><?php _e('Δεν υπάρχουν ακόμα σχόλια.'); ?></p>
<?php endif; ?>

<p><?php comments_rss_link(__('<abbr title="Really Simple Syndication">RSS</abbr> feed for comments on this post.')); ?>
<?php if ( pings_open() ) : ?>
	<a href="<?php trackback_url() ?>" rel="trackback"><?php _e('TrackBack <abbr title="Universal Resource Locator">URL</abbr>'); ?></a>
<?php endif; ?>
</p>

<?php if ( comments_open() ) : ?>
<h3 id="postcomment"><?php _e('Αφήστε το σχόλιο σας!'); ?></h3>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p><?php printf(__('Πρέπει να είστε <a href="%s">συνδεδεμένος</a> για να σχολιάσετε.'), get_option('siteurl')."/wp-login.php?redirect_to=".urlencode(get_permalink()));?></p>
<?php else : ?>

<script>
(function($){
	$(document).ready( function(){
	$("#commentform").validate({
			ignore: "",
			rules: {
				comment:{ required:true },
				
			},
			messages: {
				comment:{ required:"Απαιτειται" },
				
			}
		});
	} );
})(jQuery)
</script>
<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>

<p><?php printf(__('Είστε συνδεδεμένος ως %s.'), '<a href="'.get_option('siteurl').'/wp-admin/profile.php">'.$user_identity.'</a>'); ?> 
<a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Αποσύνδεση από τον συγκεκριμένο λογαριασμό') ?>"><?php _e('Αποσύνδεση &raquo;'); ?></a></p>

<?php else : ?>

 	<div class="row-fluid">
 		<p class="span6">
       		<input class="span12" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" type="text">
      	 	<label for="author"><small><?php _e('Name'); ?> <?php if ($req) _e('(required)'); ?></small></label>
        </p>
        <p class="span6">
                  <input class="span12" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" type="text">
                  <label for="email"><small><?php _e('Mail (will not be published)');?> <?php if ($req) _e('(required)'); ?></small></label>
         </p>
    </div>

<?php endif; ?>

<!--<p><small><strong>XHTML:</strong> <?php printf(__('Μπορείτε να χρησιμοποιήσετε αυτά τα tags: %s'), allowed_tags()); ?></small></p>-->

<p><textarea name="comment" placeholder="Η άποψή σας" class="span12" id="comment"  rows="10" tabindex="4"></textarea></p>
<?php do_action('comment_form', $post->ID); ?>
<div class="actions"><div class="span4"><input class="btn btn-primary btn-block" name="submit" id="submit" tabindex="5" value="<?php echo attribute_escape(__('Submit Comment')); ?>" type="submit"></div></div>
<p></p>

<p><input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" /></p>

</form>




<?php endif; // If registration required and not logged in ?>

<?php else : // Comments are closed ?>
<p><?php _e('Sorry, the comment form is closed at this time.'); ?></p>

<?php endif; ?>

</div>
</div>
<p></p>
<p></p>
<p></p>
<p></p>
