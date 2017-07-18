<!-- delete_old_mails -->
<?php

$xevery = array ( 	10 	=> sprintf( __( '%1$s days', 'MailPress' ), '10' ), 
				15 	=> sprintf( __( '%1$s days', 'MailPress' ), '15' ),  
				30 	=> sprintf( __( '%1$s days', 'MailPress' ), '30' ),  
				60 	=> sprintf( __( '%1$s days', 'MailPress' ), '60' ), 
				90 	=> sprintf( __( '%1$s days', 'MailPress' ), '90' ), 
				120 	=> sprintf( __( '%1$s days', 'MailPress' ), '120' ), 
				360 	=> sprintf( __( '%1$s days', 'MailPress' ), '360' ),  ); 

if ( !isset( $batch_delete_old_mails ) ) $batch_delete_old_mails = get_option( MailPress_delete_old_mails::option_name );
?>
		<tr class="mp_sep">
			<th class="thtitle"><?php _e( 'Deleting Old Mails', 'MailPress' ); ?></th>
			<td></td>
		</tr>
		<tr>
			<th><?php _e( 'Keep sent mails since', 'MailPress' ); ?></th>
			<td class="field">
				<select name="batch_delete_old_mails[days]">
<?php MP_AdminPage::select_option( $xevery, $batch_delete_old_mails['days'] );?>
				</select>
			</td>
		</tr>
		<tr>
			<th><?php _e( 'Submit batch with', 'MailPress' ); ?></th>
			<td>
				<table class="general">
					<tr>
						<td class="pr10">
							<label for="batch_delete_old_mails_wp_cron">
								<input type="radio" value="wpcron" name="batch_delete_old_mails[batch_mode]" id="batch_delete_old_mails_wp_cron" class="submit_batch_delete_old_mails tog"<?php checked( 'wpcron', $batch_delete_old_mails['batch_mode'] ); ?> />
								&#160;&#160;
								<?php _e( 'Wp_cron', 'MailPress' ); ?>
							</label>
						</td>
						<td class="delete_old_mails_wpcron pr10 every toggl4<?php if ( 'wpcron' != $batch_delete_old_mails['batch_mode'] ) echo ' hide'; ?>">
							<?php _e( 'Every', 'MailPress' ); ?>
							&#160;&#160;
							<select name="batch_delete_old_mails[every]">
<?php MP_AdminPage::select_option( $xevery, $batch_delete_old_mails['every'] );?>
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
							<label for="batch_delete_old_mails_other">
								<input type="radio" value="other" name="batch_delete_old_mails[batch_mode]" id="batch_delete_old_mails_other" class="submit_batch_delete_old_mails tog"<?php checked( 'other', $batch_delete_old_mails['batch_mode'] ); ?> />
								&#160;&#160;
								<?php _e( 'Other', 'MailPress' ); ?>
							</label>
						</td>
						<td class="delete_old_mails_other pr10 toggl4<?php if ( 'other' != $batch_delete_old_mails['batch_mode'] ) echo ' hide'; ?>">
							<span>
								<?php _e( "Don't forget to set up a cron job/scheduled task at required frequency (out of WordPress)", 'MailPress' ); ?><br />
								<?php printf( __( 'url for job : "%1$s"', 'MailPress' ), '<code>' . admin_url( 'admin-ajax.php' ) . "?action=mp_cron&hook=" . MailPress_delete_old_mails::process_name . '</code>' ); ?>
							</span>
						</td>
					</tr>
				</table>
			</td>
		</tr>