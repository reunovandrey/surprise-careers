<?php

/**
 * Template part for displaying sticky posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Surprise
 * @since Surprise 1.0
 */

/* Get all Sticky Posts */
$sticky = get_option('sticky_posts');
$args = array(
  'posts_per_page' => 4,
  'post__in' => $sticky,
  'ignore_sticky_posts' => 1
);
$query = new WP_Query($args);
$i = 1;


if ($query->have_posts()) : ?>
  <div class="blog-sticky-grid">
    <?php while ($query->have_posts()) : $query->the_post();
      $primary = ($i == 1) ? 'primary' : 'secondary';
      $title_class = ($i == 1) ? 'h2' : 'h3';
    ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class('post-sticky blog-article post-sticky-' . $i . ' ' . $primary . ''); ?>>

        <?php get_template_part('template-parts/header/excerpt-header', get_post_format()); ?>

        <div class="entry-content">
          <?php
          surprise_get_categories_list();
          the_title(sprintf('<h2 class="entry-title ' . $title_class . '"><a href="%s">', esc_url(get_permalink())), '</a></h2>');
          if ($i == 1) :
            get_template_part('template-parts/excerpt/excerpt', get_post_format());
          endif;
          surprise_posted_on(); ?>
        </div><!-- .entry-content -->
      </article><!-- #post-${ID} -->
    <?php
      $i++;
    endwhile; ?>
  </div>
<?php endif;
wp_reset_postdata($query);
?>