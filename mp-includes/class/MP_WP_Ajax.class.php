<?php
class MP_WP_Ajax
{
	function __construct()
	{
/*
		if ( defined( 'MP_DEBUG_LOG' ) && !defined( 'MP_DEBUG_LOG_STOP' ) ) 
		{ 
			global $mp_debug_log; 
			if ( isset( $mp_debug_log ) ) 
			{
				$x = ( !empty( $_GET ) ) ? $_GET : $_POST;
				$mp_debug_log->log( __CLASS__ . " : >> \n" . print_r( $x, true ) . " << \n " ); 
				$mp_debug_log->restart();
			}
		}
*/
		switch ( true )
		{
			case ( isset( $_POST['action'] ) ) :
				$action = $_POST['action'];
			break;
			case ( isset( $_GET['action'] ) ) :
				$action = $_GET['action'];
			break;
			default :
				MP_::mp_die( -1 );
			break;
		}
		$action = str_replace( '-', '_', $action );

		if ( method_exists( $this, $action ) ) call_user_func_array( array( $this, $action ), array() );

		do_action( 'mp_action_' . $action );
                
		die();
	}


////  DELETE  ////

	public static function delete_mail() 
	{
		$id = isset( $_POST['id'] )? ( int ) $_POST['id'] : 0;
		MP_::mp_die( MP_Mail::set_status( $id, 'delete' ) ? 1 : 0 );
	}

	public static function delete_user() 
	{
		$id = isset( $_POST['id'] )? ( int ) $_POST['id'] : 0;
		MP_::mp_die( MP_User::set_status( $id, 'delete' ) ? 1 : 0 );
	}

	public static function delete_mailmeta()
	{
		if ( !current_user_can( 'MailPress_mail_custom_fields' ) )	MP_::mp_die( -1 );

		$id = isset( $_POST['id'] )? ( int ) $_POST['id'] : 0;
		check_ajax_referer( "delete-mailmeta_$id" );

		MP_::mp_die( MP_Mail_meta::delete_by_id( $id ) ? 1 : 0 );
	}

	public static function delete_usermeta()
	{
		if ( !current_user_can( 'MailPress_user_custom_fields' ) )	MP_::mp_die( -1 );

		$id = isset( $_POST['id'] )? ( int ) $_POST['id'] : 0;
		check_ajax_referer( "delete-usermeta_$id" );

		MP_::mp_die( MP_User_meta::delete_by_id( $id ) ? 1 : 0 );
	}

	public static function delete_attachment()
	{
		if ( !isset( $_POST['meta_id'] ) ) return;
		if ( !is_numeric( $_POST['meta_id'] ) ) return;

		$meta_id = ( int ) $_POST['meta_id'];
		MP_Mail_meta::delete_by_id( $meta_id );
		MP_::mp_die( 1 );
	}

//// DIM LIST ////

	public static function dim_mail() 
	{
		require_once( MP_ABSPATH . 'mp-admin/mails.php' );

		$url_parms 	= MP_AdminPage::get_url_parms();

		$id 		= isset( $_POST['id'] ) ? ( int ) $_POST['id'] : 0;
   		$status 	= MP_Mail::get_status( $id );

		$dims = array( 'sent' => 'archived', 'archived' => 'sent' );

		if ( !isset( $dims[$status] ) ) MP_::mp_die();
		if ( !MP_Mail::set_status( $id, $dims[$status] ) ) MP_::mp_die( -1 );
        
		ob_start();
			MP_AdminPage::get_row( $id, $url_parms );
			$html = ob_get_contents();
		ob_end_clean();

		$xml = "<rc><![CDATA[0]]></rc><id><![CDATA[$id]]></id><item><![CDATA[$html]]></item><old_status><![CDATA[$status]]></old_status><new_status><![CDATA[" . $dims[$status] . "]]></new_status>"; 

		ob_end_clean();
		header( 'Content-Type: text/xml' );
		MP_::mp_die( "<?xml version='1.0' standalone='yes'?><mp_action>$xml</mp_action>" );
	}

