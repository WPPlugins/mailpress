<?php // connection_php_mail

if ( !isset( $connection_php_mail ) )
{
	$connection_php_mail = get_option( MailPress_connection_php_mail::option_name );
}

?>
<form name="<?php echo basename(__DIR__); ?>" method="post" class="mp_settings">

	<input type="hidden" name="_tab" value="<?php echo basename(__DIR__); ?>" />

	<table class="form-table">
		<tr>
			<th><?php _e( 'additional_parameters', 'MailPress' ); ?></th>
			<td class="field">
				<input type="text" name="connection_php_mail[addparm]" size="75" value="<?php echo $connection_php_mail['addparm']; ?>" />
				<br />
				<?php  printf( __( "(optional) Specify here the 5th parameter of php %s function", 'MailPress' ), sprintf( '<a href="%1$s" target="_blank">%2$s</a>', __( 'http://fr.php.net/manual/en/function.mail.php', 'MailPress' ), __( 'mail()', 'MailPress' ) ) ); ?>
			</td>
		</tr>
	</table>
<?php MP_AdminPage::save_button(); ?>
</form>