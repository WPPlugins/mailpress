<?php // newsletter

$content .= '<table>';

$content .= '<tr><th>';
$content .= __( 'Newsletters', 'MailPress' );
$content .= '</th><td>';
$content .= __( 'to send a mailing for each mailpress user subscribed to a newsletter released on an event (new post) or on a specific frequency.', 'MailPress' );
$content .= '</td></tr>';

// Checked by default
$content .= '<tr><th><span>';
$content .= '</span></th><td>';
$content .= __( 'Select the newsletter(s) opened for public subscription.', 'MailPress' );
$content .= '<br />';
$content .= __( 'Select the default newsletter(s) for each new mailpress user.', 'MailPress' );
$content .= '</td></tr>';

$content .= '</table>';

$content .= '<hr />';