<?php

// Register Custom Taxonomy
function surprise_benefits() {

	$labels = array(
		'name'                       => _x( 'Benefits', 'Taxonomy General Name', 'surprise' ),
		'singular_name'              => _x( 'Benefit', 'Taxonomy Singular Name', 'surprise' ),
		'menu_name'                  => __( 'Benefits', 'surprise' ),
		'all_items'                  => __( 'All Items', 'surprise' ),
		'parent_item'                => __( 'Parent Item', 'surprise' ),
		'parent_item_colon'          => __( 'Parent Item:', 'surprise' ),
		'new_item_name'              => __( 'New Item Name', 'surprise' ),
		'add_new_item'               => __( 'Add New Item', 'surprise' ),
		'edit_item'                  => __( 'Edit Item', 'surprise' ),
		'update_item'                => __( 'Update Item', 'surprise' ),
		'view_item'                  => __( 'View Item', 'surprise' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'surprise' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'surprise' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'surprise' ),
		'popular_items'              => __( 'Popular Items', 'surprise' ),
		'search_items'               => __( 'Search Items', 'surprise' ),
		'not_found'                  => __( 'Not Found', 'surprise' ),
		'no_terms'                   => __( 'No items', 'surprise' ),
		'items_list'                 => __( 'Items list', 'surprise' ),
		'items_list_navigation'      => __( 'Items list navigation', 'surprise' ),
	);
	$args   = array(
		'labels'            => $labels,
		'hierarchical'      => false,
		'public'            => false,
		'show_ui'           => true,
		'show_admin_column' => false,
		'show_in_nav_menus' => false,
		'show_tagcloud'     => false,
		'show_in_rest'      => true,
	);
	register_taxonomy( 'benefit', array( 'career' ), $args );

}

add_action( 'init', 'surprise_benefits', 0 );