<?php // connection_php_mail

$content .= '<table>';
// PHP_MAIL

$content .= '<tr><th>';
$content .= sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'http://php.net/manual/en/function.mail.php', __( 'PHP_MAIL', 'MailPress' ) );
$content .= '</th><td></td></tr>';

// 5th parameter
$content .= '<tr><th><span>';
$content .= __( '5th parm', 'MailPress' );
$content .= '</span></th><td>';
$content .= sprintf( __( '(optional) Specify here the 5th parameter of php %s function', 'MailPress' ), sprintf( '<a href="%1$s" target="_blank">%2$s</a>', __( 'http://fr.php.net/manual/en/function.mail.php', 'MailPress' ), __( 'mail()', 'MailPress' ) ) );
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

// php_mail
$content .= '<p>';
$content .= sprintf( __( 'More about %1$s and Swiftmailer (php class used by MailPress) %2$s.', 'MailPress' ), 'PHP_MAIL', sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'http://swiftmailer.org/docs/sending.html#the-mail-transport', __( 'here', 'MailPress' ) ) );
$content .= '</p>';

// other protocols
$content .= '<p>';
$content .= sprintf( __('MailPress supports two other protocols : %1$s and SMTP (deactivate add-on : %2$s)', 'MailPress'), sprintf( '<a href="%1$s" target="_blank">%2$s</a>', MailPress_addons . '#MailPress_connection_sendmail' , 'SENDMAIL' ),  sprintf( '<a href="%1$s" target="_blank">%2$s</a>', MailPress_addons . '#MailPress_connection_php_mail', 'PHP_MAIL' ) );
$content .= '</p>';
