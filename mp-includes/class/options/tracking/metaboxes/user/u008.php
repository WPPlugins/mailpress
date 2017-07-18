<?php
class MP_Tracking_metabox_u008 extends MP_tracking_metabox_
{
	var $id	= 'u008';
	var $context= 'side';
	var $file 	= __FILE__;

	function __construct( $title )
	{
		add_filter( 'MailPress_scripts', array( $this, 'scripts' ), 8, 2 );
		add_filter( 'MailPress_styles',  array( $this, 'styles' ),  8, 2 );
		parent::__construct( $title );
	}

	function styles( $styles ) 
	{
		$styles[] = 'thickbox';
		return $styles;
	}

	function scripts( $scripts )
	{
		wp_register_script( 'mp-thickbox', 		'/' . MP_PATH . 'mp-includes/js/mp_thickbox.js', array( 'thickbox' ), false, 1 );
		$scripts[] = 'mp-thickbox';
		return $scripts;
	}

	function meta_box( $mp_user )
	{
		global $wpdb;
		$x = new MP_Mail();

		$tracks = $wpdb->get_results( $wpdb->prepare( "SELECT mail_id, count( * ) as count FROM $wpdb->mp_tracks WHERE user_id = %d AND track <> '_MailPress_mail_opened' AND mail_id <> 0 GROUP BY 1 ORDER BY 2 DESC, 1 DESC LIMIT 10;", $mp_user->id ) );
		if ( $tracks ) foreach( $tracks as $track )
		{
			$args = array( 'id' => $track->mail_id, 'mp_user_id' => $mp_user->id, 'key' => $mp_user->confkey , 'action' => 'mp_ajax', 'mp_action' => 'iview', 'TB_iframe' => 'true' );
			$view_url = esc_url( add_query_arg( $args, admin_url( 'admin-ajax.php' ) ) );    

  			$subject    = $wpdb->get_var( $wpdb->prepare( "SELECT subject FROM $wpdb->mp_mails WHERE id = %d ;", $track->mail_id ) );
			if ( $subject )
			{
				$subject 	= $x->viewsubject( $subject, $track->mail_id, $track->mail_id, $mp_user->id );
				echo '( ' . $track->count . ' ) <a href="' . $view_url . '" class="thickbox thickbox-preview" title="' . esc_attr( sprintf( __( 'View &#8220;%1$s&#8221;', 'MailPress' ) , ( $subject ) ? $subject : $track->mail_id ) ) . '">' . ( ( $subject ) ? $subject : $track->mail_id ) . '</a> <br />';
			}
			else
			{
				echo "( {$track->count} )  {$track->mail_id} <br />";
			}
		}
	}
}
new MP_Tracking_metabox_u008( __( 'Most clicked', 'MailPress' ) );