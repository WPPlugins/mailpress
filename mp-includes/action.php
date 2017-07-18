<?php
$ssl      = ( ! empty( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] == 'on' );
$sp       = strtolower( $_SERVER['SERVER_PROTOCOL'] );

$protocol = substr( $sp, 0, strpos( $sp, '/' ) ) . ( ( $ssl ) ? 's' : '' );

$port     = $_SERVER['SERVER_PORT'];
$port     = ( ( ! $ssl && $port == '80' ) || ( $ssl && $port == '443' ) ) ? '' : ':'.$port;

$url = str_replace ( 'wp-content/plugins/mailpress/mp-includes/action.php', 'wp-admin/admin-ajax.php', $protocol . '://' . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'] );

$url = str_replace ( "tg=", "action=mp_tracking&tg=", $url );

header( 'Location: '.$url );