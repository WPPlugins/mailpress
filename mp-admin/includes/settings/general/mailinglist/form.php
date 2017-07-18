<?php // mailinglist

$default_mailinglist	= get_option( self::option_name_default );

$dropdown_options = array(	'hide_empty' 	=> 0, 
					'hierarchical' 	=> true,
					'show_count' 	=> 0,
					'orderby' 		=> 'name',
					'selected' 	=> $default_mailinglist,
					'htmlname' 	=> 'default_mailinglist'
);

?>
		<tr class="mp_sep">
			<th class="thtitle"><?php _e( 'Mailing lists', 'MailPress' ); ?></th>
			<td></td>
		</tr>
		<tr>
			<th><?php _e( 'Default', 'MailPress' ); ?></th>
			<td class="nopad">
				<?php	MP_Mailinglist::dropdown( $dropdown_options ); ?>
			</td>
		</tr>
