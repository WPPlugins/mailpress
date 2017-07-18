<?php // bounce_handling_II

if ( isset( $_POST['bounce_handling_II'] ) ) 
{
	$bounce_handling_II	= $_POST['bounce_handling_II'];

	$old_bounce_handling = get_option( MailPress_bounce_handling_II::option_name );

	update_option( MailPress_bounce_handling_II::option_name, $bounce_handling_II );

	if ( !isset( $old_bounce_handling['batch_mode'] ) ) 
	{
		$old_bounce_handling['batch_mode'] = '';
	}

	if ( $old_bounce_handling['batch_mode'] != $bounce_handling_II['batch_mode'] )
	{
		if ( 'wpcron' != $bounce_handling_II['batch_mode'] )
		{
			wp_clear_scheduled_hook( MailPress_bounce_handling_II::process_name );
		}
		else
		{
			MailPress_bounce_handling_II::schedule();
		}
	}
}