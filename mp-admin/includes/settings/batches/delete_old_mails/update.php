<?php // delete_old_mails

if ( isset( $_POST['batch_delete_old_mails'] ) ) 
{
	$batch_delete_old_mails = $_POST['batch_delete_old_mails'];

	$old_delete_old_mails = get_option( MailPress_delete_old_mails::option_name );

	update_option( MailPress_delete_old_mails::option_name, $batch_delete_old_mails );

	if ( !isset( $old_delete_old_mails['batch_mode'] ) )
	{
		$old_delete_old_mails['batch_mode'] = '';
	}

	if ( $old_delete_old_mails['batch_mode'] != $batch_delete_old_mails['batch_mode'] )
	{
		if ( 'wpcron' != $batch_delete_old_mails['batch_mode'] )
		{
			wp_clear_scheduled_hook( MailPress_delete_old_mails::process_name );
		}
		else
		{
			MailPress_delete_old_mails::schedule();
		}
	}
}