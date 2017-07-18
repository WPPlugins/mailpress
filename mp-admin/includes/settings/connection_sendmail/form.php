<?php // connection_sendmail

if ( !isset( $connection_sendmail ) ) 
{
	$connection_sendmail = get_option( MailPress_connection_sendmail::option_name );
}

if ( !isset( $connection_sendmail['cmd'] ) ) 
{
	$connection_sendmail['cmd'] = 'std';
}
?>
<form name="<?php echo basename(__DIR__); ?>" method="post" class="mp_settings">

	<input type="hidden" name="_tab" value="<?php echo basename(__DIR__); ?>" />

	<table class="form-table">
		<tr>
			<th><?php _e( 'Connect', 'MailPress' ); ?></th>
			<td class="field">
				<label for="connection_sendmail_radio1">
					<input type="radio" value="std"    name="connection_sendmail[cmd]" id="connection_sendmail_radio1" class="connection_sendmail"<?php checked( 'std', $connection_sendmail['cmd'] ); ?> />
					<?php _e( "using '/usr/sbin/sendmail -bs'", 'MailPress' ); ?>
				</label>
				<br />
				<label for="sendmail-custom">
					<input type="radio" value="custom" name="connection_sendmail[cmd]" id="sendmail-custom" class="connection_sendmail"<?php checked( 'custom', $connection_sendmail['cmd'] ); ?> />
					<?php _e( 'using a custom command', 'MailPress' ); ?>
				</label>
				&#160;&#160;
				<span id="sendmail-custom-cmd" <?php if ( 'custom' != $connection_sendmail['cmd'] ) echo ' style="display:none;"'; ?>>
					<input type="text" name="connection_sendmail[custom]" size="40" value="<?php echo $connection_sendmail['custom']; ?>" />
				</span>
			</td>
		</tr>
	</table>
<?php MP_AdminPage::save_button(); ?>
</form>