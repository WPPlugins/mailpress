<?php // roles_and_capabilities
global $wp_roles;

$capabilities = MailPress::capabilities();
$capability_groups = MailPress::capability_groups();
$grouping_cap = array();
foreach ( $capabilities as $capability => $v )	$grouping_cap[$v['group']] [$capability] = null;

?>
<form name="<?php echo basename(__DIR__); ?>" method="post" class="mp_settings">

	<input type="hidden" name="_tab" value="<?php echo basename(__DIR__); ?>" />

	<table class="form-table rc-table">
		<tr>
			<th></th>
<?php
foreach( $wp_roles->role_names as $role => $name )
{
	if ( 'administrator' == $role ) continue;
	$name = __( $name );
?>
			<th><?php echo $name; ?></th>
<?php
}
?>
		</tr>
<?php
$prev_groupname = false;
foreach ( $capability_groups as $group => $groupname )
{
	if ( !isset( $grouping_cap[$group] ) ) continue;

	$class = ' class="mp_sep"';

	foreach ( $grouping_cap[$group] as $capability => $v )
	{
		$capname = $capabilities[$capability]['name'];
?>
		<tr<?php echo $class; $class = ''; ?>>
			<th><?php if ( $prev_groupname != $groupname ) {$prev_groupname = $groupname; echo $groupname;} ?></th>
<?php
		foreach( $wp_roles->role_names as $role => $name )
		{
			if ( 'administrator' == $role ) continue;
			$rcs = get_option( 'MailPress_r&c_' . $role );
?>
			<td class="capacity">
				<label for="<?php echo 'check_' . $role . '_' . $capability; ?>">
					<input type="checkbox" name="cap[<?php echo $role; ?>][<?php echo $capability; ?>]" id="<?php echo 'check_' . $role . '_' . $capability; ?>"<?php checked( isset( $rcs[$capability] ) ); ?> />
					<span id="<?php echo $role . '_' . $capability; ?>" class="<?php echo ( isset( $rcs[$capability] ) ) ? 'crok' : 'crko'; ?>"><?php echo $capname; ?></span>
				</label>
			</td>
<?php
		}
?>
		</tr>
<?php
	}
}
?>
	</table>
<?php MP_AdminPage::save_button(); ?>
</form>