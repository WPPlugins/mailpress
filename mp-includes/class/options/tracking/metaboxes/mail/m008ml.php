<?php
if ( class_exists( 'MailPress_mailinglist' ) ) {
class MP_Tracking_metabox_m008ml extends MP_tracking_metabox_
{
	var $id	= 'm008ml';
	var $context= 'normal';
	var $file 	= __FILE__;

	function meta_box( $mail )
	{
		global $wpdb;
		$tracks = $wpdb->get_results( $wpdb->prepare( "SELECT track, count( * ) as count FROM $wpdb->mp_tracks WHERE mail_id = %d GROUP BY 1 ORDER BY 2 DESC, 1 DESC;", $mail->id ) );
		if ( $tracks ) foreach( $tracks as $track )
		{
			$users = $wpdb->get_results( $wpdb->prepare( "SELECT SQL_CALC_FOUND_ROWS DISTINCT user_id FROM $wpdb->mp_tracks WHERE mail_id = %d AND track = %s;", $mail->id, $track->track ) );
			$total = $wpdb->get_var( "SELECT FOUND_ROWS()" );

			$url = esc_url( add_query_arg( array_map ( 'urlencode', array( 'action' => 'create_tracking_mailinglist', 'mail_id' => $mail->id, 'track' => $track->track ) ), MailPress_users ) );
			$title = sprintf( _n( __( 'create mailinglist with %s user', 'MailPress' ), __( 'create mailinglist with %s users', 'MailPress' ), $total ), $total );
		//	echo "( {$track->count} ) " . MailPress_tracking::translate_track( $track->track, $mail->id, 50 ) . '<span style="float:right"><a class="post-com-count" href="' . $url . '" title="' . esc_attr( $title ) . '"><span class="comment-count" style="font-size:12px;">' . $total . '</span></a></span><br /><br />';

			$lib_url = ( current_user_can( 'MailPress_manage_mailinglists' ) ) ? '<a href="' . $url . '">' . __( 'Create corresponding mailing list', 'MailPress' ) . '</a><br /><br />' : '';
			$lib_url = ( current_user_can( 'MailPress_manage_mailinglists' ) ) ? '<a href="' . $url . '" target="_blank"><span class="icon mailinglist" title="' . esc_attr( __( 'Create corresponding mailing list', 'MailPress' ) ) . '"></span></a><br /><br />' : '';

			switch( $track->track )
			{
				case MailPress_tracking_openedmail :
					if ( $track->count < 2 )
						if ( $total < 2 ) 	$lib = __( '%1$s mail opened by %2$s recipient %3$s', 'MailPress' );
						else 				$lib = __( '%1$s mail opened by %2$s recipients %3$s', 'MailPress' );
					else
						if ( $total < 2 ) 	$lib = __( '%1$s mails opened by %2$s recipient %3$s', 'MailPress' );
						else 				$lib = __( '%1$s mails opened by %2$s recipients %3$s', 'MailPress' );
				break;
				case '!!unsubscribed!!' :
					if ( $track->count < 2 )
						if ( $total < 2 ) 	$lib = __( '%2$s recipient <b>unsubscribed</b> (%1$s event) %3$s', 'MailPress' );
						else 				$lib = __( '%2$s recipient <b>unsubscribed</b> (%1$s events) %3$s', 'MailPress' );
					else
						if ( $total < 2 ) 	$lib = __( '%2$s recipients <b>unsubscribed</b> (%1$s event) %3$s', 'MailPress' );
						else 				$lib = __( '%2$s recipients <b>unsubscribed</b> (%1$s events) %3$s', 'MailPress' );
				break;
				default:
					if ( $track->count < 2 )
						if ( $total < 2 ) 	$lib = __( '%1$s click on link %4$s by %2$s recipient %3$s', 'MailPress' );
						else 				$lib = __( '%1$s click on link %4$s by %2$s recipients %3$s', 'MailPress' );
					else
						if ( $total < 2 ) 	$lib = __( '%1$s clicks on link %4$s by %2$s recipient %3$s', 'MailPress' );
						else 				$lib = __( '%1$s clicks on link %4$s by %2$s recipients %3$s', 'MailPress' );
					break;
			}

			printf( $lib, $track->count, $total, $lib_url, MailPress_tracking::translate_track( $track->track, $mail->id, 50 ) );
		}
	}
}
new MP_Tracking_metabox_m008ml( __( 'Most clicked/mailinglists', 'MailPress' ) );
}