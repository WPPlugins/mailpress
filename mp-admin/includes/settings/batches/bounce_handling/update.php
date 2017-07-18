<?php // bounce_handling

if ( isset( $_POST['bounce_handling'] ) ) 
{
	$bounce_handling	= $_POST['bounce_handling'];

	$old_bounce_handling = get_option( MailPress_bounce_handling::option_name );

	update_option( MailPress_bounce_handling::option_name, $bounce_handling );

	if ( !isset( $old_bounce_handling['batch_mode'] ) )
	{
		$old_bounce_handling['batch_mode'] = '';
	}

	if ( $old_bounce_handling['batch_mode'] != $bounce_handling['batch_mode'] )
	{
		if ( 'wpcron' != $bounce_handling['batch_mode'] )
		{
			wp_clear_scheduled_hook( MailPress_bounce_handling::process_name );
		}
		else
		{
			MailPress_bounce_handling::schedule();
		}
	}
}