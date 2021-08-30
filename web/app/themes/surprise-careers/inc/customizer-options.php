<?php

add_filter( 'kirki_telemetry', '__return_false' );

Kirki::add_config( 'surprise_careers', [
	'capability'  => 'edit_theme_options',
	'option_type' => 'option',
] );


/**
 * =============== Panels and Sections ===============
 */

Kirki::add_panel( 'panel_header_options', [
	'priority' => 140,
	'title'    => esc_html__( 'Header options', 'surprise' ),
] );

Kirki::add_section( 'section_header_desktop', [
	'title'    => esc_html__( 'Header (desktop)', 'surprise' ),
	'panel'    => 'panel_header_options',
	'priority' => 110,
] );

Kirki::add_section( 'section_header_mobile', [
	'title'    => esc_html__( 'Header (mobile)', 'surprise' ),
	'panel'    => 'panel_header_options',
	'priority' => 120,
] );

Kirki::add_section( 'section_header_sign_in', [
	'title'    => esc_html__( 'Sign-in link', 'surprise' ),
	'panel'    => 'panel_header_options',
	'priority' => 130,
] );

Kirki::add_section( 'section_footer', [
	'title'    => esc_html__( 'Footer', 'surprise' ),
	'priority' => 150,
] );

Kirki::add_section( 'section_app_buttons', [
	'title'    => esc_html__( 'App Store & Play Market', 'surprise' ),
	'priority' => 150,
] );

Kirki::add_section( 'section_custom_codes', [
	'title'       => esc_html__( 'Custom JS Codes', 'surprise' ),
	'description' => esc_html__( 'Make sure <script> opening and closing tags are included', 'surprise' ),
	'priority'    => 160,
] );


/**
 * =============== Header desktop ===============
 */

//  header_cta_desktop_heading
Kirki::add_field( 'surprise_careers', [
	'type'     => 'custom',
	'settings' => 'header_cta_desktop_heading',
	'section'  => 'section_header_desktop',
	'default'  => '<h3 style="padding:15px 10px; background:#fff; margin:0;">' . __( 'CTA button', 'surprise' ) . '</h3>',
	'priority' => 10,
] );

//  header_cta_desktop_url
Kirki::add_field( 'surprise_careers', [
	'type'        => 'link',
	'settings'    => 'header_cta_desktop_url',
	'label'       => __( 'URL', 'surprise' ),
	'section'     => 'section_header_desktop',
	'description' => 'Leave URL and Text blank to disable CTA button',
	'priority'    => 20,
] );

//  header_cta_desktop_text
Kirki::add_field( 'surprise_careers', [
	'type'            => 'text',
	'settings'        => 'header_cta_desktop_text',
	'label'           => __( 'Text', 'surprise' ),
	'section'         => 'section_header_desktop',
	'priority'        => 30,
	'partial_refresh' => [
		'header_cta_desktop_text' => [
			'selector'        => '.header__cta > a.bttn-primary',
			'render_callback' => function () {
				return get_option( 'header_cta_desktop_text' );
			}
		]
	]
] );

//  header_cta_desktop_target
Kirki::add_field( 'surprise_careers', [
	'type'     => 'toggle',
	'settings' => 'header_cta_desktop_target',
	'label'    => __( 'Open in new tab', 'surprise' ),
	'section'  => 'section_header_desktop',
	'default'  => '0',
	'priority' => 40,
] );


/**
 * =============== Header Sign-in ===============
 */

//  header_sign_in_link
Kirki::add_field( 'surprise_careers', [
	'type'        => 'link',
	'settings'    => 'header_sign_in_link',
	'label'       => __( 'URL', 'surprise' ),
	'section'     => 'section_header_sign_in',
	'description' => 'Leave URL and Text blank to disable Sign-in link',
	'priority'    => 10,
] );

