<?php // connection_smtp

if ( isset( $_POST['connection_smtp'] ) ) 
{
	$connection_smtp	= stripslashes_deep( $_POST['connection_smtp'] );

	if ( 'custom' == $connection_smtp['port'] ) $connection_smtp ['port'] = $connection_smtp['customport'];
	unset( $connection_smtp['customport'] );

	switch ( true )
	{
		case ( !function_exists( 'proc_open' ) ) :
			$message = sprintf( __( '"proc_open" php function is not available, you need to activate <a href="%1$s">Connection_php_mail</a> add-on.', 'MailPress' ), MailPress_addons ); $no_error = false;
		break;
		case ( empty( $connection_smtp['server'] ) ) :
			$serverclass = true;
			$message = __( 'field should not be empty', 'MailPress' ); $no_error = false;
		break;
		case ( empty( $connection_smtp['username'] ) && !empty( $connection_smtp['password'] ) ) :
			$usernameclass = true;
			$message = __( 'field should not be empty', 'MailPress' ); $no_error = false;
		break;
		case ( ( isset( $connection_smtp['smtp-auth'] ) && ( '@PopB4Smtp' == $connection_smtp['smtp-auth'] ) ) && ( empty( $connection_smtp['pophost'] ) ) ) : 
			$pophostclass = true;
			$message = __( 'field should not be empty', 'MailPress' ); $no_error = false;
		break;
		default :
			update_option( MailPress::option_name_smtp, $connection_smtp );
			$message = __( 'SMTP settings saved, Test it !!', 'MailPress' );
		break;
	}
}