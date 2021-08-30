<?php

if ( ! class_exists( 'Timber' ) ) {
	add_action(
		'admin_notices',
		function () {
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
		}
	);

	return;
}

Timber::$dirname    = array( 'views' );
Timber::$autoescape = false;
Timber::$cache = Timber::$twig_cache = WP_ENV == 'production' ? true : false;

class SDC_Careers_Site extends Timber\Site {

	public function __construct() {
		add_action( 'after_setup_theme', [ $this, 'theme_supports' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'theme_assets' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_assets' ] );
		add_filter( 'timber/context', [ $this, 'add_to_context' ] );
		add_filter( 'timber/twig', [ $this, 'add_to_twig' ] );
		add_filter( 'acf/settings/save_json', [ $this, 'surprise_acf_json_save' ] );
		add_filter( 'acf/settings/load_json', [ $this, 'surprise_acf_json_load' ] );
		add_filter( 'body_class', [ $this, 'surprise_body_class' ] );

		parent::__construct();
	}

	public function theme_supports() {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);
		add_theme_support( 'menus' );

		register_nav_menus(
			array(
				'primary' => __( 'Primary menu', 'surprise' ),
				'footer'  => __( 'Footer menu', 'surprise' ),
			)
		);

		add_theme_support( 'customize-selective-refresh-widgets' );

	    add_theme_support( 'wp-block-styles' );
		add_theme_support( 'editor-styles' );
		add_editor_style( 'assets/public/editor-styles.css');
	}

	public function add_to_twig( $twig ) {
		if ( function_exists( 'd' ) ) {
			$twig->addFilter( new Timber\Twig_Filter( 'd', 'd' ) );
		}

		return $twig;
	}

	public function theme_assets() {
		wp_enqueue_style('swiper', '//unpkg.com/swiper/swiper-bundle.min.css');
		wp_enqueue_style('tomselect', get_template_directory_uri() . '/assets/vendor/tom-select/tom-select.css');
		wp_enqueue_script('swiper', '//unpkg.com/swiper/swiper-bundle.min.js', [], null, true);
		wp_enqueue_script('masonry', '//unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js', [], null, true);
		wp_enqueue_script('isotope', '//unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js', [], null, true);

		wp_enqueue_script('tomselect', '//cdn.jsdelivr.net/npm/tom-select@1.7.7/dist/js/tom-select.complete.min.js', [], null, true);
		wp_enqueue_script('scripts', get_template_directory_uri() . '/assets/js/theme-scripts.js', [], wp_get_theme()->get( 'Version' ), true);
		wp_enqueue_script('lottie', get_template_directory_uri() . '/assets/vendor/lottie/lottie.js', [], wp_get_theme()->get( 'Version' ), true);

		if(get_page_template_slug() == 'elementor_canvas'){
			wp_enqueue_style('surprise-elementor', get_template_directory_uri() . '/assets/public/elementor-styles.css');
		}

	}

	public function admin_assets() {
		wp_enqueue_style('swiper', '//unpkg.com/swiper/swiper-bundle.min.css');

	    wp_enqueue_script('lottie', get_template_directory_uri() . '/assets/vendor/lottie/lottie.js', [], wp_get_theme()->get( 'Version' ));
		wp_enqueue_script('swiper', '//unpkg.com/swiper/swiper-bundle.min.js', [], null);
	}

	public function get_social_icons() {
		$social_icons = get_option('repeater_social_links');
		$result = [];
		foreach ($social_icons as $icon) {
			$result[] = [
				'icon_source' => file_get_contents( wp_get_attachment_url( $icon['icon'] ) ),
				'link_url' => $icon['link_url']
			];
		}
		return $result;
	}

	public function add_to_context( $context ) {
		global $is_iphone;

		$context['primary_menu'] = new Timber\Menu('primary');
		$context['footer_menu'] = new Timber\Menu('footer');

		$context['user_device'] = [
			'is_mobile' => wp_is_mobile(),
			'is_iphone' => $is_iphone,
		];

		$context['header_options'] = [
			'cta_mobile' => [
				'text' => get_option('header_cta_mobile_text'),
				'url' => get_option('header_cta_mobile_url'),
				'target' => get_option('header_cta_mobile_target') == 1 ? '_blank' : '_self'
			],
			'banner_mobile' => get_option('header_banner_text'),
			'cta_desktop' => [
				'text' => get_option('header_cta_desktop_text'),
				'url' => get_option('header_cta_desktop_url'),
				'target' => get_option('header_cta_desktop_target') == 1 ? '_blank' : '_self'
			],
			'sign_in' => [
				'text' => get_option('header_sign_in_text'),
				'url' => get_option('header_sign_in_link'),
				'target' => get_option('header_sign_in_target') == 1 ? '_blank' : '_self'
			]
		];

		$context['app_buttons'] = [
			'app_store' => get_option('app_store_link'),
			'play_market' => get_option('play_market_link'),
			'target' => get_option('app_buttons_target') ? '_blank' : '_self'
		];

		$context['footer_options'] = [
			'copyrights' => get_option('footer_copyrights'),
			'contacts_line_1' => get_option('footer_contacts_line_1'),
			'contacts_line_2' => get_option('footer_contacts_line_2'),
			'social_icons' => $this->get_social_icons()
		];

		$context['logo_clickable'] = ! is_front_page() || ! is_home();

		return $context;
	}

	public function surprise_acf_json_save( $path ) {
		$path = get_stylesheet_directory() . '/tools/acf-json';

		return $path;
	}

	public function surprise_acf_json_load( $path ) {

		return $path;
	}

	public function surprise_body_class($classes){



		if(get_option('header_banner_text') !== ''){
			$classes[] = 'has-mobile-banner';
		}

		return $classes;
	}

}

new SDC_Careers_Site();


require_once get_template_directory() . '/inc/post-types/job.php';
require_once get_template_directory() . '/inc/taxonomies/technologies.php';
require_once get_template_directory() . '/inc/taxonomies/locations.php';
require_once get_template_directory() . '/inc/taxonomies/benefits.php';

/**
 * Contact form 7 customizations
 */
// general CF7 functions
require_once get_template_directory() . '/inc/contact-form-7/functions.php';
// custom field "Joblist"
require_once get_template_directory() . '/inc/contact-form-7/field-joblist.php';


/**
 * Gutenberg
 */
require_once get_template_directory() . '/inc/gutenberg/gutenberg.php';


/**
 * REST tweaks
 */
require_once (get_template_directory() . '/inc/rest-tweaks.php');


/**
 * Customizer
 */
//  Kirki framework
require_once (get_template_directory() . '/inc/kirki/kirki.php');
//  Customizer options for current Web App
require_once (get_template_directory() . '/inc/customizer-options.php');