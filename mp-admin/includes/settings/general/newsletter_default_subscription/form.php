<?php //newsletter_default_subscription

$settings = get_option( MailPress_comment_newsletter_subscription::option_name );

$args = array( 	'htmlname'	=> 'comment_newsletter_subscription[default]', 
			'admin'	=> true, 
			'type'	=> 'select',
			'selected'	=> ( isset( $settings['default'] ) ) ? $settings['default'] : '',
 );
?>
		<tr>
			<th><?php _e( 'Default  subscription', 'MailPress' ); ?></th>
			<td class="nopad">
				<table>
					<tr>
						<td>
							<?php echo MailPress_newsletter::get_checklist( false, $args ); ?>
						</td>
						<td>
							&#160;<?php _e( 'checked by default', 'MailPress' ); ?>&#160;
							<input type="checkbox" name="comment_newsletter_subscription[checked]"<?php checked( ( isset( $settings['checked'] ) ) ); ?> />
						</td>
					</tr>
				</table>
			</td>
		</tr>
