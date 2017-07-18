<?php
abstract class MP_theme_html_template_
{
	public static function who_is( $ip )
	{
		$x  = MP_Ip::get_all( $ip );

		if ( !$x['geo']['lat'] && !$x['geo']['lng'] ) return array( 'src' => false, 'addr' => false );

		$args = array();
		$args['center'] = $x['geo']['lat'] . ',' . $x['geo']['lng'];
		$args['zoom'] = 4;
		$args['size'] = '300x300';
		$args['maptype'] = 'roadmap';
		$args['markers'] = $x['geo']['lat'] . ',' . $x['geo']['lng'];
		$args['sensor'] = 'false';

		$src  = add_query_arg( $args, 'http://maps.googleapis.com/maps/api/staticmap' );

		$addr = MP_Ip::get_address( $x['geo']['lat'], $x['geo']['lng'] );

		return array( 'src' => $src, 'addr' => $addr[0] );
	}
}