<?php
/**
* Σελίδα 1-1 Αντιστοίχισης Buddypress Groups και Θεματικών
*
* @licence GPL
* @author Fotis Routsis - fotis@routsis.gr
* 
* Project URL http://ma.ellak.gr
*/


$options = get_option('ma_ellak_thema_bp_match');

if(isset($_POST['thema_save'])) {
	$options['ma_ellak_thema_bp'] = $_POST['bp_thema'];
	update_option('ma_ellak_thema_bp_match', $options);
	$options = get_option('ma_ellak_thema_bp_match');
}

$terms = get_terms( 'thema', 'hide_empty=0' );
$options = (is_string($options)) ? @unserialize($options) : $options;
$options = $options['ma_ellak_thema_bp'];

?>
	
<div class="wrap">
	<div class="icon32" id="icon-options-general"><br></div>	
	<h2><?php _e('Αντιστοίχιση BP Groups και Θεματικών', 'ma-ellak'); ?></h2>
	<br /><br />
	<?php _e('Για το κάθε Group διάλεξτε μια Θεματική', 'ma-ellak'); ?>
	<br /><br />
	<form action="#" method="post" enctype="multipart/form-data" name="thema_form" id="thema_form">
		<table class="form-table">
			<tbody>	
				<?php if ( bp_has_groups() ) : while ( bp_groups() ) : bp_the_group(); ?>
				<tr valign="top">
					<th scope="row"><?php echo bp_get_group_id(); ?>) <strong><a href="<?php bp_group_permalink() ?>" target="_blank"><?php bp_group_name() ?></strong></a></th>
					<td>
						<select name="bp_thema[<?php echo bp_get_group_id(); ?>]" size="1">
						<option value="0">--<?php _e('Διαλέξτε Θεματική', 'ma-ellak'); ?>--</option>
						<?php 
							foreach ( $terms as $term ) {
								if ( $options[bp_get_group_id()] == $term->term_id ) {
									echo '<option value="' . $term->term_id . '" selected>' . $term->name . '</option>';
								} else {
									echo '<option value="' . $term->term_id . '" >' . $term->name . '</option>';
								}
							}
						?>
						</select>
					</td>
				</tr>
				<?php endwhile; else: endif; ?>
			</tbody>
		</table>
		<br /><br />
		<input class="button-primary" type="submit" name="thema_save" value="<?php _e('Αποθήκευση', 'ma-ellak'); ?>" />
	</form>	
</div>