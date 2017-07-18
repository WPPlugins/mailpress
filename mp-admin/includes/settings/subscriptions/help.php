<?php // subscriptions

$content .= '<table>';
$content .= '<tr><th>';
$content .= __( 'Subscriptions', 'MailPress' );
$content .= '</th><td>';
$content .= '</td></tr>';
$content .= '<tr><td colspan="2">';
$content .= __( 'Depending on which Add-ons you have activated, you will have to set specific settings for each type of subscriptions.', 'MailPress' );
$content .= '</td></tr>';
$content .= '</table>';

$content .= '<hr />';

$content = apply_filters( 'MailPress_settings_subscriptions_help', $content );