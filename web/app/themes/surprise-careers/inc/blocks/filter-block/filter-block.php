<?php

$context = Timber::context();

// Store block values.
$context['block'] = $block;

// Store field values.
$context['fields'] = get_fields();

// Store $is_preview value.
$context['is_preview'] = $is_preview;

$context['categories'] = get_terms('category', [
	'hide_empty' => false,
	'exclude' => '1'
]);

$context['locations'] = get_terms( 'locations', [
	'hide_empty' => false,
	'childless' => true
] );

if($context['fields']['show_initial_results']){
	$context['careers'] = new Timber\PostQuery('post_type=career');
}

// Render the block.
Timber::render( 'blocks/filter-block.twig', $context );

