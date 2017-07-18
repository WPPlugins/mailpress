<?php // mailinglist

if ( isset( $_POST['default_mailinglist'] ) )
{
	update_option ( self::option_name_default, $_POST['default_mailinglist'] );
}



