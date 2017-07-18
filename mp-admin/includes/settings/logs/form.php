<?php // logs

if ( !isset( $logs ) )
{
	$logs = get_option( MailPress::option_name_logs );
}

?>
<form name="<?php echo basename(__DIR__); ?>" method="post" class="mp_settings">
	<input type="hidden" name="_tab" value="<?php echo basename(__DIR__); ?>" />
	<table class="form-table w50">

<?php MP_AdminPage::logs_sub_form( 'general', $logs, __( 'Mails', 'MailPress' ) ); ?>

<?php do_action( 'MailPress_settings_logs_form', $logs ); ?>

	</table>
<?php MP_AdminPage::save_button(); ?>
</form>