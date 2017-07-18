<!-- batches -->
<form name="<?php echo basename(__DIR__); ?>" method="post" class="mp_settings">

	<input type="hidden" name="_tab" value="<?php echo basename(__DIR__); ?>" />

	<table class="form-table">
<?php	

do_action( 'MailPress_settings_batches_form' ); 

?>
	</table>
<?php 

MP_AdminPage::save_button();

?>
</form>