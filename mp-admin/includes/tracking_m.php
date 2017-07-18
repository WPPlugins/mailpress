<?php
global $title, $mp_mail;
?>
<div class="wrap">
	<h1>
		<?php echo esc_html( $title ); ?>
	</h1>
<?php if ( isset( $message ) ) MP_AdminPage::message( $message ); ?>
	<table class="widefat">
		<thead>
			<tr>
<?php MP_AdminPage::columns_list(); ?>
			</tr>
		</thead>
		<tbody id="the-mail-list">
<?php echo MP_AdminPage::get_row( $_GET['id'], array(), false, true ); ?>
		</tbody>
	</table>
	<div id="dashboard-widgets-wrap">
		<div id="dashboard-widgets" class="metabox-holder">
			<div class="postbox-container" style="width: 49%;">
<?php do_meta_boxes( MP_AdminPage::screen, 'normal', $mp_mail ); ?>
			</div>
			<div class="postbox-container" style="width: 49%;">
<?php do_meta_boxes( MP_AdminPage::screen, 'side', $mp_mail ); ?>
			</div>
		</div>
		<form method="post" style="display:none">

			<?php wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ); ?>
			<?php wp_nonce_field( 'meta-box-order',  'meta-box-order-nonce', false );  ?>

		</form>
		<div class="clear"></div>
	</div><!-- dashboard-widgets-wrap -->
</div>