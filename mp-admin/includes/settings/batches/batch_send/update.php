<?php // batch_send

if ( isset( $_POST['batch_send'] ) ) 
{
	$batch_send = $_POST['batch_send'];

	$old_batch_send = get_option( MailPress_batch_send::option_name );

	update_option( MailPress_batch_send::option_name, $batch_send );

	if ( !isset( $old_batch_send['batch_mode'] ) )
	{
		$old_batch_send['batch_mode'] = '';
	}

	if ( $old_batch_send['batch_mode'] != $batch_send['batch_mode'] )
	{
		if ( 'wpcron' != $batch_send['batch_mode'] )
		{
			wp_clear_scheduled_hook( MailPress_batch_send::process_name );
		}
		else
		{
			MailPress_batch_send::schedule();
		}
	}
}