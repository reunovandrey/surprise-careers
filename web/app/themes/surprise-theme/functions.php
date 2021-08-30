<?php
/**
 * Functions which enhance the theme by hooking into Wordpress
 *
 * @package WordPress
 * @subpackage Surprise
 * @since Surprise 1.0
 */

/**
 * Assign the Surprise version to a var
 */
$theme            = wp_get_theme( 'surprise' );
$surprise_version = $theme['Version'];

/**
 * Init & registration actions for a theme
 */
add_action( 'after_setup_theme', 'surprise_setup' );

if ( ! function_exists ('surprise_setup') ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @since Surprise 1.0
	 *
	 * @return void
	 */
	function surprise_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 */
		load_textdomain( 'surprise', get_stylesheet_directory(  ) . '/languages' );
		/*
		 * Let WordPress manage the document title.
		 * This theme does not use a hard-coded <title> tag in the document head,
		 * WordPress will provide it for us.
		 */
		add_theme_support( 'title-tag' );
		/*
		 * Enable support for Post Thumbnails on posts.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails', array('post') );

		register_nav_menus(
			array(
				'primary' => __( 'Primary menu', 'surprise' ),
				'footer'  => __( 'Footer menu', 'surprise' ),
			)
		);
		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'comment-form',
			'comment-list',
			'search-form',
			'caption',
		) );
		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support('custom-logo', array(
			'flex-width'  => true,
			'flex-height' => true,
		));
		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );
		// Add support for editor styles.
		add_theme_support('editor-styles');
	}
endif;

/**
 * Register scripts & styles
 */
add_action( 'wp_enqueue_scripts', 'surprise_enqueue_scripts' );
function surprise_enqueue_scripts($surprise_version) {

	global $wp_query;
	$theme            = wp_get_theme( 'surprise' );
	$surprise_version = $theme['Version'];

	/**
	 * Register Scripts
	 */
	// Lottie Animation
	wp_register_script('lottie', get_template_directory_uri() . '/assets/vendor/lottie/lottie.js', array(), $surprise_version, true);
	// Register Theme Script
	wp_register_script( 'theme-js', get_template_directory_uri() . '/assets/public/theme.min.js', array(), $surprise_version, true );
	// Loadmore Posts Plugin
	wp_register_script( 'theme-loadmore', get_template_directory_uri(). '/assets/public/plugins/sdc-loadmore.js', array('theme-js'), $surprise_version, true);

	// Loclize Theme Script
	wp_localize_script( 'theme-js', 'surprise_ajax_params', array(
		'ajaxurl' 			=> site_url() . '/wp-admin/admin-ajax.php',
		'current_page'	=> $wp_query->query_vars['paged'] ? : 1,
		'first_page'		=> get_pagenum_link(1)
	) );

	wp_register_style('block-upper-footer', get_template_directory_uri() . '/assets/public/template-blocks/block-upper-footer.css', $surprise_version);


	wp_enqueue_style( 'theme-css', get_template_directory_uri() . '/assets/public/theme.min.css', $surprise_version );

	if (is_singular('post')) {
		wp_enqueue_style('block-upper-footer');
		wp_enqueue_style('post_css', get_template_directory_uri() . '/assets/public/pages/post.css', $surprise_version);
	}
	if (is_home()) {
		wp_enqueue_style('block-upper-footer');
		wp_enqueue_style('home_css', get_template_directory_uri() . '/assets/public/pages/home.css', $surprise_version);
		wp_enqueue_script('theme-loadmore');
	}
	if (is_archive() || is_category() || is_tag() || is_search()) {
		wp_enqueue_style('block-upper-footer');
		wp_enqueue_style('archive_css', get_template_directory_uri() . '/assets/public/pages/archive.css', $surprise_version);
	}
	if (is_archive() || is_category() || is_tag()) {
		wp_enqueue_script('theme-loadmore');
	}

	wp_enqueue_script( 'theme-js' );
	wp_deregister_script( 'wp-polyfill' );
}

/**
 * Include in the template cleanup Wordpress features
 */
require_once get_template_directory(  ) . '/inc/general/wp-cleanup.php';

/**
 * Includes in the template the necessary files that extended the basic functionality of theme
 */
require_once get_template_directory(  ) . '/inc/theme/template-functions.php';
require_once get_template_directory(  ) . '/inc/theme/template-blog.php';
require_once get_template_directory(  ) . '/inc/theme/template-ajax.php';
require_once get_template_directory(  ) . '/inc/theme/scripts.php';

/**
 * Include ACF
 */
require_once get_template_directory(  ) . '/inc/acf/acf-functions.php';
require_once get_template_directory(  ) . '/inc/acf/acf-preset-blocks.php';

/**
 * Gutenberg
 */
require_once get_template_directory(  ) . '/inc/gutenberg/gutenberg.php';