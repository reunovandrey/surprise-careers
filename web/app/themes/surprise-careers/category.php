<?php

$context         = Timber::context();
$cur_category = new Timber\Term();
$context['page'] = $cur_category;

$context['locations'] = get_terms( 'locations', [
	'hide_empty' => false,
	'childless' => true
] );

$context['careers'] = new Timber\PostQuery('post_type=career&cat=' . $cur_category->term_id);

Timber::render( 'single-team.twig', $context );
