<?php
if ( class_exists( 'MailPress' ) && !class_exists( 'MailPress_bounce_handling_II' ) )
{
/*
Plugin Name: MailPress_bounce_handling_II
Plugin URI: http://blog.mailpress.org/tutorials/add-ons/bounce_handling_ii/
Description: Users : bounce management ( based on mail headers & string detection in mail body )
Version: 6.0
*/

class MailPress_bounce_handling_II
{
	const meta_key     	= '_MailPress_bounce_handling';
	const option_name 	= 'MailPress_bounce_handling_II';
	const option_name_pop3 	= 'MailPress_connection_pop3';
	const log_name = 'bounce_handling_II';

	const process_name		= 'mp_process_bounce_handling_II';

	const bt = 132;

	function __construct()
	{
// prepare mail
		add_filter( 'MailPress_swift_message_headers',			array( __CLASS__, 'swift_message_headers' ), 8, 2 );

// for batch mode
		add_action( self::process_name,			array( __CLASS__, 'process' ) );

		$config = get_option( self::option_name );
		if ( 'wpcron' == $config['batch_mode'] )
		{	
			add_action( 'MailPress_schedule_bounce_handling_II',	array( __CLASS__, 'schedule' ) );
		}

		if ( is_admin() )
		{
		// for install
			register_activation_hook( plugin_basename( __FILE__ ),	array( __CLASS__, 'install' ) );
			register_deactivation_hook( plugin_basename( __FILE__ ),array( __CLASS__, 'uninstall' ) );
		// for link on plugin page
			add_filter( 'plugin_action_links',				array( __CLASS__, 'plugin_action_links' ), 10, 2 );

		// for settings
			add_filter( 'MailPress_scripts',					array( __CLASS__, 'scripts' ), 8, 2 );
			add_filter( 'MailPress_settings_tab',				array( __CLASS__, 'settings_tab' ), 20, 1 );
			add_filter( 'MailPress_settings_tab_connection',		array( __CLASS__, 'settings_tab_connection' ), 95, 1 );
		// for settings batches
			add_filter( 'MailPress_settings_batches_help',		array( __CLASS__, 'settings_batches_help' ), 20, 1 );
			add_action( 'MailPress_settings_batches_update',	array( __CLASS__, 'settings_batches_update' ), 20 );
			add_action( 'MailPress_settings_batches_form',		array( __CLASS__, 'settings_batches_form' ), 20 );
		// for settings pop3
			add_action( 'MailPress_settings_connection_pop3_update',		array( __CLASS__, 'settings_connection_pop3_update' ), 20 );
		// for settings logs
			add_action( 'MailPress_settings_logs_form',				array( __CLASS__, 'settings_logs_form' ), 30, 1 );


			if ( 'wpcron' == $config['batch_mode'] )
			{	
			// for autorefresh
				add_filter( 'MailPress_autorefresh_every',		array( __CLASS__, 'autorefresh_every' ), 8, 1 );
				add_filter( 'MailPress_autorefresh_js',		array( __CLASS__, 'autorefresh_js' ), 8, 1 );
			}
			if ( !class_exists( 'MailPress_bounce_handling' ) )
			{
			// for users list
				add_filter( 'MailPress_get_icon_users',		array( __CLASS__, 'get_icon_users' ), 8, 2 );
			// for meta box in user page
				add_action( 'MailPress_add_meta_boxes_user',	array( __CLASS__, 'meta_boxes_user' ), 8, 2 );
			}
		}

		if ( !class_exists( 'MailPress_bounce_handling' ) )
		{
		// for mails list
			add_filter( 'MailPress_mails_columns',				array( __CLASS__, 'mails_columns' ), 10, 1 );
			add_filter( 'MailPress_mails_get_row',				array( __CLASS__, 'mails_get_row' ), 10, 4 );
		// view bounce
			add_action( 'mp_action_view_bounce',				array( __CLASS__, 'mp_action_view_bounce' ) ); 
		}
	}

// prepare mail
	public static function swift_message_headers( $message, $row )
	{
		if ( !class_exists( 'MailPress_bounce_handling' ) )
		{
			$config = get_option( self::option_name );
			if ( isset( $config['Return-Path'] ) && is_email( $config['Return-Path'] ) ) $message->setReturnPath( $config['Return-Path'] );
		}

		global $wpdb;
		$headers = array( 
					array( 	'type' => Swift_Mime_Header::TYPE_TEXT , 
							'name' => 'X-MailPress-blog-id',
							'value' => $wpdb->blogid
					 ),
					array( 	'type' => Swift_Mime_Header::TYPE_TEXT , 
							'name' => 'X-MailPress-mail-id', 
							'value' => $row->id
					 ),
					array( 	'type' => Swift_Mime_Header::TYPE_TEXT , 
							'name' => 'X-MailPress-user-id',
							'value' => ( isset( $row->mp_user_id ) ) ? $row->mp_user_id : '{{_user_id}}'
					 ),
				 );

		$_headers = $message->getHeaders();
		foreach ( $headers as $header )
		{
			switch ( $header['type'] )
			{
				case Swift_Mime_Header::TYPE_TEXT :
					$_headers->addTextHeader( $header['name'], $header['value'] );
			  	break;
/*
				case Swift_Mime_Header::TYPE_PARAMETERIZED :
					$_headers->addParameterizedHeader( $header['name'], $header['value'], $header['parms'] );
			  	break;
				case Swift_Mime_Header::TYPE_MAILBOX :
					$_headers->addMailboxHeader( $header['name'], $header['value'] );
			  	break;
				case Swift_Mime_Header::TYPE_DATE :
					$_headers->addDateHeader( $header['name'], $header['value'] );
			  	break;
				case Swift_Mime_Header::TYPE_ID :
					$_headers->addIdHeader( $header['name'], $header['value'] );
			  	break;
				case Swift_Mime_Header::TYPE_PATH :
					$_headers->addPathHeader( $header['name'], $header['value'] );
			  	break;
*/
			}
		}

		return $message;
	}

// process
	public static function process()
	{
		MP_::no_abort_limit();

		new MP_Bounce_II();
	}

// schedule
	public static function schedule()
	{
		$config = get_option( self::option_name );
		$now4cron = current_time( 'timestamp', 'gmt' );

		if ( !wp_next_scheduled( self::process_name ) ) 
			wp_schedule_single_event( $now4cron + $config['every'], self::process_name );
	}

////  ADMIN  ////
////  ADMIN  ////
////  ADMIN  ////
////  ADMIN  ////

// install
	public static function install() 
	{
		self::uninstall();

		$pop3 = get_option( self::option_name_pop3 );
		if ( !$pop3 )
		{
			$pop3 = get_option( self::option_name );
			if ( $pop3 ) update_option( self::option_name_pop3, $pop3 );
		}

		MP_Log::set_option( self::log_name );

		do_action( 'MailPress_schedule_bounce_handling_II' );
	}

	public static function uninstall() 
	{
		wp_clear_scheduled_hook( self::process_name );
	}

// for link on plugin page
	public static function plugin_action_links( $links, $file )
	{
		return MailPress::plugin_links( $links, $file, plugin_basename( __FILE__ ), 'batches' );
	}

// for settings
	public static function scripts( $scripts, $screen ) 
	{
		if ( $screen != MailPress_page_settings ) return $scripts;

		wp_register_script( 'mp-bounce-handling_II', 	'/' . MP_PATH . 'mp-admin/js/settings_bounce_handling_II.js', array(), false, 1 );
		$scripts[] = 'mp-bounce-handling_II';
		return $scripts;
	}

	public static function settings_tab( $tabs )
	{
		$tabs['batches'] = __( 'Batches', 'MailPress' );
		return $tabs;
	}

	public static function settings_tab_connection( $tabs )
	{
		$tabs['connection_pop3'] = __( 'POP3', 'MailPress' );
		return $tabs;
	}

// for settings batches
	public static function settings_batches_help( $content )
	{
		include ( MP_ABSPATH . 'mp-admin/includes/settings/batches/bounce_handling_II/help.php' );
		return $content;
	}

	public static function settings_batches_update()
	{
		include ( MP_ABSPATH . 'mp-admin/includes/settings/batches/bounce_handling_II/update.php' );
	}

	public static function settings_batches_form()
	{
		include ( MP_ABSPATH . 'mp-admin/includes/settings/batches/bounce_handling_II/form.php' );
	}

// for settings pop3
	public static function settings_connection_pop3_update()
	{
		include ( MP_ABSPATH . 'mp-admin/includes/settings/connection_pop3/bounce_handling_II/form.php' );
	}

// for settings logs	
	public static function settings_logs_form( $logs )
	{
		MP_AdminPage::logs_sub_form( self::log_name, $logs, __( 'Bounce', 'MailPress' ) . ' II' );
	}

	public static function autorefresh_every( $every = 30 )
	{
		$config = get_option( self::option_name );
		if ( !$config ) return $every;
		if ( $every < $config['every'] ) return $every;
		return $config['every'];
	}

	public static function autorefresh_js( $scripts )
	{
		return MP_WP_AutoRefresh_js::register_scripts( $scripts );
	}

// for users list
	public static function get_icon_users( $out, $mp_user )
	{
		if ( 'bounced' == $mp_user->status ) $out .= '<span class="icon bounce_handling" title="' . esc_attr( __( 'Bounced', 'MailPress' ) ) . '"></span>';
		return $out;
	}

// for user page
	public static function meta_boxes_user( $mp_user_id, $screen )
	{
		$usermeta = MP_User_meta::get( $mp_user_id, self::meta_key );
		if ( !$usermeta ) return;

		add_meta_box( 'bouncehandlingdiv', __( 'Bounces', 'MailPress' ), array( __CLASS__, 'meta_box_user' ), $screen, 'side', 'core' );
	}

	public static function meta_box_user( $mp_user )
	{
		$usermeta = MP_User_meta::get( $mp_user->id, self::meta_key );
		if ( !$usermeta ) return;

		global $wpdb;
		echo '<b>' . __( 'Bounces', 'MailPress' ) . '</b> : &#160;' . $usermeta['bounce'] . '<br />';
		foreach( $usermeta['bounces'] as $mail_id => $messages )
		{
			foreach( $messages as $k => $message )
			{
				echo '<br />';
				$subject = $wpdb->get_var( "SELECT subject FROM $wpdb->mp_mails WHERE id = " . $mail_id . ';' );
				$subject = ( $subject ) ? $subject : __( '(deleted)', 'MailPress' );

				$view_url		= esc_url( add_query_arg( array( 'action' => 'mp_ajax', 'mp_action' => 'view_bounce', 'user_id' => $mp_user->id, 'mail_id' => $mail_id, 'id' => $k, 'TB_iframe' => 'true' ), admin_url( 'admin-ajax.php' ) ) );
				$actions['view'] = '<a href="' . $view_url . '" class="thickbox thickbox-preview" title="' . esc_attr( __( 'View', 'MailPress' ) ) . '">' . $subject . '</a>';

				echo '( ' . $mail_id . ' ) ' . $actions['view'];
			}
		}
	}

// for mails list
	public static function mails_columns( $x )
	{
		$date = array_pop( $x );
		$x['bounce_handling']	=  __( 'Bounce rate', 'MailPress' );
		$x['date']			= $date;
		return $x;
	}

	public static function mails_get_row( $out, $column_name, $mail, $url_parms )
	{
		global $wpdb;
		switch ( $column_name )
		{
			case 'bounce_handling' :
				if ( is_email( $mail->toemail ) ) $total = 1;
				elseif( is_serialized( $mail->toemail ) ) $total = count( unserialize( $mail->toemail ) );
				else break;

				$result = MP_Mail_meta::get( $mail->id, self::meta_key );
				if ( $result ) if ( $total > 0 ) $out .= sprintf( "%01.2f %%", 100 * $result/$total );
			break;
		}
		return $out;
	}

// view bounce
	public static function mp_action_view_bounce()
	{
		$mp_user_id = $_GET['user_id'];
		$mail_id    = $_GET['mail_id'];
		$bounce_id  = $_GET['id'];

		$usermeta = MP_User_meta::get( $mp_user_id, self::meta_key );
		if ( !$usermeta ) return;

		$plaintext = $usermeta['bounces'][$mail_id][$bounce_id]['message'];

		include( MP_ABSPATH . 'mp-includes/html/plaintext.php' );
	}
}
new MailPress_bounce_handling_II();
}