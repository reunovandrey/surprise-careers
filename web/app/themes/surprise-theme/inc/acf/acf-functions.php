<?php

/**
 * Surprise - ACF Settings
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions
 *
 * @package WordPress
 * @subpackage Surprise
 * @since Surprise 1.0
 *
 */

/**
 * ACF options page
 * https://www.advancedcustomfields.com/resources/acf_add_options_page/
 */
if (function_exists('acf_add_options_page')) {
  // add parent
  $parent = acf_add_options_page(array(
    'page_title'  => 'Surprise Settings',
    'menu_title'  => 'Surprise Settings',
    'menu_slug'    => 'surprise-settings',
    'icon_url'    => 'dashicons-art',
    'redirect'    => true
  ));

  // add sub page
  acf_add_options_sub_page(array(
      'page_title'  => __('General', 'surprise'),
      'menu_title'  => __('General', 'surprise'),
      'parent_slug'  => $parent['menu_slug'],
  ));
  acf_add_options_sub_page(array(
    'page_title'  => __('Header', 'surprise'),
    'menu_title'  => __('Header', 'surprise'),
    'parent_slug'  => $parent['menu_slug'],
  ));
  acf_add_options_sub_page(array(
    'page_title'  => __('Footer', 'surprise'),
    'menu_title'  => __('Footer', 'surprise'),
    'parent_slug'  => $parent['menu_slug'],
  ));
  acf_add_options_sub_page(array(
    'page_title'  => __('Blog', 'surprise'),
    'menu_title'  => __('Blog', 'surprise'),
    'parent_slug'  => $parent['menu_slug'],
  ));
}


/**
 * Create new category for ACF blocks
 */
add_filter('block_categories', 'surprise_acf_block_categories', 10, 2);
function surprise_acf_block_categories($categories, $post)
{
  return array_merge(
    $categories,
    array(
      array(
        'slug' => 'surprise-blocks',
        'title' => __('Surprise blocks', 'surprise'),
        'icon'  => 'layout',
      ),
    )
  );
}


/* Register ACF blocks for gutenberg
* https://www.advancedcustomfields.com/resources/blocks/
* https://www.advancedcustomfields.com/resources/acf_register_block_type/
*/
if (function_exists('acf_register_block_type')) {
  add_action('acf/init', 'surprise_register_acf_block_types');
}

function surprise_register_acf_block_types()
{
  $theme_url = get_stylesheet_directory_uri();
  $thumb_url = $theme_url . '/assets/images/template-blocks/';
  $assets_url = $theme_url . '/assets/public/template-blocks/';

  $blocks = array();
  $blocks_data = array(
    'hero'   => array(
      'title'       => 'Hero',
      'description' => '',
      'block_js'    => false,
      'vendor_js'   => ''
    ),
    'content-img' => array(
      'title'       => 'Content with Image',
      'description' => '',
      'block_js'    => true,
      'vendor_js'   => 'lottie'
    ),
    'carousel' => array(
      'title'       => 'Image Carousel',
      'description' => '',
      'block_js'    => true,
      'vendor_js'      => ''
    ),
    'cta-block' => array(
      'title'       => 'CTA Block',
      'description' => '',
      'block_js'    => false,
      'vendor_js'   => ''
    ),
    'upper-footer' => array(
      'title'       => 'Upper Footer Block',
      'description' => '',
      'block_js'    => false,
      'vendor_js'      => ''
    ),
    'post-content' => array(
      'title'       => 'Post Content Block',
      'description' => '',
      'block_js'    => false,
      'vendor_js'      => ''
    )
  );

  foreach ($blocks_data as $name => $block_data) {
    $vendor_js = $block_data['vendor_js'] ? array($block_data['vendor_js']) : array();

    $blocks[] = array(
      'name'            => ($name),
      'title'            => __($block_data['title'], 'surprise'),
      'description'      => __('This is home page hero block.', 'surprise'),
      // 'enqueue_style' 	=> $assets_url.$name.'.css',
      // 'enqueue_script' 	=> $assets_url.$name.'.js',
      'category'        => 'surprise-blocks',
      'icon'            => 'layout',
      'mode'            => 'edit',
      'supports'        => array('align' => true),
      'render_callback' => 'surprise_render_block_thumbnail',
      'supports'        => array(
        'jsx'     => true,
        'anchor'  => true
      ),
      'example' => [
        'attributes' => [
          'mode' => 'preview',
          'data' => [
            'is_example' => true,
            'thumb' => $thumb_url . $name . '.png'
          ],
        ]
      ],
      'enqueue_assets' => function () use ($name, $assets_url, $block_data, $vendor_js) {
        wp_enqueue_style($name, $assets_url . 'block-' . $name . '.css', array(), '', false);

        if ( $block_data['block_js'] ) {
          wp_enqueue_script($name, $assets_url . 'block-' . $name . '.js', $vendor_js, '', true);
        }

        if ( $block_data['vendor_js']) {
          wp_enqueue_script($block_data['vendor_js']);
        }
      },
      // 'post_types'			=> array('post', 'page'),
    );
  }


  foreach ($blocks as $block) {
    acf_register_block($block);
  }
}


function surprise_render_block_thumbnail($block, $content = '', $is_preview = false, $post_id = 0) {
  if ($is_preview && isset($block['data']['thumb'])) {
    $img = $block['data']['thumb'];
    echo '<img src="' . $img . '">';
  } else {
    $slug = str_replace('acf/', '', $block['name']);
    include(get_theme_file_path("template-blocks/block-" . $slug . ".php"));
  }
}

/**
 * Get ACF Titles with Tags
 */
function surprise_acf_title($class)
{
	$class	= $class ?: 'section-title';
	$title	= get_field('block_title') ?: '';
	$tag		= get_field('tag') ?: 'div';
	$size		= get_field('size') ?: 'h2';

	if ($title) {
		return "<{$tag} class='{$size} {$class}'>{$title}</{$tag}>";
	}
}
