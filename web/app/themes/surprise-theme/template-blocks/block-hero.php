<?php

/**
 * Block: Hero.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$blockName = 'hero';
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
$title      = surprise_acf_title('page-title');
$subheading = get_field('subheading');

$wrapp_settings = array(
  get_field('padding_top'),
  get_field('padding_bottom')
) ?: '';

$header_align     = get_field('header_align') ?: '';
$subheading_type  = get_field('subheading_style') ?: '';

global $is_iphone;

?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($classes); ?> section-main">
  <div class="section-wrapper <?php echo implode(' ', $wrapp_settings); ?>">
    <div class="container">
      <div class="section-content">
        <?php if ($title) : ?>
          <div class="section-header <?php echo $header_align; ?>">
            <?php echo $title; ?>
            <?php if ($subheading) : ?>
              <div class="section-description <?php echo $subheading_type; ?>"><?php echo $subheading; ?></div>
            <?php endif; ?>
          </div><!-- .section-header -->
        <?php endif; ?>

        <?php if (have_rows('content')) : ?>
          <div class="section-inner">
            <?php while (have_rows('content')) : the_row(); ?>
              <?php if (get_row_layout() == 'cta') :
                $btn = get_sub_field('button_cta');
              ?>
                <div class="hero-cta">
                  <button class="bttn bttn-primary bttn-lg" type="button" data-modal="">
                    <span class="bttn-label"><?php echo $btn; ?></span>
                    <svg width="1em" height="1em" viewBox="0 0 24 24" class="icon-chevron" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M7.18971 3.43934C7.77549 2.85355 8.72524 2.85355 9.31103 3.43934L16.811 10.9393C17.3968 11.5251 17.3968 12.4749 16.811 13.0607L9.31102 20.5607C8.72524 21.1464 7.77549 21.1464 7.1897 20.5607C6.60392 19.9749 6.60392 19.0251 7.1897 18.4393L13.629 12L7.18971 5.56066C6.60392 4.97487 6.60392 4.02513 7.18971 3.43934Z" fill="currentColor"></path>
                    </svg>
                  </button>
                </div>
              <?php elseif (get_row_layout() == 'image') :
                $image_m = get_sub_field('image_main');
                $image_l = get_sub_field('image_left');
                $image_r = get_sub_field('image_right');
              ?>
                <div class="hero-images">
                  <?php
                  echo wp_get_attachment_image($image_m, 'full', false, array('class' => 'img img-middle'));
                  if (!wp_is_mobile()) :
                    echo wp_get_attachment_image($image_l, 'full', false, array('class' => 'img img-left'));
                    echo wp_get_attachment_image($image_r, 'full', false, array('class' => 'img img-right'));
                  endif;
                  ?>
                </div>
              <?php elseif (get_row_layout() == 'app_links') :
                $app_store    = get_sub_field('appstore');
                $google_play  = get_sub_field('googleplay');
              ?>
                <div class="hero-app-links">
                  <div class="bttn-group">

                    <?php
                    if (wp_is_mobile() && $is_iphone || !wp_is_mobile()) :
                      if ($app_store) :
                        $app_store_url    = $app_store['url'];
                        $app_store_label  = $app_store['title'];
                        $app_store_target = $app_store['target'] ?: '_self';
                    ?>
                        <div class="bttn-item">
                          <a href="<?php echo $app_store_url; ?>" class="bttn bttn-stroke" aria-label="<?php echo $app_store_label; ?>" $target="<?php echo $app_store_target; ?>">
                            <?php echo file_get_contents(get_template_directory() . '/assets/public/images/svg/app-store.svg'); ?>
                          </a>
                        </div>
                    <?php endif;
                    endif;
                    ?>

                    <?php
                    if (wp_is_mobile() && !$is_iphone || !wp_is_mobile()) :
                      if ($google_play) :
                        $google_play_url    = $google_play['url'];
                        $google_play_label  = $app_store['title'];
                        $google_play_target = $app_store['target'] ?: '_self';
                    ?>
                        <div class="bttn-item">
                          <a href="<?php echo $google_play_url; ?>" class="bttn bttn-stroke" aria-label="<?php echo $google_play_label; ?>" $target="<?php echo $google_play_target; ?>">
                            <?php echo file_get_contents(get_template_directory() . '/assets/public/images/svg/google-play.svg'); ?>
                          </a>
                        </div>
                    <?php endif;
                    endif; ?>
                  </div>
                </div>
              <?php endif; ?>
            <?php endwhile; ?>
          </div>
        <?php endif; ?>

        <InnerBlocks />
      </div>
    </div>
  </div>
</section>