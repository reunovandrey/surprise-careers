<?php

/**
 * Template part for related posts
 *
 *
 * @package WordPress
 * @subpackage Surprise
 * @since Surprise 1.0
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('post-article-card'); ?>>

  <?php get_template_part('template-parts/header/excerpt-header', get_post_format()); ?>

  <div class="entry-content">
    <?php
    surprise_get_categories_list();
    the_title(sprintf('<h2 class="entry-title h3"><a href="%s">', esc_url(get_permalink())), '</a></h2>');
    get_template_part('template-parts/excerpt/excerpt', get_post_format());
    surprise_posted_on(); ?>
  </div><!-- .entry-content -->
</article><!-- #post-${ID} -->