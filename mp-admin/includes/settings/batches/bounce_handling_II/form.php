<!-- bounce_handling_II -->
<?php

$pop3 = ( get_option( MailPress_bounce_handling_II::option_name_pop3 ) );

if ($pop3)
{

$xevery = array ( 	30 	=> sprintf( __( '%1$s seconds', 'MailPress' ), '30' ), 
			45 	=> sprintf( __( '%1$s seconds', 'MailPress' ), '45' ), 
			60 	=> sprintf( __( '%1$s minute' , 'MailPress' ) , '' ), 
			120 	=> sprintf( __( '%1$s minutes', 'MailPress' ), '2' ), 
			300 	=> sprintf( __( '%1$s minutes', 'MailPress' ), '5' ), 
			900 	=> sprintf( __( '%1$s minutes', 'MailPress' ), '15' ), 
			1800 	=> sprintf( __( '%1$s minutes', 'MailPress' ), '30' ), 
			3600 	=> sprintf( __( '%1$s hour', 	'MailPress' ), '' ) ); 

$xmailboxstatus = array( 	0	=>	__( 'no changes', 'MailPress' ),
					1	=>	__( 'mark as read', 'MailPress' ),
					2	=>	__( 'delete', 'MailPress' ) );

if ( !isset( $bounce_handling_II ) ) $bounce_handling_II = get_option( MailPress_bounce_handling_II::option_name );
?>
		<tr class="mp_sep">
			<th class="thtitle"><?php _e( 'Handling Bounces', 'MailPress' ); ?> II</th>
			<td></td>
		</tr>
<?php if ( !class_exists( 'MailPress_bounce_handling' ) ) : ?>
		<tr>
			<th><?php _e( 'Return-Path', 'MailPress' ); ?></th>
			<td class="field">
				<input type="text" name="bounce_handling_II[Return-Path]" size="25" value="<?php if ( isset( $bounce_handling_II['Return-Path'] ) ) echo esc_attr( $bounce_handling_II['Return-Path'] ); ?>" />
				<br /><?php _e( 'optional', 'MailPress' ); ?>
			</td>
		</tr>
<?php endif; ?>
		<tr>
			<th><?php _e( 'Max bounces per user', 'MailPress' ); ?></th>
			<td class="field">
				<select name="bounce_handling_II[max_bounces]" class="w4e">
<?php MP_AdminPage::select_number( 0, 5, ( ( isset( $bounce_handling_II['max_bounces'] ) ) ? $bounce_handling_II['max_bounces'] : 1 ) );?>
				</select>
			</td>
		</tr>
		<tr>
			<th><?php _e( 'Bounce in mailbox', 'MailPress' ); ?></th>
			<td class="field">
				<select name="bounce_handling_II[mailbox_status]">
<?php MP_AdminPage::select_option( $xmailboxstatus, ( ( isset( $bounce_handling_II['mailbox_status'] ) ) ? $bounce_handling_II['mailbox_status'] : 2 ) );?>
				</select>
			</td>
		</tr>
		<tr>
			<th><?php _e( 'Submit batch with', 'MailPress' ); ?></th>
			<td>
				<table class="general">
					<tr>
						<td class="pr10">
							<label for="bounce_handling_II_wp_cron">
								<input type="radio" value="wpcron" name="bounce_handling_II[batch_mode]" id="bounce_handling_II_wp_cron" class="submit_batch_bounce_II tog"<?php checked( 'wpcron', $bounce_handling_II['batch_mode'] ); ?> />
								&#160;&#160;
								<?php _e( 'Wp_cron', 'MailPress' ); ?>
							</label>
						</td>
						<td class="bounce_II_wpcron pr10 every toggl3_II<?php if ( 'wpcron' != $bounce_handling_II['batch_mode'] ) echo ' hide'; ?>">
							<?php _e( 'Every', 'MailPress' ); ?>
							&#160;&#160;
							<select name="bounce_handling_II[every]">
<?php MP_AdminPage::select_option( $xevery, $bounce_handling_II['every'] );?>
							</select>
							<span>
<?php
if (MP_addons::is_active('MailPress_wp_cron'))
{
	printf( __('You can check your scheduled jobs, if any, on %1$s', 'MailPress'), sprintf( '<a href="' . MailPress_wp_cron . '" target="_blank">%s</a>', __( 'Tools > Wp_cron', 'MailPress' ) ) );
}
else
{
	printf( __('Activate add-on %1$s, so you can check your scheduled jobs, if any.', 'MailPress'), sprintf( '<a href="' . MailPress_addons . '#MailPress_wp_cron' . '" target="_blank">%s</a>', __( 'Wp_cron', 'MailPress' ) ) );
}
?>
							</span>
						</td>
					</tr>
					<tr>
						<td class="pr10">
							<label for="bounce_handling_II_other">
								<input type="radio" value="other" name="bounce_handling_II[batch_mode]" id="bounce_handling_II_other" class="submit_batch_bounce_II tog"<?php checked( 'other', $bounce_handling_II['batch_mode'] ); ?> />
								&#160;&#160;
								<?php _e( 'Other', 'MailPress' ); ?>
							</label>
						</td>
						<td class="bounce_II_other pr10 toggl3_II<?php if ( 'other' != $bounce_handling_II['batch_mode'] ) echo ' hide'; ?>">
							<span>
								<?php _e( "Don't forget to set up a cron job/scheduled task at required frequency (out of WordPress)", 'MailPress' ); ?><br />
								<?php printf( __( 'url for job : "%1$s"', 'MailPress' ), '<code>' . admin_url( 'admin-ajax.php' ) . "?action=mp_cron&hook=" . MailPress_bounce_handling_II::process_name . '</code>' ); ?>
							</span>
						</td>
					</tr>
				</table>
			</td>
		</tr>
<?php
} // if $pop3
else
{
?>
		<tr class="mp_sep">
			<th class="thtitle"><?php _e( 'Handling Bounces', 'MailPress' ); ?></th>
			<td></td>
		</tr>
		<tr>
			<td colspan="2"><?php _e( 'Set your POP3 settings first !', 'MailPress' ); ?></td>
		</tr>
<?php
}