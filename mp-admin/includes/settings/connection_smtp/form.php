<?php // connection_smtp

$xssl = array ( ''	=> __( 'No', 'MailPress' ),
			'ssl'	=> 'SSL' ,
			'tls'	=> 'TLS' 
 ); 
$xport = array ( 	'25'		=> __( 'Default SMTP Port', 'MailPress' ),
			'465'		=> __( 'Use for SSL/TLS/GMAIL', 'MailPress' ),
			'custom'	=> __( 'Custom Port: (Use Box)', 'MailPress' )
 ); 

if ( !isset( $connection_smtp ) ) $connection_smtp = get_option( MailPress::option_name_smtp );

$connection_smtp['customport'] = '';
if ( isset( $connection_smtp['port'] ) && !in_array( $connection_smtp['port'], array( 25, 465 ) ) ) 
{
	$connection_smtp['customport'] = $connection_smtp['port']; 
	$connection_smtp['port'] = 'custom';
}

if ( isset( $pophostclass ) ) $connection_smtp['smtp-auth'] = '@PopB4Smtp';

?>
<form name="<?php echo basename(__DIR__); ?>" method="post" class="mp_settings">

	<input type="hidden" name="_tab" value="<?php echo basename(__DIR__); ?>" />

	<table class="form-table">
		<tr<?php if ( isset( $serverclass ) ) echo ' class="form-invalid"'; ?>>
			<th>
				<?php _e( 'SMTP Server', 'MailPress' ); ?>  
			</th>
			<td colspan="2">
				<input type="text" name="connection_smtp[server]" size="25" value="<?php echo ( isset( $connection_smtp['server'] ) ) ? esc_attr( $connection_smtp['server'] ) : ''; ?>" />
			</td>
		</tr>
		<tr<?php if ( isset( $usernameclass ) ) echo ' class="form-invalid"'; ?>>
			<th>
				<?php _e( 'Username', 'MailPress' ); ?>  
			</th>
			<td colspan="2">
				<input type="text" name="connection_smtp[username]" size="25" value="<?php echo ( isset( $connection_smtp['username'] ) ) ? esc_attr( $connection_smtp['username'] ) : ''; ?>" />
			</td>
		</tr>
		<tr>
			<th>
				<?php _e( 'Password', 'MailPress' ); ?>   
			</th>
			<td colspan="2">
				<input type="password" name="connection_smtp[password]" size="25" value="<?php echo ( isset( $connection_smtp['password'] ) ) ? esc_attr( $connection_smtp['password'] ) : ''; ?>" />
			</td>
		</tr>
		<tr>
			<th>
				<?php _e( 'Use SSL or TLS ?', 'MailPress' ); ?>   
			</th>
			<td colspan="2"<?php if ( isset( $customportclass ) ) echo ' class="form-invalid"'; ?>>
				<select name="connection_smtp[ssl]">
<?php MP_AdminPage::select_option( $xssl,( isset( $connection_smtp['ssl'] ) ) ? $connection_smtp['ssl'] : 'No' );?>
				</select>
				&#160;
<i><?php printf( __( 'Site registered socket transports are : <b>%1$s</b>', 'MailPress' ), ( array() == stream_get_transports() ) ? __( 'none', 'MailPress' ) : implode( '</b>, <b>',stream_get_transports() ) ); ?></i>
			</td>
		</tr>
		<tr>
			<th>
				<?php _e( 'Port', 'MailPress' ); ?>   
			</th>
			<td colspan="2">
				<select name="connection_smtp[port]">
<?php MP_AdminPage::select_option( $xport,( isset( $connection_smtp['port'] ) ) ? $connection_smtp['port'] : '25' );?>
				</select>
				&#160;
				<input type="text" size="4" name="connection_smtp[customport]" value="<?php echo $connection_smtp['customport']; ?>" />
			</td>
		</tr>
		<tr>
			<th>
				<label for="smtp-auth"><?php _e( 'Pop before Smtp', 'MailPress' ); ?></label>
			</th>
			<td> 
				<input type="checkbox" value="@PopB4Smtp" name="connection_smtp[smtp-auth]" id="smtp-auth"<?php if ( isset( $connection_smtp['smtp-auth'] ) ) checked( '@PopB4Smtp', $connection_smtp['smtp-auth'] ); ?> />
			</td>
			<td id="POP3"<?php  echo ( isset( $connection_smtp['smtp-auth'] ) && ( '@PopB4Smtp' == $connection_smtp['smtp-auth'] ) ) ? '' : ' style="display:none;"'; if ( isset( $pophostclass ) ) echo ' class="form-invalid"'; ?>> 
				<?php _e( "POP3 hostname", 'MailPress' ); ?>
				&#160;&#160;
				<input type="text" name="connection_smtp[pophost]" size="25" value="<?php if ( isset( $connection_smtp['pophost'] ) ) echo esc_attr( $connection_smtp['pophost'] ); ?>" />
				<?php _e( "port", 'MailPress' ); ?>
				&#160;&#160;
				<input type="text" name="connection_smtp[popport]" size="4"  value="<?php if ( isset( $connection_smtp['popport'] ) ) echo $connection_smtp['popport']; ?>" />
			</td>
		</tr>
	</table>
<?php MP_AdminPage::save_button(); ?>
</form>