	public static function dim_user() 
	{
		require_once( MP_ABSPATH . 'mp-admin/users.php' );

		$url_parms 	= MP_AdminPage::get_url_parms();

   		$id = isset( $_POST['id'] )? ( int ) $_POST['id'] : 0;
   		$status = MP_User::get_status( $id );

		$dims = array( 'unsubscribed' => 'waiting', 'waiting' => 'active', 'active' => 'waiting', 'bounced' => 'waiting' );

		if ( !isset( $dims[$status] ) ) MP_::mp_die();
		if ( !MP_User::set_status( $id, $dims[$status] ) ) MP_::mp_die( -1 );
        
		ob_start();
			MP_AdminPage::get_row( $id, $url_parms );
			$html = ob_get_contents();
		ob_end_clean();

		$xml = "<rc><![CDATA[0]]></rc><id><![CDATA[$id]]></id><item><![CDATA[$html]]></item><old_status><![CDATA[$status]]></old_status><new_status><![CDATA[" . $dims[$status] . "]]></new_status>"; 

		ob_end_clean();
		header( 'Content-Type: text/xml' );
		MP_::mp_die( "<?xml version='1.0' standalone='yes'?><mp_action>$xml</mp_action>" );
	}

//// ADD LIST ////

	public static function add_mail() 
	{
		require_once( MP_ABSPATH . 'mp-admin/mails.php' );

		$url_parms = MP_AdminPage::get_url_parms();
		$url_parms['paged'] = isset( $url_parms['paged'] ) ? $url_parms['paged'] : 1;
		$_per_page = MP_AdminPage::get_per_page();
		$start = ( $url_parms['paged'] - 1 ) * $_per_page;

		list( $mails, $total ) = MP_AdminPage::get_list( array( 'start' => $start, '_per_page' => 1, 'url_parms' => $url_parms ) );

		if ( !$mails ) MP_::mp_die( 1 );

		$x = new WP_Ajax_Response();
		foreach ( ( array ) $mails as $mail ) 
		{
			MP_Mail::get( $mail );
			ob_start();
				MP_AdminPage::get_row( $mail->id, $url_parms );
				$html = ob_get_contents();
			ob_end_clean();
			$x->add( array( 
				'what' 	=> 'mail', 
				'id' 		=> $mail->id, 
				'data' 	=> $html
			 ) );
		}
		$x->send();
	}

	public static function add_user() 
	{
		require_once( MP_ABSPATH . 'mp-admin/users.php' );

		$url_parms = MP_AdminPage::get_url_parms();
		$url_parms['paged'] = isset( $url_parms['paged'] ) ? $url_parms['paged'] : 1;
		$_per_page = MP_AdminPage::get_per_page();
		$start = ( $url_parms['paged'] - 1 ) * $_per_page;

		list( $users, $total ) = MP_AdminPage::get_list( array( 'start' => $start, '_per_page' => 1, 'url_parms' => $url_parms ) );

		if ( !$users ) MP_::mp_die( 1 );

		$x = new WP_Ajax_Response();
		foreach ( ( array ) $users as $user ) {
			MP_User::get( $user );
			ob_start();
				MP_AdminPage::get_row( $user->id, $url_parms, false );
				$html = ob_get_contents();
			ob_end_clean();
			$x->add( array( 
				'what' 	=> 'user', 
				'id' 		=> $user->id, 
				'data' 	=> $html
			 ) );
		}
		$x->send();
	}


//// CUSTOM FIELDS ////

