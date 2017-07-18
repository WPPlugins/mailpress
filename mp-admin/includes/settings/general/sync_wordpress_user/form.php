<?php //sync_wordpress_user

$sync_wordpress_user = get_option( MailPress_sync_wordpress_user::option_name );

?>
	<tr>
		<th><label for="sync_wordpress_user_register_form"><?php _e( 'Registration Form subscriptions', 'MailPress' ); ?></label></th>
		<td>
			<input type="checkbox" name="sync_wordpress_user[register_form]" id="sync_wordpress_user_register_form"<?php if ( isset( $sync_wordpress_user['register_form'] ) ) checked( 'on', $sync_wordpress_user['register_form'] ); ?> />
		</td>
	</tr>