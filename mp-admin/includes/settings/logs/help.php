<?php // logs

$content .= '<table>';

$content .= '<tr><th>';
$content .= __( 'Logs', 'MailPress' );
$content .= '</th><td>';
$content .= '</td></tr>';

$content .= '<tr><td>';
$content .= '</td><td>';
$content .= __( 'Some basic settings to manage the MailPress logs.', 'MailPress' );
$content .= '<br />';
$content .= __( 'Some MailPress add-ons have their own logs (batch, bounce, newsletter ...).', 'MailPress' );
$content .= '<br />';
$content .= __( 'All log files are stored in <code>mailpress/tmp</code> folder.', 'MailPress' );
$content .= '<br />';
if (MP_addons::is_active('MailPress_view_logs'))
{
$content .= sprintf( __('Also available on %1$s.', 'MailPress'), sprintf( '<a href="%1$s" target="_blank">%2$s</a>', MailPress_view_logs, __( 'MailPress Logs admin screen', 'MailPress' ) ) );
}
else
{
$content .= sprintf( __('Activate add-on %1$s, so logs can be seen in a new admin screen.', 'MailPress'), sprintf( '<a href="%1$s" target="_blank">%2$s</a>', MailPress_addons . '#MailPress_view_logs' , __( 'View_logs', 'MailPress' ) ) );
}
$content .= '</td></tr>';

$content .= '</table>';


$content .= '<hr />';
$content .= sprintf( __('More about %s', 'MailPress'), sprintf( '<a href="%1$s" target="_blank">%2$s</a>', __( 'http://php.net/manual/en/errorfunc.constants.php', 'MailPress' ), __( 'Error Levels', 'MailPress' ) ) );
