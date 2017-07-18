<?php // connection_sendmail

if ( isset( $_POST['connection_sendmail'] ) )
{
	$connection_sendmail = $_POST['connection_sendmail'];

	switch ( true )
	{
		case ( !function_exists( 'proc_open' ) ) :
			$message = sprintf( __( '"proc_open" php function is not available, you need to activate <a href="%1$s">Connection_php_mail</a> add-on.', 'MailPress' ), MailPress_addons ); $no_error = false;
		break;
		default :
			update_option( MailPress_connection_sendmail::option_name, $connection_sendmail );
			$message = __( "'SENDMAIL' settings saved", 'MailPress' );
		break;
	}
}
