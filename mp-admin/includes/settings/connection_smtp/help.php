<?php // connection_smtp

$content .= '<table>';
// SMTP

$content .= '<tr><th>';
$content .= sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://en.wikipedia.org/wiki/Simple_Mail_Transfer_Protocol', 'SMTP' );
$content .= '</th><td>';

$content .= '</td></tr>';

// SMTP Server
$content .= '<tr><th><span>';
$content .= __( 'Server', 'MailPress' );
$content .= '</span></th><td>';
$content .= __( 'Your SMTP server (e.g. <code>smtp.gmail.com</code>).', 'MailPress' );
$content .= '</td></tr>';

// Username/Password
$content .= '<tr><th><span>';
$content .= __( 'Authentication', 'MailPress' );
$content .= '</span></th><td>';
$content .= __( 'Some servers require authentication. Provide username and password if necessary.', 'MailPress' );
$content .= '</td></tr>';

// Encryption
$content .= '<tr><th><span>';
$content .= __( 'Encryption', 'MailPress' );
$content .= '</span></th><td>';
$content .= __( 'You can use SSL or TLS encryption if required by your SMTP server.', 'MailPress' );
$content .= '</td></tr>';

// Port
$content .= '<tr><th><span>';
$content .= __( 'Port', 'MailPress' );
$content .= '</span></th><td>';
$content .= __( 'port number (default 25, Gmail 465, other ...).', 'MailPress' );
$content .= '</td></tr>';

// Pop before Smtp
$content .= '<tr><th><span>';
$content .= __( 'Pop before Smtp', 'MailPress' );
$content .= '</span></th><td>';
$content .= sprintf( __( '(optional) Some SMTP servers are adding this %s.', 'MailPress' ), sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://en.wikipedia.org/wiki/POP_before_SMTP', __( ' authorization method', 'MailPress' ) ) );
$content .= '</td></tr>';

$content .= '<tr><td colspan="2">';
$content .= '<hr />';
$content .= '</td></tr>';

// go to test
$content .= '<tr><th>';
$content .= __( 'Test', 'MailPress' );
$content .= '</th><td>';
$content .= __( 'Once saved, try your settings using the Test tab', 'MailPress' );
$content .= '</td></tr>';

$content .= '<tr><td colspan="2">';
$content .= '<hr />';
$content .= '</td></tr>';
$content .= '</table>';


$content .= '<p>';
$content .= sprintf( __( 'More about %1$s and Swiftmailer (php class used by MailPress) %2$s.', 'MailPress' ), 'SMTP', sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'http://swiftmailer.org/docs/sending.html#the-smtp-transport', __( 'here', 'MailPress' ) ) );
$content .= '</p>';

// other protocols
$content .= '<p>';
$content .= sprintf( __('MailPress supports two other protocols : %1$s and %2$s.', 'MailPress'), sprintf( '<a href="%1$s" target="_blank">%2$s</a>', MailPress_addons . '#MailPress_connection_sendmail', 'SENDMAIL' ),  sprintf( '<a href="%1$s" target="_blank">%2$s</a>', MailPress_addons . '#MailPress_connection_php_mail', 'PHP_MAIL' ) );
$content .= '</p>';

