<?php
$social_links = get_field('footer_social_links', 'option');

if (!isset($social_links)) return false; ?>
<div class="site-footer-socials">
  <div class="site-footer-social-list">
    <?php
    foreach ($social_links as $item) :
      if ( ! isset( $item['link']['url'] ) ) return false;

      $link   = $item['link'];
      $url    = $link['url'];
      $label  = $link['title'];
      $target = $link['target'] ?: '_self';      
      $icon   = surprise_get_icon($item['icon']);
    ?>
      <div class="site-footer-social-item">
        <a href="<?php echo $url; ?>" class="site-footer-social-link" aria-label="<?php echo $title; ?>" target="<?php echo $target; ?>">
          <?php echo $icon; ?>
        </a>
      </div>
    <?php
    endforeach;
    ?>
  </div>
</div>