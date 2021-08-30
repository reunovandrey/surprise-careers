<?php

/**
 * Block: Post Content
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$blockName = 'post-content';
// Create id attribute allowing for custom "anchor" value.
$id = $blockName . '-' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}

// Create class attribute allowing for custom "classes" and "align" values.
$classes = "section-{$blockName}";
if (!empty($block['className'])) {
  $classes .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
  $classes .= ' align' . $block['align'];
}

// Load values and assing defaults.
$allowed_blocks = array('core/heading', 'core/paragraph', 'core/image', 'core/quote', 'core/list')


?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($classes); ?> section-main">
  <div class="section-wrapper">
    <div class="container">
      <div class="post-content-inner">
        <InnerBlocks allowedBlocks="<?php echo esc_attr(wp_json_encode($allowed_blocks)); ?>" />
      </div>
    </div>
  </div>
</section>