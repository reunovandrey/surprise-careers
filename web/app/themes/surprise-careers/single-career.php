<?php

$post                  = new Timber\Post();
$context               = Timber::context();
$context['post']       = $post;
$context['categories'] = $post->categories();

$context['recruiter'] = [
	'name'   => $authordata,
	'avatar' => get_avatar( get_the_author_meta( 'ID' ) )
];

/**
 * Encoding data for "Share this vacancy" block
 */
$context['share_data'] = [
	'url'   => urlencode( get_the_permalink() ),
	'title' => urlencode( html_entity_decode( get_the_title(), ENT_COMPAT, 'UTF-8' ) ),
	'media' => urlencode( get_the_post_thumbnail( get_the_ID(), 'full' ) )
];

/**
 * Setup data for "Refer a friend" block
 */
$ref_page     = get_page_by_path( 'referral-program' );
$ref_page_url = get_permalink( $ref_page );

$context['cta_block'] = [
	'title'      => __( 'Noticed a perfect match for a friend?', 'surprise' ),
	'text' => __( 'Get a valuable bonus for a reference', 'surprise' ),
	'button'      => [
		'title' => __( 'Refer a friend', 'surprise' ),
		'url'   => add_query_arg( 'job_id', $post->ID, $ref_page_url ),
	]
];

Timber::render( 'single-career.twig', $context );