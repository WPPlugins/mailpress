<?php

/* Capabilities */

$capabilities	= array( 	
	'MailPress_edit_dashboard'		=> 	array( 	'name'	=> __( 'Dashboard', 'MailPress' ),
										'group'	=> 'admin'
							 	),

	'MailPress_manage_options'		=> 	array( 	'name'	=> __( 'Settings', 'MailPress' ),
										'group'	=> 'admin',
										'menu'	=> 99,

										'parent'	=> 'options-general.php',
										'page_title'=> __( 'MailPress Settings', 'MailPress' ),
										'menu_title'=> 'MailPress',
										'page'	=> MailPress_page_settings,
										'func'	=> array( 'MP_AdminPage', 'body' )
								),

	'MailPress_edit_mails'		=> 	array( 	'name'	=> __( 'Mails', 'MailPress' ),
										'group'	=> 'mails',
										'menu'	=> 1,
										'admin_bar'	=> __( 'Mails', 'MailPress' ),

										'parent'	=> false,
										'page_title'=> __( 'Mails', 'MailPress' ),
										'menu_title'=> __( 'All Mails', 'MailPress' ),
										'page'	=> MailPress_page_mails,
										'func'	=> array( 'MP_AdminPage', 'body' )
								),

	'MailPress_edit_others_mails'	=> 	array( 	'name'	=> __( 'Edit others mails', 'MailPress' ),
										'group'	=> 'mails'
								),

	'MailPress_send_mails'		=> 	array( 	'name'	=> __( 'Send mails', 'MailPress' ),
										'group'	=> 'mails'
								),

	'MailPress_delete_mails'		=> 	array( 	'name'	=> __( 'Delete mails', 'MailPress' ),
										'group'	=> 'mails'
								),

	'MailPress_archive_mails'		=> 	array( 	'name'  	=> __( 'Archive mails', 'MailPress' ), 
										'group'	=> 'mails'
								),

	'MailPress_mail_custom_fields'	=> 	array( 	'name'	=> __( 'Custom fields', 'MailPress' ), 
										'group'	=> 'mails'
								),

	'MailPress_switch_themes'		=> 	array( 	'name'	=> __( 'Themes', 'MailPress' ),
										'group'	=> 'admin',
										'menu'	=> 45,

										'parent'	=> false,
										'page_title'=> __( 'MailPress Themes', 'MailPress' ),
										'menu_title'=> '&#160;' . __( 'Themes', 'MailPress' ),
										'page'	=> MailPress_page_themes,
										'func'	=> array( 'MP_AdminPage', 'body' )
								),

	'MailPress_edit_users'		=> 	array( 	'name'	=> __( 'Edit users', 'MailPress' ),
										'group'	=> 'users',
										'menu'	=> 50,
										'admin_bar'	=> __( 'Users', 'MailPress' ),

										'parent'	=> false,
										'page_title'=> __( 'MailPress Users', 'MailPress' ),
										'menu_title'=> __( 'All Users', 'MailPress' ),
										'page'	=> MailPress_page_users,
										'func'	=> array( 'MP_AdminPage', 'body' )
								),

	'MailPress_delete_users'		=> 	array(	'name'	=> __( 'Delete users', 'MailPress' ),
										'group'	=> 'users'
								),

	'MailPress_user_custom_fields'	=> 	array(	'name'	=> __( 'Custom fields', 'MailPress' ), 
										'group'	=> 'users'
								),

	'MailPress_manage_addons'		=> 	array( 	'name'	=> __( 'Add-ons', 'MailPress' ),
										'group'	=> 'admin',
										'menu'	=> 99,

										'parent'	=> 'plugins.php',
										'page_title'=> __( 'MailPress Add-ons', 'MailPress' ),
										'menu_title'=> __( 'MailPress Add-ons', 'MailPress' ),
										'page'	=> MailPress_page_addons,
										'func'	=> array( 'MP_AdminPage', 'body' )
								)
 );