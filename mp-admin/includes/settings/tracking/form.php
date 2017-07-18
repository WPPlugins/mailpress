<?php // tracking

if ( !isset( $tracking ) )
{
	$tracking = get_option( MailPress_tracking::option_name );
}

foreach( array( 'mail', 'user' ) as $folder )
{
	$MP_Tracking_metaboxes	= new MP_Tracking_metaboxes( $folder, array() );
	$tracking_reports[$folder]	= $MP_Tracking_metaboxes->get_all( $folder );
}

?>
<form name="<?php echo basename(__DIR__); ?>" method="post" class="mp_settings">
	<input type="hidden" name="_tab" value="<?php echo basename(__DIR__); ?>" />
	<table class="form-table rc-table w40">
		<tr>
			<th><?php _e( 'User', 'MailPress' ); ?></th>
			<th><?php _e( 'Mail', 'MailPress' ); ?></th>
		</tr>
		<tr>
			<td class="vat field">
<?php
foreach ( $tracking_reports['user'] as $k => $v )
{
?>
<input type="checkbox" value="<?php echo $k; ?>" name="tracking[<?php echo $k; ?>]" id="<?php echo $k; ?>"<?php if ( isset( $tracking[$k] ) ) checked( $k, $tracking[$k] ); ?> /><label for="<?php echo $k; ?>">&#160;<?php echo $v['title']; ?></label><br />
<?php
}
?>
			</td>
			<td class="vat field">
<?php
foreach ( $tracking_reports['mail'] as $k => $v )
{
?>
<input type="checkbox" value="<?php echo $k; ?>" name="tracking[<?php echo $k; ?>]" id="<?php echo $k; ?>"<?php if ( isset( $tracking[$k] ) ) checked( $k, $tracking[$k] ); ?> /><label for="<?php echo $k; ?>">&#160;<?php echo $v['title']; ?></label><br />
<?php
}
?>
			</td>
		</tr>
	</table>
<?php do_action( 'MailPress_settings_tracking_form' ); ?>
<?php MP_AdminPage::save_button(); ?>
</form>