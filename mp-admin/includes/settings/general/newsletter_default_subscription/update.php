<?php //newsletter_default_subscription

if ( isset( $_POST['comment_newsletter_subscription'] ) )
{
	update_option ( MailPress_comment_newsletter_subscription::option_name, $_POST['comment_newsletter_subscription'] );
}
