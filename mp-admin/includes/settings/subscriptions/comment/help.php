<?php // comment

$content .= '<table>';

$content .= '<tr><th>';
$content .= __( 'Comments', 'MailPress' );
$content .= '</th><td>';
$content .= __( 'to send a mailing for each mailpress user following a conversation on a post.', 'MailPress' );
$content .= '</td></tr>';

// Checked by default
$content .= '<tr><th><span>';
$content .= __( '...default...', 'MailPress' );
$content .= '</span></th><td>';
$content .= __( 'In the comment form, a checkbox is inserted (checked or unchecked by default) to register (or not) the mailpress user and his/her subscription to that conversation.', 'MailPress' );
$content .= '</td></tr>';

$content .= '</table>';

$content .= '<hr />';