	public static function add_mailmeta()
	{
		if ( !current_user_can( 'MailPress_mail_custom_fields' ) )	MP_::mp_die( -1 );

		check_ajax_referer( 'add-mailmeta' );

		$c = 0;
		$object_id = ( int ) $_POST['mail_id'];
		if ( $object_id === 0 ) MP_::mp_die();

		if ( isset( $_POST['metakeyselect'] ) || isset( $_POST['metakeyinput'] ) ) 
		{
			if ( isset( $_POST['metakeyselect'] ) && ( '#NONE#' == $_POST['metakeyselect'] ) && empty( $_POST['metakeyinput'] ) )	MP_::mp_die( 1 );
			if ( !$meta_id = MP_Mail_meta::add_meta( $object_id ) ) 	MP_::mp_die();

			$response = array( 'position' 	=> 1 );
		}
		else
		{
			$meta_id = ( int ) array_pop( array_keys( $_POST['mailmeta'] ) );
			$key     = $_POST['mailmeta'][$meta_id]['key'];
			$value   = $_POST['mailmeta'][$meta_id]['value'];

			if ( !$meta = MP_Mail_meta::get_by_id( $meta_id ) )		MP_::mp_die();
			if ( !MP_Mail_meta::update_by_id( $meta_id , $key, $value ) )	MP_::mp_die( 1 );

			$response = array( 'old_id' 	=> $meta_id, 'position' 	=> 0 );
		}

		$meta = MP_Mail_meta::get_by_id( $meta_id );
		$object_id = ( int ) $meta->mp_mail_id;
		$meta = get_object_vars( $meta );
		require_once( MP_ABSPATH . 'mp-admin/write.php' );

		$response = array_merge( $response, array( 'what' => 'mailmeta', 'id' => $meta_id, 'data' => MP_AdminPage::meta_box_customfield_row( $meta, $c ), 'supplemental' => array( 'mail_id' => $object_id ) ) );

		$x = new WP_Ajax_Response( $response );

		$x->send();
	}

	public static function add_usermeta()
	{
		if ( !current_user_can( 'MailPress_user_custom_fields' ) )	MP_::mp_die( -1 );

		check_ajax_referer( 'add-usermeta' );

		$c = 0;
		$object_id = ( int ) $_POST['mp_user_id'];
		if ( $object_id === 0 ) MP_::mp_die();

		if ( isset( $_POST['metakeyselect'] ) || isset( $_POST['metakeyinput'] ) ) 
		{
			if ( isset( $_POST['metakeyselect'] ) && ( '#NONE#' == $_POST['metakeyselect'] ) && empty( $_POST['metakeyinput'] ) )	MP_::mp_die( 1 );
			if ( !$meta_id = MP_User_meta::add_meta( $object_id ) ) 	MP_::mp_die();

			$response = array( 'position' 	=> 1 );
		}
		else
		{
			$meta_id = ( int ) array_pop( array_keys( $_POST['usermeta'] ) );
			$key     = $_POST['usermeta'][$meta_id]['key'];
			$value   = $_POST['usermeta'][$meta_id]['value'];

			if ( !$meta = MP_User_meta::get_by_id( $meta_id ) )		MP_::mp_die();
			if ( !MP_User_meta::update_by_id( $meta_id , $key, $value ) )	MP_::mp_die( 1 );

			$response = array( 'old_id' 	=> $meta_id, 'position' 	=> 0 );
		}

		$meta = MP_User_meta::get_by_id( $meta_id );
		$object_id = ( int ) $meta->mp_user_id;
		$meta = get_object_vars( $meta );
		require_once( MP_ABSPATH . 'mp-admin/user.php' );

		$response = array_merge( $response, array( 'what' => 'usermeta', 'id' => $meta_id, 'data' => MP_AdminPage::meta_box_customfield_row( $meta, $c ), 'supplemental' => array( 'mp_user_id' => $object_id ) ) );

		$x = new WP_Ajax_Response( $response );

		$x->send();
	}

////  VIEW MAIL/THEME in thickbox  ////

