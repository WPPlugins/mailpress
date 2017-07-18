<?php // general

$content .= '<table>';
// From

$content .= '<tr><th>';
$content .= __( 'From', 'MailPress' );
$content .= '</th><td></td></tr>';

$content .= '<tr><th><span>';
$content .= __( 'All Mails...', 'MailPress' );
$content .= '</span></th><td>';
$content .= sprintf( __( 'Email and name that will be set for all your automated mails. If you are authorized, you can edit these values for any new %s.', 'MailPress' ), sprintf( '<a href="%1$s" target="_blank">%2$s</a>', MailPress_write, __( 'Mail', 'MailPress' ) ) ) ; 
$content .= '</td></tr>';
// Blog

$content .= '<tr><th>';
$content .= __( 'On Blog', 'MailPress' );
$content .= '</th><td></td></tr>';

$content .= '<tr><th><span>';
$content .= __( 'View mail...', 'MailPress' );
$content .= '</span></th><td>';
$content .= __( 'In any mail, when clicking on link "View", will route to your website to show the mail as a full html page.', 'MailPress' );
$content .= '</td></tr>';
$content .= '<tr><th><span>';
$content .= __( 'Manage&nbsp;subscriptions...', 'MailPress' );
$content .= '</span></th><td>';
$content .= sprintf( __( 'In any mail, when clicking on link "Unsubscribe", will route to your website to show a default page or a more sophisticated one using WordPress theme %1$s or %2$s template.', 'MailPress' ), sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://developer.wordpress.org/themes/template-files-section/taxonomy-templates/', __('category', 'MailPress' ) ), sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://developer.wordpress.org/themes/template-files-section/page-template-files/', __('page', 'MailPress' ) ) ); 
$content .= '<br />';
$content .= __( 'Template samples are available in <code>mailpress/mp-content/xtras</code> folder.', 'MailPress' );
$content .= ' ';
$content .= sprintf( __( ' Read this %s for more explanations.', 'MailPress' ), sprintf( '<code><a href="%1$s" target="_blank">%2$s</a></code>', '../' . MP_PATH_CONTENT . 'xtras/readme.txt', 'readme.txt' ) ); 
$content .= '</td></tr>';

$content = apply_filters( 'MailPress_settings_general_help', $content );

// Admin

$content .= '<tr><th>';
$content .= __( 'Admin', 'MailPress' );
$content .= '</th><td></td></tr>';

$content .= '<tr><th><span>';
$content .= __( 'Dashboard w...', 'MailPress' );
$content .= '</span></th><td>';
$content .= __( 'To display stats, charts related to your mail activity on your WP dashboard.', 'MailPress' );
$content .= '</td></tr>';
$content .= '<tr><th><span>';
$content .= __( 'MP version of wp_mail', 'MailPress' );
$content .= '</span></th><td>';
$content .= sprintf( __( 'To customize all mails sent by WordPress with your %s.', 'MailPress' ), sprintf( '<a href="%1$s" target="_blank">%2$s</a>', MailPress_themes, __( 'MailPress mail theme', 'MailPress' ) )  ); 
$content .= '</td></tr>';

$content = apply_filters( 'MailPress_settings_general_help_admin', 	$content );

$content = apply_filters( 'MailPress_settings_general_help_footer',	$content );

$content .= '</table>';
