<?php

/**
 * Block: Call to Action
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$blockName = 'upper-footer';
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
$title      = surprise_acf_title('section-title') ?: '<h2 class="section-title h2">Surprise is Loved.</h2>';
$subheading = get_field('subheading') ?: '<p>Install now to find out why.</p>';

$app_store    = get_field('appstore');
$google_play  = get_field('googleplay');

$wrapp_settings = array(
  get_field('padding_top'),
  get_field('padding_bottom')
) ?: '';

$header_align     = get_field('header_align') ?: 'center';
$subheading_type  = get_field('subheading_style') ?? '';

global $is_iphone;

?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($classes); ?> section-main">
  <div class="section-wrapper <?php echo implode(' ', $wrapp_settings); ?>">
    <div class="container">
      <div class="section-inner">
        <?php if ($title) : ?>
          <div class="section-header center">
            <?php echo $title; ?>
            <?php if ($subheading) : ?>
              <div class="section-description <?php echo $subheading_type; ?>"><?php echo $subheading; ?></div>
            <?php endif; ?>
          </div><!-- .section-header -->
        <?php endif; ?>

        <div class="section-content">
          <div class="app-links">
            <div class="bttn-group">
              <?php if (!wp_is_mobile()) : ?>
                <div class="bttn-item">
                  <span><?php echo file_get_contents(get_template_directory() . '/assets/public/images/svg/app-store.svg'); ?></span>
                </div>
                <div class="bttn-item">
                  <span><?php echo file_get_contents(get_template_directory() . '/assets/public/images/svg/google-play.svg'); ?></span>
                </div>
              <?php endif; ?>

              <?php
              if (wp_is_mobile() && $is_iphone) :
                $app_store_url    = $app_store['url'] ?: 'https://apps.apple.com/us/app/surprise-com/id1550065067';
                $app_store_label  = $app_store['title'] ?: 'AppStore';
                $app_store_target = $app_store['target'] ?: '_self';
              ?>
                <div class="bttn-item">
                  <a href="<?php echo $app_store_url; ?>" class="bttn bttn-stroke" aria-label="<?php echo $app_store_label; ?>" $target="<?php echo $app_store_target; ?>">
                    <?php echo file_get_contents(get_template_directory() . '/assets/public/images/svg/app-store.svg'); ?>
                  </a>
                </div>
              <?php endif; ?>

              <?php
              if (wp_is_mobile() && !$is_iphone) :
                $google_play_url    = $google_play['url'] ?: 'https://play.google.com/store/apps/details?id=com.surprise.work.employee';
                $google_play_label  = $app_store['title'] ?: 'GooglePlay';
                $google_play_target = $app_store['target'] ?: '_self';
              ?>
                <div class="bttn-item">
                  <a href="<?php echo $google_play_url; ?>" class="bttn bttn-stroke" aria-label="<?php echo $google_play_label; ?>" $target="<?php echo $google_play_target; ?>">
                    <?php echo file_get_contents(get_template_directory() . '/assets/public/images/svg/google-play.svg'); ?>
                  </a>
                </div>
              <?php endif; ?>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>