	public static function get_previewlink()
	{
		$args = array( 'id' => 0, 'main_id' => 0, 'action' => 'mp_ajax', 'mp_action' => 'iview', 'TB_iframe' => 'true' );
		$args['id']		= ( isset( $_POST['id'] ) ) ? intval( $_POST['id'] ) : 0;
		$args['main_id']	= ( isset( $_POST['main_id'] ) ) ? intval( $_POST['main_id'] ) : 0;
		$view_url = esc_url( add_query_arg( $args, admin_url( 'admin-ajax.php' ) ) );    

		MP_::mp_die( $view_url );
	}

	public static function iview()
	{
		$mp_general = get_option( MailPress::option_name_general );

		$id 		= $_GET['id'];
		$main_id	= ( isset( $_GET['main_id'] ) ) ? $_GET['main_id'] : $id;

		$mail 	= MP_Mail::get( $id );
                
                if ( !$mail ) return false;

		$theme 	= ( isset( $_GET['theme'] ) && !empty( $_GET['theme'] ) ) ? $_GET['theme'] : ( !empty( $mail->theme ) ? $mail->theme : false );
		$mp_user_id	= ( isset( $_GET['mp_user_id'] )  && !empty( $_GET['mp_user_id'] ) )  ? $_GET['mp_user_id']  : false;

	// from
		$from 	= ( !empty( $mail->fromemail ) ) ? MP_Mail::display_toemail( $mail->fromemail, $mail->fromname ) : MP_Mail::display_toemail( $mp_general['fromemail'], $mp_general['fromname'] );
	// to
		$to 		= MP_Mail::display_toemail( $mail->toemail, $mail->toname, '', $mp_user_id );
	// subject
		$x = new MP_Mail();
		$subject 	= ( in_array( $mail->status, array( 'sent', 'archived' ) ) ) ? $mail->subject : $x->do_eval( $mail->subject );
		$subject 	= $x->viewsubject( $subject, $id, $main_id, $mp_user_id );
	// template
		$template   = ( in_array( $mail->status, array( 'sent', 'archived' ) ) ) ? false : apply_filters( 'MailPress_draft_template', false, $main_id );

	// content
		$args			= array();
		$args['action'] 	= 'mp_ajax';
		$args['mp_action'] 	= 'viewadmin';
		foreach( array( 'id', 'main_id', 'theme', 'template', 'mp_user_id' ) as $x ) if ( $$x ) $args[$x] = $$x;

		foreach( array( 'html', 'plaintext' ) as $type )
		{
			$args['type'] = $type;
			if ( !empty( $mail->{$type} ) ) $$type = '<iframe id="i' . $type . '" style="width:100%;border:0;height:550px" src="' . esc_url( add_query_arg( $args, admin_url( 'admin-ajax.php' ) ) ) . '"></iframe>';
		}

	// attachments
		$attachments = '';
		$metas = MP_Mail_meta::has( $args['main_id'], '_MailPress_attached_file' );
		if ( $metas ) foreach( $metas as $meta ) $attachments .= "<tr><td>&#160;" . MP_Mail::get_attachment_link( $meta, $mail->status ) . "</td></tr>";
		$view = true;
		include( MP_ABSPATH . 'mp-includes/html/mail.php' );
	}

	public static function viewadmin() 
	{
		$_GET['type'] = ( isset( $_GET['type'] ) ) ? $_GET['type'] : 'html';
		$_GET['template'] = apply_filters( 'MailPress_draft_template', isset( $_GET['template'] ) ? $_GET['template'] : false, $_GET['main_id'] );

		$x = new MP_Mail();
		$x->view( $_GET );
	}


////  THEMES  ////

	public static function theme_preview() 
	{
		$args			= array( 'action' => 'mp_ajax', 'mp_action' => 'previewtheme', 'template' => $_GET['template'], 'stylesheet'=> $_GET['stylesheet'] );

		foreach( array( 'html', 'plaintext' ) as $type )
		{
			$args['type'] 	= $type;
			$$type		= '<iframe id="i' . $type . '" style="width:100%;border:0;height:550px" src="' . esc_url( add_query_arg( $args, admin_url( 'admin-ajax.php' ) ) ) . '"></iframe>';
		}

		unset( $view );
		include ( MP_ABSPATH . 'mp-includes/html/mail.php' );
	}

