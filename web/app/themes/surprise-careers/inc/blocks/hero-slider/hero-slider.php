<?php

$context = Timber::context();

// Store block values.
$context['block'] = $block;

// Store field values.
$context['fields'] = get_fields();

// Store $is_preview value.
$context['is_preview'] = $is_preview;

// Render the block.
Timber::render( 'blocks/hero-slider.twig', $context );

