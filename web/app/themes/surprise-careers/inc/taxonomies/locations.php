<?php

add_action('init', 'register_locations_taxonomy');

function register_locations_taxonomy(){
	register_taxonomy('locations', array(
		0 => 'career',
	), array(
		'label' => 'locations',
		'description' => '',
		'hierarchical' => true,
		'post_types' => array(
			0 => 'jobs',
		),
		'public' => true,
		'publicly_queryable' => true,
		'update_count_callback' => '',
		'sort' => false,
		'labels' => array(
			'singular_name' => 'Location',
		),
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => false,
		'show_tagcloud' => false,
		'show_in_quick_edit' => true,
		'show_admin_column' => false,
		'rewrite' => true,
		'show_in_rest' => true,
		'rest_base' => '',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
		'acfe_single_template' => '',
		'acfe_single_ppp' => 10,
		'acfe_single_orderby' => 'date',
		'acfe_single_order' => 'DESC',
		'acfe_admin_ppp' => 10,
		'acfe_admin_orderby' => 'name',
		'acfe_admin_order' => 'ASC',
		'capabilities' => array(
		),
//		'meta_box_cb' => true,
	));
}
