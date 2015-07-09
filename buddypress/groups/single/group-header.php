<?php

do_action( 'bp_before_group_header' );

?>
<div id="item-header" role="complementary">
	<div class="row-fluid">
	  <div class="cols">
		<div class="span3 col side-left">
			<p><?php bp_group_avatar('type=full&width=200&height=200'); ?></p>
				
				<?php 
					/*
					if ( bp_group_is_visible() ) : ?>
					<p>
						<?php _e( 'Group Admins', 'buddypress' ); ?>:
						<?php ma_bp_group_list_admins();
						do_action( 'bp_after_group_menu_admins' ); ?>
					</p>
				
				<?php if ( bp_group_has_moderators() ) : ?>
						<p>
				<?php		do_action( 'bp_before_group_menu_mods' ); ?>
							<?php _e( 'Group Mods' , 'buddypress' ); ?>: 
							<?php ma_bp_group_list_mods();
							do_action( 'bp_after_group_menu_mods' ); ?>
						</p>
				<?php
						endif;

					endif; */ ?>

		</div>
		<div class="span9 col side-right">
		  <h2><?php bp_group_name(); ?></h2>
		   <p><span class="activity"><?php printf( __( 'active %s', 'buddypress' ), bp_get_group_last_active() ); ?></span></p>
		 <?php //bp_group_description(); ?>
		 <p>
			<?php _e( 'Μονάδες Αριστείας ', 'ma-ellak' ); ?>
			<?php ma_ellak_get_unit_per_thema_by_bp( bp_get_group_id()); ?>
		</p>
		 <?php do_action( 'bp_before_group_header_meta' ); ?>
		 <?php do_action( 'bp_group_header_actions' ); ?>
		 <?php do_action( 'bp_group_header_meta' ); ?>
		</div>
	  </div>
	</div>
</div><!-- #item-header --></div>
<?php
do_action( 'bp_after_group_header' );
do_action( 'template_notices' );
?>