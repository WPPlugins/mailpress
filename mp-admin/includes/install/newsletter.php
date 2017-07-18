<?php

/* Newsletter install */

global $wpdb, $mp_general;

$mp_general = get_option( MailPress::option_name_general );

//////////////////////////////////
//// Install                  ////
//////////////////////////////////

//	To avoid mailing existing published post
$post_meta = '_MailPress_prior_to_install';
$ids = $wpdb->get_results( "SELECT ID FROM $wpdb->posts WHERE post_status = 'publish' ;" );
if ( $ids )
{
	foreach ( $ids as $id )
	{
		if ( !get_post_meta( $id->ID, $post_meta, true ) )
		{
			add_post_meta( $id->ID, $post_meta, 'yes', true );
		}
	}
}

