<?php

/**
 * Block: Content with Image.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$blockName = 'content-img';
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
$title      = surprise_acf_title('section-title');
$subheading = get_field('subheading');

$image = get_field('image');
$lottie = get_field('lottie');

$wrapp_settings = array(
  get_field('padding_top'),
  get_field('padding_bottom')
) ?: '';

$header_align     = get_field('header_align') ?? '';
$subheading_type  = get_field('subheading_style') ?? '';
$image_position   = get_field('image_position') ?? 'right';
?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($classes); ?> section-main">
  <div class="section-wrapper <?php echo implode(' ', $wrapp_settings); ?>">
    <div class="container">
      <div class="section-inner <?php echo $image_position; ?>">

        <div class="section-inner-content <?php echo $header_align; ?>">
          <?php echo $title ?? ''; ?>
          <div class="section-description <?php echo $subheading_type; ?>">
            <?php echo $subheading ?? ''; ?>
            <InnerBlocks />
          </div>

        </div><!-- .section-inner-content -->


        <?php if ($image || $lottie) : ?>
          <div class="section-inner-image">
            <?php if ($lottie) : ?>
              <div class="lottie" data-animation="<?php echo $lottie['url']; ?>"></div>
            <?php else : ?>
              <div class="img">
                <img src="<?php echo $image['url']; ?>" alt="">
              </div>
            <?php endif; ?>
          </div>
        <?php endif; ?>

      </div>
    </div>
  </div>
</section>