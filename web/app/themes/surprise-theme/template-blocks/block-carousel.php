<?php

/**
 * Block: Carousel
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$blockName = 'carousel';
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

$images = get_field('images');

$wrapp_settings = array(
  get_field('padding_top'),
  get_field('padding_bottom')
) ?: '';

$header_align     = get_field('header_align') ?? '';
$subheading_type  = get_field('subheading_style') ?? '';

?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($classes); ?> section-main">
  <div class="section-wrapper <?php echo implode(' ', $wrapp_settings); ?>">
    <div class="container">
      <div class="section-inner">
        <?php if ($title || $subheading) : ?>
          <div class="section-header <?php echo $header_align; ?>">
            <?php echo $title; ?>
            <?php if ($subheading) : ?>
              <div class="section-description <?php echo $subheading_type; ?>"><?php echo $subheading; ?></div>
            <?php endif; ?>
          </div><!-- .section-header -->
        <?php endif; ?>

        <div class="section-content">
          <?php if ($images) : ?>
            <div class="sdc-carousel">
              <div class="sdc-carousel-inner">
                <?php foreach ($images as $index => $image) :
                  $active = ($index === 0) ? 'active' : '';
                  ?>
                  <div class="sdc-carousel-item <?php echo esc_attr( $active ); ?>" data-slide="<?php echo $index; ?>">
                    <div class="sdc-carousel-item-inner">
                      <img src="<?php echo $image['url']; ?>" alt="">
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>