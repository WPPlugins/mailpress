<?php // filter_img


$content .= '<table>';

$content .= '<tr><th>';
$content .= __( 'Image filter', 'MailPress' );
$content .= '</th><td>';
$content .= __( 'All mail accounts (gmail, yahoo, ...) have their own way to process css declarations.', 'MailPress' );
$content .= ' ';
$content .= __( 'These settings allow you to minimise potential loss and to keep a good presentation for your mails.', 'MailPress' );
$content .= '</td></tr>';

$content .= '<tr><th><span>';
$content .= '&nbsp;';
$content .= '</span></th><td>';
$content .= '&nbsp;';
$content .= '</td></tr>';

// <img defaults>
$content .= '<tr><th><span>';
$content .= __( 'Default', 'MailPress' );
$content .= '</span></th><td>';
$content .= __( 'Select the default alignment for your pictures.', 'MailPress' );
$content .= '</td></tr>';

$content .= '<tr><th><span>';
$content .= '&nbsp;';
$content .= '</span></th><td>';
$content .= __( 'Add some default css declarations.', 'MailPress' );
$content .= '</td></tr>';

// Enter ... & Result
$content .= '<tr><th><span>';
$content .= __( 'Enter & Result', 'MailPress' );
$content .= '</span></th><td>';
$content .= __( 'The purpose of the two following fields is to show you how MailPress will modify the <code>img</code> tag in the mail with your settings.', 'MailPress' );
$content .= '<br />';
$content .= __( 'Just type <code>&lt;img /&gt;</code> and save to see the filter result.', 'MailPress' );
$content .= '<br />';
$content .= __( 'Then type <code>&lt;img class="myclass" style="float:normal;" /&gt;</code> and save to see the filter result.', 'MailPress' );
$content .= '</td></tr>';

// Keep url
$content .= '<tr><th><span>';
$content .= __( 'Keep url', 'MailPress' );
$content .= '</span></th><td>';
$content .= __('When full url for images is provided, should MailPress load these images inside the mail ?', 'MailPress');
$content .= '<br />';
$content .= __( 'Check this box to lighten the weight of your mails and to minimise use of ressources (process, memory, data transfer ...).', 'MailPress' );
$content .= '</td></tr>';

$content .= '</table>';