	public static function previewtheme() 
	{
		$url 			= home_url();

		$mail			= new stdClass();
		$mail->Theme 	= $_GET['stylesheet'];
		$mail->Template 	= 'confirmed';

		$message  = __( 'Congratulations !', 'MailPress' );
		$message .= "\n\n";
		$message .= sprintf( __( 'We confirm your subscription to %1$s emails', 'MailPress' ), get_bloginfo( 'name' ) );
		$message .= "\n\n";

		$mail->plaintext 	= $message;

		$message  = __( 'Congratulations !', 'MailPress' );
		$message .= '<br /><br />';
		$message .= sprintf( __( 'We confirm your subscription to %1$s emails', 'MailPress' ), '<a href="' . $url . '">' . get_bloginfo( 'name' ) . '</a>' );
		$message .= '<br /><br />';

		$mail->html 	= $message;

		$mail->unsubscribe= __( '"Subscription management link"', 'MailPress' );
		$mail->viewhtml 	= __( '"Trouble reading link"', 'MailPress' );

		$x = new MP_Mail();
		$x->args = new stdClass();
		$x->args = $mail;

		$type  = $_GET['type'];
		$$type = $x->build_mail_content( $type );
		$$type = ( 'html' == $type ) ? $x->process_img( $$type, $x->mail->themedir, 'draft' ) : $$type;
		include MP_ABSPATH . "mp-includes/html/{$type}.php";
	}


////  WRITE  ////

	public static function html2txt() 
	{
		if ( !isset( $_POST['html'] ) ) return '';
		$content = trim( stripslashes( $_POST['html'] ) );
		if ( empty( $content ) ) return '';
		$content = apply_filters( 'the_content', $content );
       		if ( empty( $content ) ) return '';
                
		$txt = new MP_Html2txt( $content );
		echo $txt->get_text();
		die();
	}

	public static function autosave()
	{
		global $current_user;

		$data = '';
		$supplemental = array();
		$do_lock 	= true;

		$working_id = $main_id 	= ( int ) $_POST['id'];
		$do_autosave= ( bool ) $_POST['autosave'];

		if ( -1 == $_POST['revision'] )
		{
			if ( $do_autosave ) 
			{
				if ( !$working_id ) $working_id = $main_id = MP_Mail::get_id( __CLASS__ . ' 1 ' . __METHOD__ );

				MP_Mail_draft::update( $working_id );
				$data = sprintf( __( 'Draft saved at %s.', 'MailPress' ), date( __( 'g:i:s a' ), current_time( 'timestamp' ) ) );
				$supplemental['tipe'] = 'mail';
			}
		}
		else
		{
			if ( $last = MP_Mail_lock::check( $main_id ) ) 
			{
				$do_autosave 	= $do_lock = false;
				$last_user 		= get_userdata( $last );
				$last_user_name 	= ( $last_user ) ? $last_user->display_name : __( 'Someone' );	
				$data 		= new WP_Error( 'locked', sprintf( __( 'Autosave disabled: %s is currently editing this mail.' ) , esc_html( $last_user_name )	 ) );
				$supplemental['disable_autosave'] = 'disable';
			}

			if ( $do_autosave ) 
			{
				$working_id = ( int ) $_POST['revision'];
				if ( !$working_id )
				{
					$working_id = MP_Mail::get_id( __CLASS__ . ' 2 ' . __METHOD__ );
					MP_Mail_revision::update( $main_id, $working_id, $current_user->ID );
				}

				MP_Mail_draft::update( $working_id, '' );
				$data = sprintf( __( 'Revision saved at %s.', 'MailPress' ), date( __( 'g:i:s a' ), current_time( 'timestamp', true ) ) );
				$supplemental['tipe'] = 'revision';
			}
			else
			{
				if ( $_POST['revision'] ) $working_id = ( int ) $_POST['revision'];
				$supplemental['tipe'] = 'revision';
			}
		}

		if ( $do_lock && $working_id ) MP_Mail_lock::set( $main_id );

		$x = new WP_Ajax_Response( array ( 	'what' 	=> 'autosave', 
								'id' 		=> $working_id, 
								'old_id' 	=> $main_id, 
								'type' 	=> false, 
								'data' 	=> $working_id ? $data : '', 
								'supplemental' => $supplemental
		 ) );

		$x->send();
	}

////  REVISIONS  ////

