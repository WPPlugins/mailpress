<?php // bounce_handling_II

if ( isset( $_POST['connection_pop3'] ) ) 
{
	$connection_pop3 = $_POST['connection_pop3'];

	update_option( self::option_name_pop3, $connection_pop3 );
}