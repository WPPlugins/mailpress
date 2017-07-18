<?php // connection_sendmail

$content .= '<table>';
// sendmail

$content .= '<tr><th>';
$content .= sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://en.wikipedia.org/wiki/Sendmail', __( 'SendMail', 'MailPress' ) );
$content .= '</th><td></td></tr>';

// Connect
$content .= '<tr><th><span>';
$content .= __( 'Connect', 'MailPress' );
$content .= '</span></th><td>';
$content .= sprintf( __( 'More about %1$s and Swiftmailer (php class used by MailPress) %2$s.', 'MailPress' ), 'SENDMAIL', sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'http://swiftmailer.org/docs/sending.html#the-sendmail-transport', __( 'here', 'MailPress' ) ) );
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

// other protocols
$content .= '<p>';
$content .= sprintf( __('MailPress supports two other protocols : %1$s and SMTP (deactivate add-on : %2$s)', 'MailPress'), sprintf( '<a href="%1$s" target="_blank">%2$s</a>', MailPress_addons . '#MailPress_connection_php_mail', 'PHP_MAIL' ), sprintf( '<a href="%1$s" target="_blank">%2$s</a>', MailPress_addons . '#MailPress_connection_sendmail', 'SENDMAIL' ) );
$content .= '</p>';
