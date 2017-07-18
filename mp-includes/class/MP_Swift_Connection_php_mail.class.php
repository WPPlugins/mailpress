<?php
class MP_Swift_Connection_php_mail extends MP_Swift_connection_
{
	public $Swift_Connection_type = 'PHP_MAIL';

	function connect( $mail_id, $y )
	{
		$settings = get_option( MailPress_connection_php_mail::option_name );

		$addparm = $settings['addparm'];

		$conn = ( empty( $addparm ) ) ? Swift_MailTransport::newInstance() : Swift_MailTransport::newInstance( $addparm );

		return $conn;
	}
}