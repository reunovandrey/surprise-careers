<?php

$context          = Timber::context();
$context['post'] = new Timber\Post();


$context['categories'] = get_terms('category', ['hide_empty' => false]);
$context['locations'] = get_terms( 'locations', [
	'hide_empty' => false,
	'childless' => true
] );
$context['careers'] = new Timber\PostQuery('post_type=jobs');
d(rest_url());
Timber::render( 'page-careers.twig', $context );