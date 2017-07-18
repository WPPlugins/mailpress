<?php // delete_old_mails

$content .= '<hr />';

$content .= '<table>';

$content .= '<tr><th>';
$content .= __( 'Deleting Old Mails', 'MailPress' );
$content .= '</th><td>';
$content .= __('to do some clean up !', 'MailPress' );
$content .= '</td></tr>';

// Return-Path
$content .= '<tr><th><span>';
$content .= __( 'Keep sent...', 'MailPress' );
$content .= '</span></th><td>';
$content .= __( 'All other sent mails will be deleted, archived mails will be kept.', 'MailPress' );
$content .= '</td></tr>';

$content .= '</table>';