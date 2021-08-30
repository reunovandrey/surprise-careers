<?php

/**
 * Features that improve the functionality of the blog by connecting to WordPress
 *
 * @package WordPress
 * @subpackage Surprise
 * @since Surprise 1.0
 */

if ( ! function_exists( 'surprise_get_categories_list' ) ) {
  /**
	 * Prints a link to a post categories
	 *
	 * @since Surprise 1.0
	 *
	 * @return void
	 */
  function surprise_get_categories_list($post_id= '') {
    // Early exit if not a post.
		if ( 'post' !== get_post_type() ) return;

    if ( has_category() ) {
      echo '<div class="post-categories">';

      // Return an array containig the categories link
      $category_links = array_map( function ( $category ) {
        return sprintf(
          '<a href="%s" class="link link-meta">%s</a>', // Link output template
          esc_url( get_category_link( $category ) ), // Link to the category
          esc_html( $category->name ) // Category name
        );
      }, get_the_category($post_id) );

      echo implode( ', ', $category_links ); // Output links
      echo '</div>';
    }
  }
}

if ( ! function_exists( 'surprise_get_tags_list' ) ) {
  /**
	 * Prints a link to a post tags
	 *
	 * @since Surprise 1.0
	 *
	 * @return void
	 */
  function surprise_get_tags_list() {
    // Early exit if not a post.
		if ( 'post' !== get_post_type() ) return;

    if ( has_tag() ) {
      echo '<div class="post-tags">';
      // Return an array containig the tags link
      $tags_links = array_map( function ( $tag ) {
        return sprintf(
          '<a href="%s" class="link link-meta">%s</a>', // Link output template
          esc_url( get_tag_link( $tag ) ), // Link to the category
          esc_html( $tag->name ) // Category name
        );
      }, get_the_tags() );
      echo '<span class="tags-links">' . esc_html__( 'Tags: ', 'surprise' ) . '</span>';
      echo implode( ', ', $tags_links ); // Output links
      echo '</div>';
    }
  }
}

if ( ! function_exists( 'surprise_posted_by' ) ) {
  /**
	 * Prints HTML with the name of the author of the post
	 *
	 * @since Surprise 1.0
	 *
	 * @return void
	 */
  function surprise_posted_by() {
    echo '<span class="posted-by" rel="author">';
    printf(
      /* translators: %s: Author name. */
      esc_html__( 'By %s', 'surprise' ),
      esc_html( get_the_author() )
    );
    echo '</span>';
  }
}

if ( ! function_exists( 'surprise_posted_on' ) ) {
  /**
	 * Prints HTML with meta information for the current post-date/time.
	 *
	 * @since Surprise 1.0
	 *
	 * @return void
	 */
  function surprise_posted_on($post_id = '') {
    $time_string = '<time class="post-date" datetime="%1$s">%2$s</time>';
    $time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C, $post_id ) ),
			esc_html( get_the_date('', $post_id) )
		);
    echo '<span class="posted-on">'.$time_string.'</span>'; // phpcs:ignore WordPress.Security.EscapeOutput
  }
}

if ( ! function_exists( 'surprise_comment_count' ) ) {
  /**
	 * Prints HTML with comments count for the current post
	 *
	 * @since Surprise 1.0
	 *
	 * @return void
	 */
  function surprise_comment_count() {
    $comments_num = get_comments_number();

    if ( $comments_num == 0 ) {
      $comments = __('No Comments', 'surprise');
    } elseif ( $comments_num > 1 ) {
      $comments = $comments_num . __(' Comments', 'surprise');
    } else {
      $comments = __('1 Comment', 'surprise');
    }
    printf(
      '<a href="%1$s" class="comments-link">%2$s</a>',
      get_comments_link(),
      $comments
    );
  }
}

if ( ! function_exists( 'surprise_the_posts_navigation' ) ) {
	/**
	 * Print the next and previous posts navigation.
	 *
	 * @since Surprise 1.0
	 *
	 * @return void
	 */
	function surprise_the_posts_navigation() {
		the_posts_pagination(
			array(
				'before_page_number' => esc_html__( 'Page', 'twentytwentyone' ) . ' ',
				'mid_size'           => 0,
				'prev_text'          => sprintf(
					'%s <span class="nav-prev-text">%s</span>',
					is_rtl() ? '>' : '<',
					wp_kses(
						__( 'Newer <span class="nav-short">posts</span>', 'twentytwentyone' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					)
				),
				'next_text'          => sprintf(
					'<span class="nav-next-text">%s</span> %s',
					wp_kses(
						__( 'Older <span class="nav-short">posts</span>', 'twentytwentyone' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					is_rtl() ? '<' : '>'
				),
			)
		);
	}
}

if (! function_exists( 'surprise_related_posts' )) {
	/**
	 * Show latest related posts
	 *
	 * @since Surprise 1.0
	 *
	 * @return void
	 */
	function surprise_related_posts($post_id, $count, $args = array()) {
		$terms = get_the_terms($post_id, 'category');

		if (empty($terms)) $terms = array();

		$term_list = wp_list_pluck($terms, 'slug');
		$exclude_id = array( $post_id );

		$args = array(
			'post_type' => 'post',
			'posts_per_page' => $count,
			'post_status' => 'publish',
			'post__not_in' => $exclude_id,
			'orderby' => 'rand',
			'tax_query' => array(
				array(
					'taxonomy' => 'category',
					'field' => 'slug',
					'terms' => $term_list
				)
			)
		);

		$query = new WP_Query($args);

		if ($query->have_posts()) : ?>
			<div class="post-related">
				<div class="container">
					<div class="post-related-inner">
						<h3 class="post-related-title"><?php _e('Check these out too.', 'surprise'); ?></h3>

							<?php while ($query->have_posts()) : $query->the_post(); ?>

									<?php get_template_part('template-parts/content/content-article-card', get_post_format()); ?>

							<?php endwhile; ?>

					</div>
				</div>
			</div>
<?php endif;
		wp_reset_postdata($query);
	}
}


if ( ! function_exists( 'surprise_featured_posts_from_loop' )) {
	/**
	 * Remove featured posts from main query
	 *
	 * @since Surprise 1.0
	 *
	 * @return void
	 */
	if ( ! is_admin()) {
		function surprise_featured_posts_from_loop($query) {
			$sticky = get_option('sticky_posts');
			$ignore_sticky = array_slice($sticky, 0, 4);

			if( is_home() && $query->is_main_query() ) {
				$query->set( 'ignore_sticky_posts', true );
				$query->set( 'post__not_in', $ignore_sticky );
			}
		}
		add_action( 'pre_get_posts', 'surprise_featured_posts_from_loop' );
	}
}

if ( ! function_exists( 'surprise_archive_prefix_title' ) ) {
	function surprise_archive_prefix_title( $title ) {
		if ( is_category() ) {
			$title = single_cat_title( '', false );
		} elseif ( is_tag() ) {
			$title = single_tag_title( '', false );
		}
		return $title;
	}
	add_filter( 'get_the_archive_title', 'surprise_archive_prefix_title' );
}

/**
 * COMMENTS FORM
 */
require_once get_template_directory(  ) . '/inc/theme/template-comments.php';
// require_once get_template_directory(  ) . '/inc/classes/SDC_Comments.php';
// new SDC_Comments;
if (is_admin()) {
	require_once get_template_directory(  ) . '/inc/classes/SDC_Taxonomy_Fields.php';
}

// if (is_single('post')) {
require_once get_template_directory(  ) . '/inc/classes/SDC_Post_Views.php';
new SDC_Post_Views();
// }