//  header_sign_in_text
Kirki::add_field( 'surprise_careers', [
	'type'            => 'text',
	'settings'        => 'header_sign_in_text',
	'label'           => __( 'Text', 'surprise' ),
	'section'         => 'section_header_sign_in',
	'priority'        => 20,
	'partial_refresh' => [
		'header_sign_in_text'        => [
			'selector'        => 'a.header__signin',
			'render_callback' => function () {
				return get_option( 'header_sign_in_text' );
			}
		],
		'header_sign_in_text_mobile' => [
			'selector'        => 'a.header__mobile__signin',
			'render_callback' => function () {
				return get_option( 'header_sign_in_text' );
			}
		]
	]
] );

//  header_sign_in_target
Kirki::add_field( 'surprise_careers', [
	'type'     => 'toggle',
	'settings' => 'header_sign_in_target',
	'label'    => __( 'Open in new tab', 'surprise' ),
	'section'  => 'section_header_sign_in',
	'default'  => '0',
	'priority' => 30,
] );


/**
 * =============== Header mobile ===============
 */

//  header_cta_mobile_heading
Kirki::add_field( 'surprise_careers', [
	'type'     => 'custom',
	'settings' => 'header_cta_mobile_heading',
	'section'  => 'section_header_mobile',
	'default'  => '<h3 style="padding:15px 10px; background:#fff; margin:0;">' . __( 'CTA button', 'surprise' ) . '</h3>',
	'priority' => 10,
] );

//  header_cta_mobile_url
Kirki::add_field( 'surprise_careers', [
	'type'        => 'link',
	'settings'    => 'header_cta_mobile_url',
	'label'       => __( 'URL', 'surprise' ),
	'section'     => 'section_header_mobile',
	'description' => 'Leave URL and Text blank to disable CTA button',
	'priority'    => 20,
] );

//  header_cta_mobile_text
Kirki::add_field( 'surprise_careers', [
	'type'            => 'text',
	'settings'        => 'header_cta_mobile_text',
	'label'           => __( 'Text', 'surprise' ),
	'section'         => 'section_header_mobile',
	'priority'        => 30,
	'partial_refresh' => [
		'header_cta_mobile_text' => [
			'selector'        => '.header__navbar > a',
			'render_callback' => function () {
				return get_option( 'header_cta_mobile_text' );
			}
		]
	]
] );

//  header_cta_mobile_target
Kirki::add_field( 'surprise_careers', [
	'type'     => 'toggle',
	'settings' => 'header_cta_mobile_target',
	'label'    => __( 'Open in new tab', 'surprise' ),
	'section'  => 'section_header_mobile',
	'priority' => 40,
] );

//  header_banner_heading
Kirki::add_field( 'surprise_careers', [
	'type'     => 'custom',
	'settings' => 'header_banner_heading',
	'section'  => 'section_header_mobile',
	'default'  => '<h3 style="padding:15px 10px; background:#fff; margin:30px 0 0 0;">' . __( 'Banner', 'surprise' ) . '</h3>',
	'priority' => 50,
] );

//  header_banner_text
Kirki::add_field( 'surprise_careers', [
	'type'            => 'text',
	'settings'        => 'header_banner_text',
	'label'           => __( 'Text', 'surprise' ),
	'section'         => 'section_header_mobile',
	'description'     => 'Leave blank to disable banner',
	'priority'        => 60,
	'partial_refresh' => [
		'header_banner_text' => [
			'selector'        => '.header__banner > p',
			'render_callback' => function () {
				return get_option( 'header_banner_text' );
			}
		]
	]
] );


/**
 * =============== Footer ===============
 */

//  footer_contacts_line_1
Kirki::add_field( 'surprise_careers', [
	'type'            => 'text',
	'settings'        => 'footer_contacts_line_1',
	'label'           => esc_html__( 'Contacts line 1', 'surprise' ),
	'section'         => 'section_footer',
	'partial_refresh' => [
		'footer_contacts_line_1' => [
			'selector'        => '.footer__contacts-line-1',
			'render_callback' => function () {
				return get_option( 'footer_contacts_line_1' );
			}
		]
	]
] );

