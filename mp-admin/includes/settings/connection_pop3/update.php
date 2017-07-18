<?php // connection_pop3

if ( isset ( $_POST['connection_pop3'] ) ) 
{
	do_action( 'MailPress_settings_connection_pop3_update' );

	$message = __( "'POP3' settings saved", 'MailPress' );
}