	function get_revision_diffs() 
	{
		$return = array();
		@set_time_limit( 0 );
  
		foreach ( $_REQUEST['compare'] as $compare_key ) 
		{
			list( $compare_from, $compare_to ) = explode( ':', $compare_key ); // from:to
  
			$return[] = array( 
				'id' => $compare_key,
				'fields' => MP_Mail_revision::get_ui_diff( $_REQUEST['mail_id'], $compare_from, $compare_to ),
			 );
		}
		wp_send_json_success( $return );
	}


////  ATTACHMENTS  UPLOAD  ////

	public static function upload_iframe_html()
	{
		$id 		= $_GET['id'];
		$draft_id 	= $_GET['draft_id'];
		$bytes 	= apply_filters( 'import_upload_size_limit', wp_max_upload_size() );

		wp_register_script( 'upload_iframe', '/' . MP_PATH . 'mp-includes/js/fileupload/upload_iframe.js', array( 'jquery' ), false, 1 );
		wp_localize_script( 'upload_iframe', 'uploadhtmlL10n', array( 
			'id' => $id
		 ) );
		wp_enqueue_script( 'upload_iframe' );

		include MP_ABSPATH . 'mp-includes/html/upload_iframe.php';
	}

	public static function swfu_mail_attachment() 
	{
		// Flash often fails to send cookies with the POST or upload, so we need to pass it in GET or POST instead
		if ( is_ssl() && empty( $_COOKIE[SECURE_AUTH_COOKIE] ) && !empty( $_REQUEST['auth_cookie'] ) )
			$_COOKIE[SECURE_AUTH_COOKIE] = $_REQUEST['auth_cookie'];
		elseif ( empty( $_COOKIE[AUTH_COOKIE] ) && !empty( $_REQUEST['auth_cookie'] ) )
			$_COOKIE[AUTH_COOKIE] = $_REQUEST['auth_cookie'];

		$xml = self::mail_attachment();

		ob_end_clean();
		header( 'Content-Type: text/xml' );
		echo $xml;
		die();
	}

	public static function html_mail_attachment() 
	{
		$draft_id 	= $_REQUEST['draft_id'];
		$id		= $_REQUEST['id'];
		$file		= $_REQUEST['file'];

		$xml = self::mail_attachment();

		$xml = str_replace( '>', '&gt;', $xml );
		$xml = str_replace( '<', '&lt;', $xml );

		wp_register_script( 'upload_iframe_xml', '/' . MP_PATH . 'mp-includes/js/fileupload/upload_iframe_xml.js', array( 'jquery' ), false, 1 );
		wp_localize_script( 'upload_iframe_xml', 'uploadxmlL10n', array( 
			'id'		=> $id,
			'draft_id' 	=> $draft_id,
			'file' 	=> $file
		 ) );
		wp_enqueue_script( 'upload_iframe_xml' );

		ob_end_clean();
		ob_start();
			include MP_ABSPATH . 'mp-includes/html/upload_iframe_xml.php';
			$html = ob_get_contents();
		ob_end_clean();

		MP_::mp_die( $html );
	}

