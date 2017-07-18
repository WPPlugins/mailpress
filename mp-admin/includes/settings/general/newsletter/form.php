<?php // newsletter

global $mp_general;

?>
		<tr class="mp_sep">
			<th class="thtitle"><?php _e( 'Newsletters', 'MailPress' ); ?></th>
			<td></td>
		</tr>
		<tr>
			<th><?php _e( 'Show at most', 'MailPress' ); ?></th>
			<td class="nopad">
				<select name="general[post_limits]">
<option value="0">&#160;</option>
<?php MP_AdminPage::select_number( 1, 99, ( isset( $mp_general['post_limits'] ) ) ? $mp_general['post_limits'] : '' ); ?>
				</select>
				&#160;<?php _e( 'posts <i>(blank = WordPress Reading setting)</i>', 'MailPress' ); ?>
			</td>
		</tr>
<?php do_action( 'MailPress_settings_general_newsletter_form' ); ?>