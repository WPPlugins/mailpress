<?php
global $wpdb, $mp_general, $mp_subscriptions;

//
// MANAGING H1
//

$h1 = __( 'MailPress Settings', 'MailPress' );

//
// MANAGING TABS
//

$divs = array();
$form_invalid = '';

$_tabs = MP_AdminPage::get_tabs();

$tab_active = ( isset( $mp_general['tab'] ) ) ? $mp_general['tab'] : 'general';

if ( isset( $_POST['_tab'] ) )
{
	$no_error = true;
	$message = false;
	$form_invalid = 'form-invalid';

	$mp_general['tab'] = $tab_active = $_POST['_tab'];

	$file = 'settings/' . $_POST['_tab'] . '/update.php';
	include( $file );

	update_option( MailPress::option_name_general, $mp_general );
}
else
{
	$parms = MP_AdminPage::get_url_parms( array( 'tab' ) );
	if ( !empty( $parms ) && isset( $parms['tab'] ) )
	{
		$tab_active = $parms['tab'];
	}
}
?>
<div class="wrap">
	<h1>
		<?php echo esc_html( $h1 ); ?>
	</h1>
<?php if ( isset( $message ) ) MP_AdminPage::message( $message, $no_error ); ?>
	<div id="settings-tabs">
		<ul>
<?php 
	$i = $i_tab = 0;
	foreach( $_tabs as $_tab => $desc )
	{
		if ( $tab_active == $_tab ) $i_tab = $i;
		echo "\t\t\t" . '<li><a href="#fragment-' . $_tab . '" title="' . esc_attr( $desc ) . '"><span class="button-secondary">' . $desc . '</span></a></li>' . "\n";
		$i++;
	}
	wp_localize_script( MailPress_page_settings, 'MP_AdminPage_var', array( 'the_tab' => $i_tab, 'the_tab_name' => $tab_active ) );
?>
		</ul>
<?php
	foreach( $_tabs as $_tab => $desc )
	{
?>
		<div class="fragments" id="fragment-<?php echo $_tab; ?>" data-tab="<?php echo $_tab; ?>">
<?php 
		$file = 'settings/' . $_tab . '/form.php';
		include( $file );
?>
		</div>
<?php
	}
?>
	</div>
</div>