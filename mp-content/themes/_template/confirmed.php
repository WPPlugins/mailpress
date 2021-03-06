<?php
/*
Template Name: confirmed
Subject: [<?php bloginfo( 'name' );?>] <?php printf( '%s confirmed', '{{toemail}}' ); ?>
*/

$this->build->_the_title = 'Congratulations !';

$this->build->_the_content = sprintf( 'You are now a subscriber of : %s .', sprintf( '<a %1$s href="%2$s">%3$s</a>', $this->classes( 'button', false ), site_url(), get_option( 'blogname' ) ) ) . '<br />';

$this->get_template_part( '_mail' );
