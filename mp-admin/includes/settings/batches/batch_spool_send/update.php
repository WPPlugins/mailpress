<?php // batch_spool_send

if ( isset( $_POST['batch_spool_send'] ) ) 
{
	$batch_spool_send = $_POST['batch_spool_send'];
	$batch_spool_send['path'] = trim( stripslashes( $batch_spool_send['path'] ) );

	$old_batch_spool_send = get_option( MailPress_batch_spool_send::option_name );

	switch ( true )
	{
		case ( !empty( $batch_spool_send['path'] ) && !MailPress_batch_spool_send::is_path( $batch_spool_send['path'] ) ) :
			$spoolpath = true;
			$_POST['mp_message'] = __( 'path is invalid', 'MailPress' );
		break;
		default :
			update_option( MailPress_batch_spool_send::option_name, $batch_spool_send );

			if ( empty( $batch_spool_send['path'] ) && !is_dir( MP_ABSPATH . 'tmp/spool' ) )
			{
				mkdir( MP_ABSPATH . 'tmp/spool' );
			}

			if ( !isset( $old_batch_spool_send['batch_mode'] ) )
			{
				$old_batch_spool_send['batch_mode'] = '';
			}

			if ( $old_batch_spool_send['batch_mode'] != $batch_spool_send['batch_mode'] )
			{
				if ( 'wpcron' != $batch_spool_send['batch_mode'] )
				{
					wp_clear_scheduled_hook( MailPress_batch_spool_send::process_name );
				}
				else
				{
					MailPress_batch_spool_send::schedule();
				}
			}
		break;
	}
}