<?php // tracking

if ( isset( $_POST['tracking'] ) ) 
{
	$tracking	= $_POST['tracking'];

	update_option( MailPress_tracking::option_name, $tracking );

	$message = __( "'Tracking' settings saved", 'MailPress' );
}