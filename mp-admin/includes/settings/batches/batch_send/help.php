<?php // batch_send

$content .= '<table>';

$content .= '<tr><th>';
$content .= __( 'Sending Mails', 'MailPress' );
$content .= '</th><td>';
$content .= __('to send your mailings in the background by several batches.', 'MailPress' );
$content .= '</td></tr>';

// Max mails sent per batch
$content .= '<tr><th><span>';
$content .= __( 'Max mails...', 'MailPress' );
$content .= '</span></th><td>';
$content .= __( 'For each batch, MailPress will try to send a specific mail for each x recipient(s).', 'MailPress' );
$content .= '</td></tr>';

// Max retries
$content .= '<tr><th><span>';
$content .= __( 'Max retries', 'MailPress' );
$content .= '</span></th><td>';
$content .= __( 'Once all recipients have been processed, retry to send x times if some failures (1 recommended).', 'MailPress' );
$content .= '</td></tr>';

$content .= '</table>';