	public static function mail_attachment()
	{
		$data = self::handle_upload( 'async-upload', $_REQUEST['draft_id'] );

		if ( is_wp_error( $data ) ) 
		{
			$xml  = "<error><![CDATA[" . $data->get_error_message() . "]]></error>";
		}
		else
		{
			$xml  = "<id><![CDATA[" . $data['id'] . "]]></id>";
			$xml .= "<url><![CDATA[" . $data['url'] . "]]></url>";
			$xml .= "<file><![CDATA[" . $data['file'] . "]]></file>";
		}

		return "<?xml version='1.0' standalone='yes'?><mp_fileupload>$xml</mp_fileupload>";
	}

	public static function handle_upload( $file_id, $draft_id ) 
	{
		$overrides = array( 'test_form'=>false, 'unique_filename_callback' => 'mp_unique_filename_callback' );
		$time = current_time( 'mysql' );

		$uploaded_file = wp_handle_upload( $_FILES[$file_id], $overrides, $time );

		if ( isset( $uploaded_file['error'] ) )
			return new WP_Error( 'upload_error', $uploaded_file['error'] );

// Check file path is ok
		$uploads = wp_upload_dir();
		if ( $uploads && ( false === $uploads['error'] ) ) 							// Get upload directory
		{ 	
			if ( 0 === strpos( $uploaded_file['file'], $uploads['basedir'] ) ) 				// Check that the upload base exists in the file path
			{
				$file = str_replace( $uploads['basedir'], '', $uploaded_file['file'] ); 		// Remove upload dir from the file path
				$file = ltrim( $file, '/' );
			}
		}

// Construct the attachment array
		$object = array( 
					'name' 	=> $_FILES['async-upload']['name'], 
					'mime_type'	=> $uploaded_file['type'], 
					'file'	=> $file, 
					'file_fullpath'	=> str_replace( "\\", "/", $uploaded_file['file'] ), 
					'guid' 	=> $uploaded_file['url']
				 );
// Save the data
		$id = MP_Mail_meta::add( $draft_id, '_MailPress_attached_file', $object );

		$href = esc_url( add_query_arg( array( 'action' => 'mp_ajax', 'mp_action' => 'attach_download', 'id' => $id ), admin_url( 'admin-ajax.php' ) ) );
		return array( 'id' => $id, 'url' => $href, 'file' => $object['file_fullpath'] );
	}


	public static function attach_download()
	{
		$meta_id 	= ( int ) $_GET['id'];

		$meta = MP_Mail_meta::get_by_id( $meta_id );

		if ( !$meta ) MP_::mp_die( __( 'Cannot Open Attachment 1!', 'MailPress' ) );
		if ( !is_file( $meta->meta_value['file_fullpath'] ) )	MP_::mp_die( __( 'Cannot Open Attachment 2! ' . $meta->meta_value['file_fullpath'], 'MailPress' ) );

		self::download( $meta->meta_value['name'], $meta->meta_value['file_fullpath'], $meta->meta_value['mime_type'] );
	}


////  MISC  ////

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

	public static function map_settings()
	{
		if ( 'mp_user' == $_POST['type'] )
		{
			if ( !MP_User_meta::add(     $_POST['id'], '_MailPress_' . $_POST['prefix'], $_POST['settings'], true ) )
				MP_User_meta::update( $_POST['id'], '_MailPress_' . $_POST['prefix'], $_POST['settings'] );
		}
		else
		{
			if ( !MP_Mail_meta::add(     $_POST['id'], '_MailPress_' . $_POST['prefix'], $_POST['settings'], true ) )
				MP_Mail_meta::update( $_POST['id'], '_MailPress_' . $_POST['prefix'], $_POST['settings'] );
		}
		MP_::mp_die();

		update_user_meta( MP_WP_User::get_id(), '_MailPress_' . $_POST['prefix'], $_POST['settings'] );
		MP_::mp_die();
	}
}