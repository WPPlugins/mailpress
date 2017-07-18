<?php // connection_php_mail

if ( isset( $_POST['connection_php_mail'] ) )
{
	$connection_php_mail = $_POST['connection_php_mail'];

	update_option( MailPress_connection_php_mail::option_name, $connection_php_mail );

	$message = __( "'PHP MAIL' settings saved", 'MailPress' );
}