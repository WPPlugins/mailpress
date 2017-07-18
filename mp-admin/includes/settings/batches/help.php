<?php // batches

$content .= '<table>';
$content .= '<tr><th>';
$content .= __( 'Batches', 'MailPress' );
$content .= '</th><td>';
$content .= '</td></tr>';
$content .= '<tr><td colspan="2">';
$content .= __( 'Depending on which Add-ons you have activated, you will have to set specific settings for each type of batch.', 'MailPress' );
$content .= '</td></tr>';
$content .= '</table>';

$content .= '<hr />';

$content = apply_filters( 'MailPress_settings_batches_help', $content );

$content .= '<hr />';

$content .= '<table>';

// 
$content .= '<tr><td colspan="2">';

$content .= __( 'But for every batch, you will have to set how they are scheduled.', 'MailPress' );
$content .= '</td></tr>';

// Submit batch with
$content .= '<tr><th><span>';
$content .= __( 'Submit with', 'MailPress' );
$content .= '</span></th><td>';
$content .= '<ul>';
$content .= '<li>' . __('Wp_cron, select frequency.', 'MailPress') . '</li>';
$content .= '<li>' . __('Other, follow guidelines.', 'MailPress') . '</li>';
$content .= '</ul>';
$content .= '</td></tr>';

$content .= '</table>';
