<?php

/* Form install */

global $wpdb;

//////////////////////////////////
//// Install                  ////
//////////////////////////////////

$charset_collate = $wpdb->get_charset_collate();

$queries = array();

$queries[] =
"CREATE TABLE $wpdb->mp_forms ( 
 id                bigint( 20 )      NOT NULL auto_increment,
 label             varchar( 255 )    NOT NULL default '',
 description       varchar( 255 )    NOT NULL default '',
 template          varchar( 50 )     NOT NULL default '',
 settings          longtext,
 PRIMARY KEY ( id ),
 UNIQUE KEY id ( id )
 ) $charset_collate;";

$queries[] =
"CREATE TABLE $wpdb->mp_fields ( 
 id                bigint( 20 )      NOT NULL auto_increment,
 form_id           bigint( 20 )      NOT NULL,
 ordre             bigint( 20 )      UNSIGNED NOT NULL default 0,
 type              varchar( 50 )     NOT NULL default '',
 template          varchar( 50 )     NOT NULL default '',
 label             varchar( 255 )    NOT NULL default '',
 description       varchar( 255 )    NOT NULL default '',
 settings          longtext,
 PRIMARY KEY ( id ),
 UNIQUE KEY id ( id )
 ) $charset_collate;";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $queries );
