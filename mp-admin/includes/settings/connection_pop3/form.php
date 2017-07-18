<?php // connection_pop3

if ( class_exists( 'MailPress_bounce_handling' ) )
{
	if ( !isset( $connection_pop3 ) ) 
	{
		$connection_pop3 = get_option( MailPress_bounce_handling::option_name_pop3 );
	}
}

if ( class_exists( 'MailPress_bounce_handling_II' ) )
{
	if ( !isset( $connection_pop3 ) ) 
	{
		$connection_pop3 = get_option( MailPress_bounce_handling_II::option_name_pop3 );
	}
}

?>
<form name="<?php echo basename(__DIR__); ?>" method="post" class="mp_settings">

	<input type="hidden" name="_tab" value="<?php echo basename(__DIR__); ?>" />

	<table class="form-table">
		<tr>
			<th><?php _e( 'POP3 Server', 'MailPress' ); ?></th>
			<td class="field">
				<input type="text" name="connection_pop3[server]" size="25" value="<?php if ( isset( $connection_pop3['server'] ) ) echo $connection_pop3['server']; ?>" />
			</td>
		</tr>
		<tr>
			<th><?php _e( 'Port', 'MailPress' ); ?></th>
			<td class="field">
				<input type="text" name="connection_pop3[port]" size="4" value="<?php if ( isset( $connection_pop3['port'] ) ) echo $connection_pop3['port']; ?>" />
			</td>
		</tr>
		<tr>
			<th><?php _e( 'Username', 'MailPress' ); ?></th>
			<td class="field">
				<input type="text" name="connection_pop3[username]" size="25" value="<?php if ( isset( $connection_pop3['username'] ) ) echo $connection_pop3['username']; ?>" />
			</td>
		</tr>
		<tr>
			<th><?php _e( 'Password', 'MailPress' ); ?></th>
			<td>
				<input type="password" name="connection_pop3[password]" size="25" value="<?php if ( isset( $connection_pop3['password'] ) ) echo $connection_pop3['password']; ?>" />
			</td>
		</tr>
	</table>
<?php MP_AdminPage::save_button(); ?>
</form>