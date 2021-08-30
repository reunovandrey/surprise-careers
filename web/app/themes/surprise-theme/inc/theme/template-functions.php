<?php

/**
 * Functions which enhance the theme by hooking into Wordpress
 *
 * @package WordPress
 * @subpackage Surprise
 * @since Surprise 1.0
 */

if ( ! function_exists('surprise_mime_types') ) {
	/*
	* Allow svg files
	*/
	function surprise_mime_types($mimes) {
		$mimes['svg'] = 'image/svg+xml';
		$mimes['json'] = 'application/json';
		$mimes['json'] = 'text/plain'; 
		return $mimes;
	}
	add_filter('upload_mimes', 'surprise_mime_types');
}

if ( ! function_exists('surprise_custom_logo') ) {
	/**
	 * Override custom logo function
	 */	
	function surprise_custom_logo()	{
		$custom_logo_id = get_theme_mod('custom_logo');
		$custom_logo_link = get_field('custom_logo_link', 'options');
		if ( ( is_front_page() || is_home() ) && ! $custom_logo_link ) :
			$html = sprintf(
				'<span class="custom-logo-link">' . wp_get_attachment_image($custom_logo_id, 'full', false, 	array(
					'class'   => 'custom-logo',
					'width'		=> '141',
					'height'	=> '25',
				)) . '</span>'
			);
		else :
			$html = sprintf(
				'<a href="%1$s" class="custom-logo-link" rel="home" itemprop="url" target="%3$s">%2$s</a>',
				esc_url( ( isset( $custom_logo_link ) && ! empty( $custom_logo_link ) ) ? $custom_logo_link['url'] : home_url( '/' ) ),
				wp_get_attachment_image($custom_logo_id, 'full', false, array(
					'class'		=> 'custom-logo',
					'width'		=> '141',
					'height'	=> '25',
				)),
				( isset( $custom_logo_link ) && ! empty( $custom_logo_link ) ) ? $custom_logo_link['target'] : '_self'
			);
		endif;

		return $html;
	}
	add_filter('get_custom_logo',  'surprise_custom_logo');
}

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

if ( ! function_exists('surprise_remove_extra_image_sizes') ) {
	/**
	 * Remove Default Images Size
	 */
	function surprise_remove_extra_image_sizes()
	{
		foreach (get_intermediate_image_sizes() as $size) {
			if (!in_array($size, array('thumbnail', 'medium', 'medium_large', 'large'))) {
				remove_image_size($size);
			}
		}
	}
	add_action('init', 'surprise_remove_extra_image_sizes');
}

if ( ! function_exists('surprise_is_mobile') ) {
	/**
	 * Check if the site is viewed from a mobile
	 */
	function surprise_is_mobile()
	{
		$useragent = $_SERVER['HTTP_USER_AGENT'];
		// add '|android|ipad|playbook|silk' to the first regular to define the tablet as well
		if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|	fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m	(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|	link)|vodafone|wap|windows ce|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50	[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as	(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|	capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|	ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|	gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|	a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja	(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|	\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo	(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|	1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|	\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|	i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|	0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v 	)|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|	m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|	60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', 	substr($useragent, 0, 4))) :
			return true;
		else :
			return false;
		endif;
	}
}

if ( ! function_exists('surprise_get_icon') ) {
	/**
	 * Print the next and previous posts navigation.
	 *
	 * @since Surprise 1.0
	 *
	 * @return string
	 */
	function surprise_get_icon($icon) {
		// Check if icon is defined
		if( ! isset( $icon ) ) return false;
		
		// If mime type is svg+xml return file content
		if ( get_post_mime_type($icon) == 'image/svg+xml') :
			$icon = file_get_contents( get_attached_file( $icon ) );
		else :
			// Return image tag
			$icon = wp_get_attachment_image( $icon, array(30, 30) );
		endif;

		return $icon;
	}
}

// SHARE POSTS BUTTONS
if ( ! function_exists( 'surprise_share_post' ) ) {
	/**
	 * Share the post on social networks
	 *
	 * @since Surprise 1.0
	 *
	 * @return void 
	 */
	function surprise_share_post() {
		$url = urlencode(get_the_permalink());
		$title = urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8'));
		$media = urlencode(get_the_post_thumbnail_url(get_the_ID(), 'full'));
	
		include(locate_template('template-parts/blog/post-share.php', false, false));
	}
}



if ( ! function_exists( 'surprise_widgets_init' )) {
	/**
 	 * Register widget area.
 	 *
 	 * @since Surprise 1.0
 	 *
 	 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 	 *
 	 * @return void
 	 */
	function surprise_widgets_init() {

		register_sidebar(
			array(
				'name'          => esc_html__( 'Blog', 'surprise' ),
				'id'            => 'sidebar-1',
				'description'   => esc_html__( 'Add widgets here to appear in your blog page.', 'surprise' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h5 class="widget-title">',
				'after_title'   => '</h5>',
			)
		);
	}
	add_action( 'widgets_init', 'surprise_widgets_init' );
}

if ( ! function_exists( 'surprise_editor_capabilities' ) ) {
	// add editor the privilege to edit theme options
	function surprise_editor_capabilities() {
		$role_object = get_role( 'editor' );

		// add $cap capability to this role object
		$role_object->add_cap( 'edit_theme_options' );
	}
	if (is_admin() && !get_role( 'editor' )->has_cap('edit_theme_options')) {
		add_action('admin_init', 'surprise_editor_capabilities');
	}	
}

// if ( ! function_exist( 'surprise_preload_fonts' ) ) {
// 	function surprise_preload_fonts() {

// 	}
// }


/**
 * Register Surprise Shortcode
 */
// require_once get_template_directory(  ) . '/inc/shortcodes/sdc-popular-posts.php';

/**
 * Register Surprise Widgets
 */
require_once get_template_directory(  ) . '/inc/classes/SDC_Widget_Social_Icons.php';
require_once get_template_directory(  ) . '/inc/classes/SDC_Widget_Popular_Posts.php';