//  footer_contacts_line_2
Kirki::add_field( 'surprise_careers', [
	'type'            => 'text',
	'settings'        => 'footer_contacts_line_2',
	'label'           => esc_html__( 'Contacts line 2', 'surprise' ),
	'section'         => 'section_footer',
	'partial_refresh' => [
		'footer_contacts_line_2' => [
			'selector'        => '.footer__contacts-line-2',
			'render_callback' => function () {
				return get_option( 'footer_contacts_line_2' );
			}
		]
	]
] );

//  footer_copyrights
Kirki::add_field( 'surprise_careers', [
	'type'            => 'text',
	'settings'        => 'footer_copyrights',
	'label'           => esc_html__( 'Copyrights', 'surprise' ),
	'section'         => 'section_footer',
	'partial_refresh' => [
		'footer_copyrights' => [
			'selector'        => '#copyrights p',
			'render_callback' => function () {
				return get_option( 'footer_copyrights' );
			}
		]
	]
] );

//  repeater_social_links
Kirki::add_field( 'surprise_careers', [
	'type'         => 'repeater',
	'label'        => esc_html__( 'Social links', 'surprise' ),
	'section'      => 'section_footer',
	'priority'     => 10,
	'row_label'    => [
		'type'  => 'text',
		'value' => esc_html__( 'Link item', 'surprise' ),
	],
	'button_label' => esc_html__( 'Add social link', 'surprise' ),
	'settings'     => 'repeater_social_links',
	'fields'       => [
		'icon'     => [
			'type'    => 'image',
			'label'   => esc_html__( 'SVG Icon', 'surprise' ),
			'choices' => [
				'save_as' => 'array',
			],
		],
		'link_url' => [
			'type'  => 'link',
			'label' => esc_html__( 'Link URL', 'surprise' ),
		],
	],
] );


/**
 * =============== App Store & Play Market buttons settings ===============
 */

//  app_store_link
Kirki::add_field( 'surprise_careers', [
	'type'     => 'link',
	'settings' => 'app_store_link',
	'label'    => __( 'App Store button URL', 'surprise' ),
	'section'  => 'section_app_buttons',
] );

//  play_market_link
Kirki::add_field( 'surprise_careers', [
	'type'     => 'link',
	'settings' => 'play_market_link',
	'label'    => __( 'Play Market button URL', 'surprise' ),
	'section'  => 'section_app_buttons',
] );

//  app_buttons_target
Kirki::add_field( 'surprise_careers', [
	'type'     => 'toggle',
	'settings' => 'app_buttons_target',
	'label'    => __( 'Open in new tab', 'surprise' ),
	'section'  => 'section_app_buttons',
	'default'  => '0',
] );


/**
 * =============== Custom JS Codes ===============
 */

//  before_head_end
Kirki::add_field( 'surprise_careers', [
	'type'     => 'code',
	'settings' => 'before_head_end',
	'label'    => __( 'Before </head> tag', 'surprise' ),
	'section'  => 'section_custom_codes',
	'choices'  => [
		'language' => 'javascript',
	],
] );

//  after_body_start
Kirki::add_field( 'surprise_careers', [
	'type'     => 'code',
	'settings' => 'after_body_start',
	'label'    => __( 'After <body> tag', 'surprise' ),
	'section'  => 'section_custom_codes',
	'choices'  => [
		'language' => 'javascript',
	],
] );

//  before_body_end
Kirki::add_field( 'surprise_careers', [
	'type'     => 'code',
	'settings' => 'before_body_end',
	'label'    => __( 'Before </body> tag', 'surprise' ),
	'section'  => 'section_custom_codes',
	'choices'  => [
		'language' => 'javascript',
	],
] );