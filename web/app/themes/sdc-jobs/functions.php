<?php

if (!class_exists('Timber')) {

    add_action(
        'admin_notices',
        function () {
            echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url(admin_url('plugins.php#timber')) . '">' . esc_url(admin_url('plugins.php')) . '</a></p></div>';
        }
    );

    return;
}


Timber::$dirname = array('views');

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;

/**
 * By default, Timber cache is disabled for development environment.
 */
Timber::$cache = WP_ENV == 'production' ? true : false;
Timber::$twig_cache = WP_ENV == 'production' ? true : false;

class SDC_Jobs_Site extends Timber\Site
{
    /** Add timber support. */
    public function __construct()
    {
        add_action('after_setup_theme', array($this, 'theme_supports'));
        add_action('wp_enqueue_scripts', array($this, 'theme_assets'));
        add_filter('timber/context', array($this, 'add_to_context'));
        add_filter('timber/twig', array($this, 'add_to_twig'));
//        add_action('init', array($this, 'register_post_types'));
//        add_action('init', array($this, 'register_taxonomies'));
        parent::__construct();
    }

    public function theme_supports()
    {
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

	    /**
	     * Add theme support for selective refresh for widgets.
	     */
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

	    /**
	     * Add support for Block Styles.
	     */
//	    add_theme_support( 'wp-block-styles' );

	    /**
	     * Add support for editor styles.
	     */
	    add_theme_support('editor-styles');
    }

    public function add_to_twig($twig){
	    $twig->addFilter( new Timber\Twig_Filter( 'd', 'd' ) );

    	return $twig;
    }

    public function theme_assets(){
//	    wp_enqueue_style( 'theme-css', get_template_directory_uri() . '/assets/css/theme-styles.css' );
	    wp_enqueue_script('scripts', get_template_directory_uri() . '/assets/js/theme-scripts.js', ['jquery']);

	    wp_localize_script( 'scripts', 'ajax_params', array(
		    'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php',
	    ) );
    }

	public function add_to_context( $context ) {
    	$context['primary_menu'] = new Timber\Menu('primary_menu');
    	$context['footer_menu'] = new Timber\Menu('footer_menu');

	    return $context;
    }
}

new SDC_Jobs_Site();

if ( ! function_exists( 'surprise_custom_footer_logo' ) ) {
	function surprise_custom_footer_logo() {

		$footer_logo      = get_field( 'footer_logo', 'options' );
		$custom_logo_link = get_field( 'custom_logo_link', 'options' );
		if ( ! $footer_logo ) {
			return;
		}

		if ( ( is_front_page() || is_home() ) && ! $custom_logo_link ) :
			$html = sprintf(
				'<span class="footer-logo-link">' . wp_get_attachment_image( $footer_logo['id'], 'full', false, array(
					'class'  => 'footer-logo',
					'width'  => '132',
					'height' => '22',
				) ) . '</span>'
			);
		else :
			$html = sprintf(
				'<a href="%1$s" class="footer-logo-link" rel="home" itemprop="url" target="%3$s">%2$s</a>',
				esc_url( ( isset( $custom_logo_link ) && ! empty( $custom_logo_link ) ) ? $custom_logo_link['url'] : home_url( '/' ) ),
				wp_get_attachment_image( $footer_logo['id'], 'full', false, array(
					'class'  => 'footer-logo',
					'width'  => '132',
					'height' => '22',
				) ),
				( isset( $custom_logo_link ) && ! empty( $custom_logo_link ) ) ? $custom_logo_link['target'] : '_self'
			);
		endif;

		return $html;
	}
}

/**
 * Customize
 */

require_once(get_template_directory() . '/inc/classes/SDC_Customize.php');
new SDC_Customize();

function surprise_customize_preview_init() {
	wp_enqueue_script(
		'surprise-customize-preview',
		get_theme_file_uri( '/assets/js/customize-preview.js' ),
		array( 'customize-preview', 'customize-selective-refresh', 'jquery' ),
		wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'customize_preview_init', 'surprise_customize_preview_init' );

/**
 * Add custom post-types
 */
require_once get_template_directory(  ) . '/inc/post-types/jobs.php';

/**
 * Register custom taxonomies
 */
require_once get_template_directory() . '/inc/taxonomies/technologies.php';
require_once get_template_directory() . '/inc/taxonomies/locations.php';

/**
 * Add custom fields
 */
require_once get_template_directory() . '/inc/fields/job-fields.php';


