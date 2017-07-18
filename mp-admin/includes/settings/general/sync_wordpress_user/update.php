<?php //sync_wordpress_user

if ( isset( $_POST['sync_wordpress_user'] ) )
{
	update_option( MailPress_sync_wordpress_user::option_name, $_POST['sync_wordpress_user'] );
}
