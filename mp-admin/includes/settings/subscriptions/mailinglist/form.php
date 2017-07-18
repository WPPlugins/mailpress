<!-- subscriptions > mailinglist -->
		<tr class="mp_sep">
			<th class="thtitle"><?php _e( 'Mailing lists', 'MailPress' ); ?></th>
			<td colspan="4"></td>
		</tr>
<?php

global $mp_general, $mp_subscriptions;
if ( !isset( $subscriptions ) ) $subscriptions = $mp_subscriptions;

?>
		<tr>
			<th><?php _e( 'Opened to public', 'MailPress' ); ?></th>
			<td colspan="4">

				<input type="hidden"   name="mailinglist[on]" value="on" />

				<table id="mailinglists" class="general">
					<tr>
						<td>
<?php
$default_mailing_list = get_option( self::option_name_default );

$mls = array();
$mailinglists = apply_filters( 'MailPress_mailinglists', array() );

if ( empty( $mailinglists ) )
{
	_e( 'You need to create at least one mailinglist.', 'MailPress' );
}
else
{
	foreach ( $mailinglists as $k => $v ) 
	{
		$x = str_replace( 'MailPress_mailinglist~', '', $k, $count );
		if ( 0 == $count ) 	continue;	
		if ( empty( $x ) ) 	continue;
		$mls[$x] = $v;
	}

	foreach ( $mls as $k => $v )
	{
?>
							<label for="subscriptions_display_mailinglists_<?php echo $k; ?>">
								<input type="checkbox" name="subscriptions[display_mailinglists][<?php echo $k; ?>]" id="subscriptions_display_mailinglists_<?php echo $k; ?>"<?php if ( isset( $mp_subscriptions['display_mailinglists'][$k] ) ) checked( 'on', $mp_subscriptions['display_mailinglists'][$k] ); ?> />&#160;&#160;<?php echo $v; ?>
							</label>
							<br />
<?php
	}
}
?>
						</td>
					</tr>
				</table>
			</td>
		</tr>