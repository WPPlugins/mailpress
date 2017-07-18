<?php // general

$subscription_mngt = array ( 'ajax' => __( 'Default', 'MailPress' ), 'page_id' => __( 'Page template', 'MailPress' ), 'cat' => __( 'Category template', 'MailPress' ) );

if ( !isset( $_POST['_tab'] ) || ( 'general' != $_POST['_tab'] ) )
{
	$mp_general = get_option( MailPress::option_name_general );
}

if ( !isset( $mp_general['subscription_mngt'] ) )
{
	$mp_general['subscription_mngt'] = 'ajax';
	$mp_general['id'] = '';
}

?>
<form name="<?php echo basename(__DIR__); ?>" method="post" class="mp_settings">
	<input type="hidden" name="_tab" value="<?php echo basename(__DIR__); ?>" />
	<table class="form-table">


<!-- From -->
		<tr class="mp_sep">
			<th class="thtitle"><?php _e( 'From', 'MailPress' ); ?></th>
			<td class="nopad"></td>
		</tr>
		<tr>
			<th><?php _e( 'All Mails sent from', 'MailPress' ); ?></th>
			<td class="nopad">
				<table class="subscriptions">
					<tr>
						<td class="pr10<?php if ( isset( $fromemailclass ) ) echo " $form_invalid"; ?>">
							<?php _e( 'Email : ', 'MailPress' ); ?>
							<input type="text" name="general[fromemail]" size="25" value="<?php echo ( isset( $mp_general['fromemail'] ) ) ? $mp_general['fromemail'] : ''; ?>" />
						</td>
						<td class="pr10<?php if ( isset( $fromnameclass ) ) echo " $form_invalid"; ?>">
							<?php _e( 'Name : ', 'MailPress' ); ?> 
							<input type="text" name="general[fromname]" size="25"  value="<?php echo ( isset( $mp_general['fromname'] ) ) ? esc_attr( $mp_general['fromname'] ) : ''; ?>" />
						</td>
					</tr>
				</table>
			</td>
		</tr>
<!-- Blog -->
		<tr class="mp_sep">
			<th class="thtitle"><?php _e( 'On Blog', 'MailPress' ); ?></th>
			<td class="nopad"></td>
		</tr>
		<tr>
			<th><label for="fullscreen"><?php _e( 'View mail in fullscreen', 'MailPress' ); ?></label></th>
			<td>
				<input type="checkbox" name="general[fullscreen]" id="fullscreen"<?php checked( isset( $mp_general['fullscreen'] ) ); ?> />
			</td>
		</tr>
		<tr>
			<th><?php _e( ' Manage subscriptions from', 'MailPress' ); ?></th>
			<td class="nopad">
				<table>
					<tr>
						<td>
							<select name="general[subscription_mngt]" class="subscription_mngt">
<?php MP_AdminPage::select_option( $subscription_mngt, $mp_general['subscription_mngt'] );?>
							</select>
						</td>
						<td class="mngt_id<?php if ( isset( $idclass ) ) echo " $form_invalid"; ?>"<?php if ( 'ajax' == $mp_general['subscription_mngt'] ) echo ' style="display:none;"'; ?>>
							<input type="text" name="general[id]" size="4" value="<?php echo $mp_general['id']; ?>" />
							<span class="page_id toggle"<?php if ( 'page_id' != $mp_general['subscription_mngt'] ) echo ' style="display:none;"'; ?>><?php _e( "Page id", 'MailPress' ); ?></span>
							<span class="cat     toggle"<?php if ( 'cat'     != $mp_general['subscription_mngt'] ) echo ' style="display:none;"'; ?>><?php _e( "Category id", 'MailPress' ); ?></span>
						</td>
					</tr>
				</table>
			</td>
		</tr>
<?php do_action( 'MailPress_settings_general_form' ); ?>

<!-- Admin -->
		<tr class="mp_sep">
			<th class="thtitle"><?php _e( 'Admin', 'MailPress' ); ?></th>
			<td class="nopad"></td>
		</tr>
		<tr>
			<th><label for="dshbrd"><?php _e( 'Dashboard widgets', 'MailPress' ); ?></label></th>
			<td>
				<input type="checkbox" name="general[dashboard]" id="dshbrd"<?php checked( isset( $mp_general['dashboard'] ) ); ?> />
			</td>
		</tr>
		<tr>
			<th><label for="wpmail"><?php _e( 'MailPress version of wp_mail', 'MailPress' ); ?></label></th>
			<td>
				<input type="checkbox" name="general[wp_mail]"   id="wpmail"<?php checked( isset( $mp_general['wp_mail'] ) ); ?> />
			</td>
		</tr>
<?php do_action( 'MailPress_settings_general_form_admin' ); ?>

<!-- Add ons -->
<?php do_action( 'MailPress_settings_general_form_footer' ); ?>
	</table>
<?php if( !$mp_general ) { ?>
	<span class="startmsg"><?php _e( 'You can start to update your SMTP config, once you have saved your General settings', 'MailPress' ); ?></span>
<?php } ?>
<?php MP_AdminPage::save_button(); ?>
</form>