<?php // logs

if ( isset( $_POST['logs'] ) )
{
	$logs = get_option( MailPress::option_name_logs );
	
	foreach ( $_POST['logs'] as $k => $v ) $logs[$k] = $v; // so we don't delete settings if addon deactivated !
	
	update_option( MailPress::option_name_logs, $logs );

	$message = __( 'Logs settings saved', 'MailPress' );
}