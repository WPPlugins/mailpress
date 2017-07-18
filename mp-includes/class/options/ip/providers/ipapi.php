<?php
class MP_Ip_ipapi extends MP_ip_provider_
{
	var $id 	= 'ipapi';
	var $url	= 'https://ipapi.co/%1$s/xml/';
	var $credit = 'https://ipapi.co';
	var $type 	= 'xml';

	function content( $valid, $content )
	{
		if ( strpos( $content, '<error>True</error>' ) == true ) return false;
		return $valid;
	}

	function data( $content, $ip )
	{
		$skip = array( 'ip', 'timezone' );
		$html = '';

		$xml = $this->xml2array( $content );
		foreach ( $xml as $k => $v )
		{
			if ( empty( $v ) )   continue;
			if ( $v == 'n/a' ) continue;

			if ( in_array( $k, $skip ) ) continue;

			if ( in_array( $k, array( 'country', 'region', 'city', 'latitude', 'longitude' ) ) ) {$$k = $v; continue;}

			$html .= '<p style="margin:3px;"><b>' . $k . '</b> : ' . $v . '</p>';
		}
		$geo = ( isset( $latitude ) && isset( $longitude ) ) ? 	array( 'lat' => $latitude, 'lng' => $longitude ) : array();
		return $this->cache_custom( $ip, $geo, strtoupper( substr( $country, 0, 2 ) ), $region, $html );
	}
}
new MP_Ip_ipapi();