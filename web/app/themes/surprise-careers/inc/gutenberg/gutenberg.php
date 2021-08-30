<?php

/**
 * Color Palette
 */
class SDC_Blocks
{
	public function __construct()
	{
		add_action('after_setup_theme', array($this, 'surprise_custom_gutenberg_color_palette'));
		add_action('after_setup_theme', array($this, 'surprise_enable_gutenberg_custom_spacing'));
		add_action('enqueue_block_editor_assets', array($this, 'surprise_gutenberg_enqueue'));
	}
	/**
	 * Singleton pattern
	 */
	public static function getInstance()
	{
		static $instance;
		if (!isset($instance)) {
			$instance = new self();
		}
		return $instance;
	}

	// Template Colors
	protected static function colors()
	{
		$colors = array(
			[
				'name'  => esc_html__('Brand Blue', 'surprise'),
				'slug'  => 'brand_blue',
				'color' => '#147dfa',
			],
			[
				'name'  => esc_html__('Alice Blue', 'surprise'),
				'slug'  => 'alice_blue',
				'color' => '#F4F7FB',
			],
			[
				'name'  => esc_html__('White', 'surprise'),
				'slug'  => 'white',
				'color' => '#ffffff',
			],
			[
				'name'  => esc_html__('Black', 'surprise'),
				'slug'  => 'black',
				'color' => '#000000',
			],
			[
				'name'  => esc_html__('Midnight', 'surprise'),
				'slug'  => 'midnight',
				'color' => '#17191B',
			],
			[
				'name'  => esc_html__('Rhino', 'surprise'),
				'slug'  => 'rhino',
				'color' => '#414A55',
			],
			[
				'name'  => esc_html__('Midgrey', 'surprise'),
				'slug'  => 'midgrey',
				'color' => '#646F79',
			],
			[
				'name'  => esc_html__('Lightgrey', 'surprise'),
				'slug'  => 'lightgrey',
				'color' => '#7A869A',
			],
			[
				'name'  => esc_html__('Lightgrey 1', 'surprise'),
				'slug'  => 'lightgrey-1',
				'color' => '#DCE5EC',
			],
		);
		return $colors;
	}

	// Set Custom Color Palette
	public static function surprise_custom_gutenberg_color_palette()
	{
		// Disable Custom Colors
		add_theme_support('disable-custom-colors');
		// Editor Color Palette
		add_theme_support(
			'editor-color-palette',
			self::colors()
		);
	}

	// Unable Custom Spacing for Blocks
	public static function surprise_enable_gutenberg_custom_spacing()
	{
		add_theme_support('custom-spacing');
	}

	// Gutenberg Styles & Scripts
	public static function surprise_gutenberg_enqueue()
	{
		// wp_enqueue_script(
		// 	'surprise-myguten-script',
		// 	get_template_directory_uri() . '/includes/gutenberg/blocks.js',
		// 	array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' )
		// );
		wp_enqueue_style('surprise-gutenberg-style', get_template_directory_uri() . '/inc/gutenberg/gutenberg.min.css');
	}
}

SDC_Blocks::getInstance();
