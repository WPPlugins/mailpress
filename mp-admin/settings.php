<?php
class MP_AdminPage extends MP_WP_Admin_page_
{
	const screen		= MailPress_page_settings;
	const capability	= 'MailPress_manage_options';
	const help_url		= 'http://blog.mailpress.org/tutorials/';
	const file			= __FILE__;

	public static $first = true;

//// Help ////

	public static function add_help_tab() 
	{
		global $current_screen;

		$_tabs = self::get_tabs();

		foreach( $_tabs as $_tab => $desc )
		{
			$content = '';

			$file = 'includes/settings/' . $_tab . '/help.php';
			include( $file );

			$current_screen->add_help_tab( array( 'id' => $_tab, 'title' => $desc, 'content' => $content ) );
		}
	}

////  Styles  ////

	public static function print_styles( $styles = array() ) 
	{
		wp_register_style( self::screen, '/' . MP_PATH . 'mp-admin/css/settings.css' );

		$styles[] = self::screen;
		parent::print_styles( $styles );
	}

////  Scripts  ////

	public static function print_scripts( $scripts = array() ) 
	{
		wp_register_script( 'mp-smtp',	'/' . MP_PATH . 'mp-admin/js/settings_smtp.js', array(), false, 1 );

		wp_register_script( self::screen, 	'/' . MP_PATH . 'mp-admin/js/settings.js', array( 'jquery-ui-tabs', 'mp-smtp' ), false, 1 );
		wp_localize_script( self::screen, 'MP_AdminPageL10n', array( 'requestFile' => admin_url( 'admin-ajax.php' ) ) );

		$scripts[] = self::screen;
		parent::print_scripts( $scripts );
	}

////  Misc  ////

	public static function get_tabs()
	{
		global $mp_general;

		$_tabs['general'] = __( 'General', 'MailPress' );

		if ( $mp_general )
		{
			$t = apply_filters( 'MailPress_Swift_Connection_type', 'SMTP' );
			$_tabs['connection_' . strtolower( $t )] = $t;
			$_tabs = apply_filters( 'MailPress_settings_tab_connection', $_tabs );

			$_tabs['test'] = __( 'Test', 'MailPress' );

			$_tabs = apply_filters( 'MailPress_settings_tab', $_tabs );

			$_tabs['logs'] = __( 'Logs', 'MailPress' );
		}

		return $_tabs;
	}

	public static function save_button()
	{
?>
<p class="submit">
	<input type="submit" name="Submit" class="button-primary" value="<?php  echo esc_attr( __( 'Save Changes' ) ); ?>" />
</p>
<?php
	}

	public static function logs_sub_form ( $name, $data, $headertext )
	{
		if ( !isset( $data[$name] ) )
		{
			$data[$name] = MailPress::$default_option_logs;
		}

		$xlevel = MP_Log::get_defined_constants();

		if ( self::$first )
		{
			self::$first = false;
?>
<tr>
	<th><strong><?php _e( 'Logs', 'MailPress' ); ?></strong></th>
	<td><strong><?php _e( 'Level', 'MailPress' ); ?></strong></td>
	<td><strong><?php _e( 'Days', 'MailPress' ); ?></strong></td>
	<td><strong><?php _e( 'Last purge', 'MailPress' ); ?></strong></td>
</tr>
<?php
		}

		if ( !isset( $xlevel[$data[$name]['level']] ) ) $data[$name]['level'] = key( array_slice( $xlevel, -1, 1, true) );
?>
<tr class="mp_sep">
	<th><strong><?php echo $headertext; ?></strong></th>
	<td>
		<select name="logs[<?php echo $name ?>][level]">
<?php self::select_option( $xlevel, $data[$name]['level'] );?>
		</select> 
	</td>
	<td>
		<select name="logs[<?php echo $name ?>][lognbr]">
<?php self::select_number( 1, 10, $data[$name]['lognbr'] );?>
		</select>
	</td>
	<td>
		<?php if ( !empty( $data[$name]['lastpurge'] ) ) echo substr( $data[$name]['lastpurge'],0 , 4 ) . '/' . substr( $data[$name]['lastpurge'],4, 2 ) . '/' . substr( $data[$name]['lastpurge'],6, 2 ); ?>
		<input type="hidden" name="logs[<?php echo $name ?>][lastpurge]" value="<?php echo $data[$name]['lastpurge']; ?>" />
	</td>
</tr>
<?php
	}
}