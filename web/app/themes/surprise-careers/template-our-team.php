<?php
/**
 * Template name: Our team
 */

$context          = Timber::context();
$post = new Timber\Post();
$context['post'] = $post;

$context['teams'] = get_terms( 'category', [ 'hide_empty' => false, 'exclude' => 1 ] );


$cta_button = get_field( 'cta_block_button' );

if(isset($cta_button) && !empty($cta_button)){
	$context['cta_block'] = [
		'title'  => get_field( 'cta_block_title' ),
		'text'   => get_field( 'cta_block_text' ),
		'button' => $cta_button
	];
}


Timber::render( 'page-our-team.twig', $context );