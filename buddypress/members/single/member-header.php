
<?php do_action( 'bp_before_member_header' ); ?>

<div id="item-header" role="complementary">
	<div class="row-fluid">
	  <div class="cols">
		<div class="span4 col side-left">
			<p><a href="<?php bp_displayed_user_link(); ?>">
				<?php bp_displayed_user_avatar( 'type=full&width=300&height=300' ); ?>
			</a></p>
			<?php if ( bp_is_active( 'activity' ) && bp_activity_do_mentions() ) : ?>
				<p>@<?php bp_displayed_user_username(); ?></p>
			<?php endif; ?>
			<p><span class="activity"><?php bp_last_activity( bp_displayed_user_id() ); ?></span></p>
		</div>
			
		
		<div class="span8 col side-right">
			<?php do_action( 'bp_before_member_header_meta' ); ?>
		  <h2><?php bp_displayed_user_fullname(); ?></h2>
		    <p><?php do_action( 'bp_member_header_actions' ); ?></p>
		   <p><?php //bp_activity_latest_update( bp_displayed_user_id() ); ?></p>
		  <?php
		/***
		 * If you'd like to show specific profile fields here use:
		 * bp_member_profile_data( 'field=About Me' ); -- Pass the name of the field
		 */
		 echo '<p>';
		 bp_member_profile_data( 'field=Σύντομο Βιογραφικό' );
		 echo '</p>';
		 do_action( 'bp_profile_header_meta' );

		 ?>
		</div>
	</div>
</div>
</div></div>
<?php do_action( 'bp_after_member_header' ); ?>
<?php do_action( 'template_notices' ); ?>