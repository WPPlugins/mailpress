<!-- batch_spool_send -->
<?php 

$xevery = array ( 	30 	=> sprintf( __( '%1$s seconds', 'MailPress' ), '30' ), 
			45 	=> sprintf( __( '%1$s seconds', 'MailPress' ), '45' ), 
			60 	=> sprintf( __( '%1$s minute' , 'MailPress' ) , '' ), 
			120 	=> sprintf( __( '%1$s minutes', 'MailPress' ), '2' ), 
			300 	=> sprintf( __( '%1$s minutes', 'MailPress' ), '5' ), 
			900 	=> sprintf( __( '%1$s minutes', 'MailPress' ), '15' ), 
			1800 	=> sprintf( __( '%1$s minutes', 'MailPress' ), '30' ), 
			3600 	=> sprintf( __( '%1$s hour', 	'MailPress' ), '' ) ); 

if ( !isset( $batch_spool_send ) ) $batch_spool_send = get_option( MailPress_batch_spool_send::option_name );
?>
		<tr class="mp_sep">
			<th class="thtitle"><?php _e( 'Sending Mails from spool', 'MailPress' ); ?></th>
			<td></td>
		</tr>
		<tr<?php if ( isset( $spoolpath ) ) echo ' class="form-invalid"'; ?>>
			<th><?php _e( 'Spool Path', 'MailPress' ); ?></th>
			<td class="field">
				<input type="text" name="batch_spool_send[path]" size="100" value="<?php if ( isset( $batch_spool_send['path'] ) ) echo $batch_spool_send['path']; ?>" />
				<br /><?php printf( __( 'If empty, default path is %s but can be deleted anytime by automatic upgrade', 'MailPress' ), '"<code>' . MP_ABSPATH . 'tmp/spool</code>"'  ); ?>
			</td>
		</tr>

		<tr>
			<th><?php _e( 'Time limit in seconds', 'MailPress' ); ?></th>
			<td class="field">
				<select name="batch_spool_send[time_limit]">
<?php MP_AdminPage::select_option( $xevery, $batch_spool_send['time_limit'] );?>
				</select>
			</td>
		</tr>
		<tr>
			<th><?php _e( 'Max mails sent per batch', 'MailPress' ); ?></th>
			<td class="field">
				<select name="batch_spool_send[per_pass]">
<?php MP_AdminPage::select_number( 1, 10, $batch_spool_send['per_pass'], 1 );?>
<?php MP_AdminPage::select_number( 11, 100, $batch_spool_send['per_pass'], 10 );?>
<?php MP_AdminPage::select_number( 101, 1000, $batch_spool_send['per_pass'], 100 );?>
<?php MP_AdminPage::select_number( 1001, 10000, $batch_spool_send['per_pass'], 1000 );?>
				</select>
			</td>
		</tr>
		<tr>
			<th><?php _e( 'Max retries', 'MailPress' ); ?></th>
			<td class="field">
				<select name="batch_spool_send[max_retry]" class="w4e">
<?php MP_AdminPage::select_number( 0, 5, $batch_spool_send['max_retry'] );?>
				</select>
			</td>
		</tr>
		<tr>
			<th><?php _e( 'Submit batch with', 'MailPress' ); ?></th>
			<td>
				<table class="general">
					<tr>
						<td class="pr10">
							<label for="batch_spool_send_wp_cron">
								<input type="radio" value="wpcron" name="batch_spool_send[batch_mode]" id="batch_spool_send_wp_cron" class="submit_spool tog"<?php checked( 'wpcron', $batch_spool_send['batch_mode'] ); ?> />
								&#160;&#160;
								<?php _e( 'Wp_cron', 'MailPress' ); ?>
							</label>
						</td>
						<td class="wpcron pr10 every toggl2<?php if ( 'wpcron' != $batch_spool_send['batch_mode'] ) echo ' hide'; ?>">
							<?php _e( 'Every', 'MailPress' ); ?>
							&#160;&#160;
							<select name="batch_spool_send[every]">
<?php MP_AdminPage::select_option( $xevery, $batch_spool_send['every'] );?>
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
							<label for="batch_spool_send_other">
								<input type="radio" value="other" name="batch_spool_send[batch_mode]" id="batch_spool_send_other" class="submit_spool tog"<?php checked( 'other', $batch_spool_send['batch_mode'] ); ?> />
								&#160;&#160;
								<?php _e( 'Other', 'MailPress' ); ?>
							</label>
						</td>
						<td class="other pr10 toggl2<?php if ( 'other' != $batch_spool_send['batch_mode'] ) echo ' hide'; ?>">
							<span>
								<?php _e( "Don't forget to set up a cron job/scheduled task at required frequency (out of WordPress)", 'MailPress' ); ?><br />
								<?php printf( __( 'url for job : "%1$s"', 'MailPress' ), '<code>' . admin_url( 'admin-ajax.php' ) . "?action=mp_cron&hook=" . MailPress_batch_spool_send::process_name . '</code>' ); ?>
							</span>
						</td>
					</tr>
				</table>
			</td>
		</tr>