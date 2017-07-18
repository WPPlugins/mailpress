<?php
class MP_oembed_provider_Twitter extends MP_oembed_provider_
{
	public $id = 'Twitter';

	function data2html( $html, $data, $url )
	{
		switch ( $data->type )
		{
			case 'rich' :

				$data->author_id = substr( $data->author_url, strrpos( $data->author_url, '/' ) + 1 );

				$data->status_id = substr( $data->url, strrpos( $data->url, '/' ) + 1 );

				preg_match_all( "'<p(.*?)>(.*?)</p>'si", $data->html, $matches, PREG_SET_ORDER );
				$data->text = $matches[0][2];

				preg_match_all( "'<a(.*?)>(.*?)</a>'si", $data->html, $matches, PREG_SET_ORDER );

				$m = array_pop($matches);
				$data->datetime = $m[2];

				$r =array(	'%1$s' => $data->url, 
						'%2$s' => $data->author_id,
						'%3$s' => $data->author_name,
						'%4$s' => esc_url( 'https://twitter.com/' . $data->author_id . '/profile_image?size=normal' ),
						'%5$s' => $data->status_id,
						'%6$s' => $data->text,
						'%7$s' => $data->datetime
				);

				$template = file_get_contents( MP_ABSPATH . 'mp-includes/html/twitter.html' );

				$html = str_replace( array_keys($r), $r, $template );

			break;
		}
		return $html;
	}
}
new MP_oembed_provider_Twitter();
