<?php

add_action('init', 'register_jobs_post_type');

function register_jobs_post_type(){
	register_post_type('career', array(
		'label' => 'Careers',
		'description' => '',
		'hierarchical' => false,
		'supports' => array(
			0 => 'title',
			1 => 'thumbnail',
			2 => 'comments',
			3 => 'author'
		),
		'taxonomies' => array(
			0 => 'category',
		),
		'public' => true,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'can_export' => true,
		'delete_with_user' => 'null',
		'labels' => array(
			'singular_name' => 'Job',
			'add_new' => 'Add new Job',
		),
		'menu_icon' => 'dashicons-businessman',
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => false,
		'show_in_admin_bar' => true,
		'rewrite' => true,
		'has_archive' => true,
		'show_in_rest' => true,
		'rest_base' => '',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'acfe_archive_template' => '',
		'acfe_archive_ppp' => 10,
		'acfe_archive_orderby' => 'date',
		'acfe_archive_order' => 'DESC',
		'acfe_single_template' => '',
		'acfe_admin_archive' => false,
		'acfe_admin_ppp' => 10,
		'acfe_admin_orderby' => 'date',
		'acfe_admin_order' => 'DESC',
		'capability_type' => 'post',
		'capabilities' => array(
		),
		'map_meta_cap' => NULL,
	));
}