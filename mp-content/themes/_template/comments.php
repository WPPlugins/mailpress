<?php
/*
Template Name: comments
*/
$comment = $this->args->advanced->comment;
$post    = $this->args->advanced->post;
$url = add_query_arg('replytocom', $comment->comment_ID, $post->guid) . '#respond';

$this->build->_the_title = sprintf( 'Comment # %s in "{{the_title}}"', $comment->comment_ID );

$this->build->_the_actions = '<a ' . $this->classes( 'button', false ) . ' href="' . $url . '">' . __( 'Reply' ) . '</a>';

$this->get_template_part( '_mail' );