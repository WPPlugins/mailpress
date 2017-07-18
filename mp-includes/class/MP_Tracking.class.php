<?php
class MP_Tracking
{
	public static function process()
	{
		$meta = MP_Mail_meta::get_by_id( $_GET['mm'] );
		if ( $meta )
		{
			do_action( 'mp_tracking_process', $meta ); // will activate if any !
			switch ( $_GET['tg'] )
			{
				case ( 'l' ) :
					switch ( $meta->meta_value )
					{
						case '{{subscribe}}' :
							$url = MP_User::get_subscribe_url( $_GET['us'] );
						break;
						case '{{unsubscribe}}' :
							$url = MP_User::get_unsubscribe_url( $_GET['us'] );
						break;
						case '{{viewhtml}}' :
							$url = MP_User::get_view_url( $_GET['us'], $meta->mp_mail_id );
						break;
						default :
							$url = $meta->meta_value;
						break;
					}
					MP_::mp_redirect( $url );
				break;
				case ( 'o' ) :
					self::download( '_.gif', MP_ABSPATH . 'mp-includes/images/_.gif', 'image/gif', 'gif_' . $_GET['us'] . '_' . $_GET['mm'] . '.gif' );
				break;
			}
		}
		MP_::mp_redirect( home_url() );
	}

	public static function download( $file, $file_fullpath, $mime_type, $name = false )
	{
		if ( !$name ) $name = $file;
		if ( strstr( $_SERVER['HTTP_USER_AGENT'], "MSIE" ) ) $file = preg_replace( '/\./', '%2e', $file, substr_count( $file, '.' ) - 1 );

		if( !$fdl = @fopen( $file_fullpath, 'r' ) ) 	MP_::mp_die( __( 'Cannot Open File !', 'MailPress' ) );

		header( "Cache-Control: " );# leave blank to avoid IE errors
		header( "Pragma: " );# leave blank to avoid IE errors
		header( "Content-type: " . $mime_type );
		header( "Content-Disposition: attachment; filename=\"".$file."\"" );
		header( "Content-length:".( string )( filesize( $file_fullpath ) ) );
		sleep( 1 );
		fpassthru( $fdl );
		MP_::mp_die();
	}
}