<?php // test

if ( !isset( $test ) ) $test = get_option( MailPress::option_name_test );

$th = new MP_Themes();
$themes = $th->themes; 
if ( empty( $test['theme'] ) ) $test['theme'] = $themes[$th->current_theme]['Stylesheet']; 

$xtheme = $xtemplates = array();
foreach ( $themes as $key => $theme )
{
	if ( 'plaintext' == $theme['Stylesheet'] ) unset( $themes[$key] );
	if ( '_' == $theme['Stylesheet'][0] )     unset( $themes[$key] );
}
foreach ( $themes as $key => $theme )
{
	$xtheme[$theme['Stylesheet']] = $theme['Stylesheet'];
	if ( !$templates = $th->get_page_templates( $theme['Stylesheet'] ) ) $templates = $th->get_page_templates( $theme['Stylesheet'], true );

	$xtemplates[$theme['Stylesheet']] = array();
	foreach ( $templates as $key => $value )
	{
		$xtemplates[$theme['Stylesheet']][$key] = $key;
	}
	if ( !empty( $xtemplates[$theme['Stylesheet']] ) ) ksort( $xtemplates[$theme['Stylesheet']] );

	array_unshift( $xtemplates[$theme['Stylesheet']], __( 'none', 'MailPress' ) );
}

?>
<form name="<?php echo basename(__DIR__); ?>" method="post" class="mp_settings">
	<input type="hidden" name="_tab" value="<?php echo basename(__DIR__); ?>" />
	<table class="form-table">
		<tr>
			<th><?php _e( 'To', 'MailPress' ); ?></th>
			<td class="nopad">
				<table class="subscriptions">
					<tr>
						<td class="pr10<?php if ( isset( $toemailclass ) ) echo " $form_invalid"; ?>">
							<?php _e( 'Email : ', 'MailPress' ); ?>
							<input type="text" name="test[toemail]" size="25" value="<?php if ( isset( $test['toemail'] ) ) echo esc_attr( $test['toemail'] ); ?>" />
						</td>
						<td class="pr10<?php if ( isset( $tonameclass ) ) echo " $form_invalid"; ?>">
							<?php _e( 'Name : ', 'MailPress' ); ?> 
							<input type="text" name="test[toname]"  size="25" value="<?php if ( isset( $test['toname'] ) ) echo esc_attr( $test['toname'] ); ?>" />
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<th>
				<?php _e( "Advanced options", 'MailPress' ); ?> 
			</th>
			<td> 
				<?php _e( 'Theme', 'MailPress' ); ?>
				&#160;
				<select name="test[theme]" id="theme">
<?php MP_AdminPage::select_option( $xtheme,$test['theme'] );?>
				</select>
				&#160;
				<?php _e( 'Template', 'MailPress' ); ?>
				&#160;
<?php 
foreach ( $xtemplates as $key => $xtemplate )
{
	$xx = ( isset( $test['theme'], $test['template'] ) && $key == $test['theme'] ) ? $test['template'] : '0';
?>
				<select name="test[th][<?php echo $key; ?>][tm]" id="<?php echo $key; ?>" class="<?php if ( $key != $test['theme'] ) echo 'mask ';?>template">
<?php MP_AdminPage::select_option( $xtemplate, $xx );?>
				</select>
<?php
}
?>
				<br /><br />
<?php
$count = 0;
$checks = array( 'forcelog' => __( 'Log it', 'MailPress' ), 'fakeit' => __( 'Send it', 'MailPress' ), 'archive' => __( 'Save it', 'MailPress' ), 'stats' => __( 'Include it in statistics', 'MailPress' ) );
foreach( $checks as $k => $v ) {
	$count++;
	echo "\t\t\t\t" . '<input type="checkbox" name="test[' . $k . ']" id="' . $k . '"' . checked( isset( $test[$k] ), true, false ) . ' />' . "\n\t\t\t\t&#160;\n\t\t\t\t" . '<label for="' . $k . '">' . $v . '</label>' . "\n";
	if ( $count != count( $checks ) ) echo "\t\t\t\t<br />\n";
}
?>
			</td>
		</tr>
	</table>
	<p class="submit">
		<input type="submit" name="Submit" class="button-primary" value="<?php  _e( 'Save', 'MailPress' ); ?>" />
		<input type="submit" name="Test"   class="button-primary" value="<?php  _e( 'Save &amp; Test', 'MailPress' ); ?>" />
	</p>
</form>