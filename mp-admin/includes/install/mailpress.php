<?php

/* MailPress install */

global $wpdb, $wp_version;

$m = array();

if ( version_compare( $wp_version, $min_ver_wp , '<' ) )	$m[] = sprintf( __( 'Your %1$s version is \'%2$s\', at least version \'%3$s\' required.', 'MailPress' ), __( 'WordPress' ), $wp_version , $min_ver_wp );
if ( !is_writable( MP_ABSPATH . 'tmp' ) )				$m[] = sprintf( __( 'The directory \'%1$s\' is not writable.', 'MailPress' ), MP_ABSPATH . 'tmp' );
if ( !extension_loaded( 'simplexml' ) )				$m[] = __( "Default php extension 'simplexml' not loaded.", 'MailPress' );

if ( !empty( $m ) )
{
	$err  = sprintf( __( '<b>Sorry, but you can\'t run this plugin : %1$s. </b>', 'MailPress' ), $_GET['plugin'] );
	$err .= '<ol><li>' . implode( '</li><li>', $m ) . '</li></ol>';

	if ( isset( $_GET['plugin'] ) ) deactivate_plugins( $_GET['plugin'] );	
	trigger_error( $err, E_USER_ERROR );
	return false;
}

//////////////////////////////////
//// Install                  ////
//////////////////////////////////

// theme init
if ( !get_option( 'MailPress_current_theme' ) )
{
	add_option ( 'MailPress_template',	'twentyten' );
	add_option ( 'MailPress_stylesheet',	'twentyten' );
	add_option ( 'MailPress_current_theme',	'MailPress Twenty Ten' );
}

$charset_collate = $wpdb->get_charset_collate();

$queries = array();

$queries[] = 
"CREATE TABLE $wpdb->mp_mails ( 
 id                bigint( 20 )       UNSIGNED NOT NULL AUTO_INCREMENT,
 status            enum( 'draft', 'unsent', 'sending', 'sent', 'archived', '', 'paused' ) NOT NULL,
 theme             varchar( 255 )     NOT NULL default '',
 themedir          varchar( 255 )     NOT NULL default '',
 template          varchar( 255 )     NOT NULL default '',
 fromemail         varchar( 255 )     NOT NULL default '',
 fromname          varchar( 255 )     NOT NULL default '',
 toname            varchar( 255 )     NOT NULL default '',
 charset           varchar( 255 )     NOT NULL default '',
 parent            bigint( 20 )       UNSIGNED NOT NULL default 0,
 child             bigint( 20 )       NOT NULL default 0,
 subject           varchar( 255 )     NOT NULL default '',
 created           timestamp        NOT NULL default '0000-00-00 00:00:00',
 created_user_id   bigint( 20 )       UNSIGNED NOT NULL default 0,
 sent              timestamp        NOT NULL default '0000-00-00 00:00:00',
 sent_user_id      bigint( 20 )       UNSIGNED NOT NULL default 0,
 toemail           longtext         NOT NULL,
 plaintext         longtext         NOT NULL,
 html              longtext         NOT NULL,
PRIMARY KEY ( id ),
KEY status ( status )
 ) $charset_collate;";

$queries[] = 
"CREATE TABLE $wpdb->mp_mailmeta ( 
 meta_id           bigint( 20 )       NOT NULL auto_increment,
 mp_mail_id        bigint( 20 )       NOT NULL default '0',
 meta_key          varchar( 255 )     default NULL,
 meta_value        longtext,
 PRIMARY KEY ( meta_id ),
 KEY mp_mail_id ( mp_mail_id,meta_key )
 ) $charset_collate;";

$queries[] = 
"CREATE TABLE $wpdb->mp_users ( 
 id                bigint( 20 )       UNSIGNED NOT NULL AUTO_INCREMENT, 
 email             varchar( 100 )     NOT NULL,
 name              varchar( 100 )     NOT NULL,
 status            enum( 'waiting', 'active', 'bounced', 'unsubscribed' )	NOT NULL,
 confkey           varchar( 100 )     NOT NULL,
 created           timestamp        NOT NULL default '0000-00-00 00:00:00',
 created_IP        varchar( 100 )     NOT NULL default '',
 created_agent     text             NOT NULL,
 created_user_id   bigint( 20 )       UNSIGNED NOT NULL default 0,
 created_country   char( 2 )          NOT NULL default 'ZZ',
 created_US_state  char( 2 )          NOT NULL default 'ZZ',
 laststatus        timestamp        NOT NULL default '0000-00-00 00:00:00',
 laststatus_IP     varchar( 100 )     NOT NULL default '',
 laststatus_agent  text             NOT NULL,
 laststatus_user_id bigint( 20 )      UNSIGNED NOT NULL default 0,
 PRIMARY KEY ( id ),
 KEY status ( status )
 ) $charset_collate;";

$queries[] = 
"CREATE TABLE $wpdb->mp_usermeta ( 
 meta_id           bigint( 20 )       NOT NULL auto_increment,
 mp_user_id        bigint( 20 )       NOT NULL default '0',
 meta_key          varchar( 255 )     default NULL,
 meta_value        longtext,
 PRIMARY KEY ( meta_id ),
 KEY mp_user_id ( mp_user_id, meta_key )
 ) $charset_collate;";

$queries[] = 
"CREATE TABLE $wpdb->mp_stats ( 
 sdate   date NOT NULL,
 stype   char( 1 ) NOT NULL,
 slib    varchar( 45 ) NOT NULL,
 scount  bigint NOT NULL,
 PRIMARY KEY ( stype, sdate, slib )
 ) $charset_collate;";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $queries );

// some clean up
$wpdb->query( "DELETE FROM $wpdb->mp_mails    WHERE status = '' AND theme <> '';" );
$wpdb->query( "DELETE FROM $wpdb->mp_mailmeta WHERE mp_mail_id NOT IN ( SELECT id FROM $wpdb->mp_mails );" );
$wpdb->query( "DELETE FROM $wpdb->mp_usermeta WHERE mp_user_id NOT IN ( SELECT id FROM $wpdb->mp_users );" );
$wpdb->query( "DELETE FROM $wpdb->mp_usermeta WHERE meta_value NOT IN ( SELECT id FROM $wpdb->mp_mails ) AND meta_key = '_MailPress_mail_sent' ;" );

$wpdb->query( "UPDATE $wpdb->mp_mailmeta SET meta_key = '_MailPress_attached_file' WHERE meta_key = '_mp_attached_file';" );