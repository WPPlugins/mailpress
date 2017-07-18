<?php // roles_and_capabilities

if ( isset( $_POST['cap'] ) )
{
	global $wp_roles;
	foreach( $wp_roles->role_names as $role => $name )
	{
		if ( 'administrator' == $role ) continue;
        
		if ( !isset( $_POST['cap'][$role] ) ) $_POST['cap'][$role] = array();
        
		update_option( 'MailPress_r&c_' . $role, $_POST['cap'][$role] );    
	}

	$message = __( "'Roles and capabilities' settings saved", 'MailPress' );
}