<!-- subscriptions > comment -->
		<tr class="mp_sep">
			<th class="thtitle"><?php _e( 'Comments', 'MailPress' ); ?></th>
			<td colspan="4"></td>
		</tr>
		<tr>
			<th>
				<label for="subscriptions_comment_checked">
					<?php _e( 'Checked by default', 'MailPress' ); ?>
				</label>
			</th>
			<td colspan="4">

				<input type="hidden"   name="comment[on]" value="on" />

				<input type="checkbox" name="subscriptions[comment_checked]" id="subscriptions_comment_checked"<?php checked( get_option( self::option ) ); ?> />
			</td>
		</tr>