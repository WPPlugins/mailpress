<?php // newsletter

// Newsletters

$content .= '<tr><th>';
$content .= __( 'Newsletters', 'MailPress' );
$content .= '</th><td>';
$content .= sprintf( __( 'Make sure you have previously defined the newsletters in the %s tab.', 'MailPress' ), sprintf( '<a href="%1$s" target="_blank">%2$s</a>', MailPress_settings . '&tab=subscriptions', __('Subscriptions', 'MailPress' ) ) ) ;
$content .= '</td></tr>';

$content .= '<tr><th><span>';
$content .= __( 'Show at most', 'MailPress' );
$content .= '</span></th><td>';
$content .= __( 'Select the maximum number of posts to send in a newsletter.', 'MailPress' );
$content .= '</td></tr>';
