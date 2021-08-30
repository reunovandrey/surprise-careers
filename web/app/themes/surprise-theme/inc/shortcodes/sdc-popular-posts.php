<?php

/**
 * Show Most Popular Posts
 */
if (!function_exists('sdc_popular_posts')) {
  function sdc_popular_posts($atts)
  {
    // Shortcode Attributes
    $atts = shortcode_atts(array(
      'count' => 5,
    ), $atts);
    $args = array(
      'posts_per_page' => $atts['count'],
      'meta_key' => 'sdc_post_views_count',
      'orderby' => 'meta_value_num',
      'order' => 'DESC'
    );

    $query = new WP_Query($args);
    if ($query->have_posts()) :
      ob_start();
?>
      <ul class="popular-posts-list">
        <?php while ($query->have_posts()) : $query->the_post(); ?>
          <li class="popular-posts-item">
            <?php
            surprise_get_categories_list();
            the_title('<h4 class="post-title h5">', '</h4>');
            surprise_posted_on();
            ?>
          </li>
        <?php endwhile; ?>
      </ul>
<?php
      return ob_get_clean();
    endif;
    wp_reset_postdata($query);
  }
}

function sdc_popular_posts_init() {
  add_shortcode('sdc-popular-posts', 'sdc_popular_posts');
}

add_action( 'init', 'sdc_popular_posts_init');