<?php // batches

do_action( 'MailPress_settings_batches_update' );

if ( isset( $_POST['mp_message'] ) ) 
{
	$message = $_POST['mp_message'];
	$no_error = false;
}
else
{
	$message = __( "'Batches' settings saved", 'MailPress' );
}

