<?php

/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WordPress
 * @subpackage Surprise
 * @since Surprise 1.0
 */

$posts_per_row = get_field('posts_per_row', 'option');
$col = 12 / $posts_per_row;

get_header();
?>


<section class="archive-header">
	<div class="archive-header-wrapper">
		<div class="container">
			<div class="archive-header-inner">
				<a href="<?php echo get_home_url(); ?>" class="link link-all-posts">
					<svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M4.18932 5.24993H13.625C13.832 5.24993 14 5.08202 14 4.87493V3.12493C14 2.91784 13.832 2.74993 13.625 2.74993H4.18932V1.31059C4.18932 0.642408 3.38147 0.307784 2.90898 0.780251L0.219637 3.46959C-0.0732684 3.7625 -0.0732684 4.23737 0.219637 4.53024L2.90898 7.21958C3.38144 7.69205 4.18932 7.35743 4.18932 6.68924V5.24993Z" fill="currentColor" />
					</svg>
					<?php _e('All Posts'); ?>
				</a>
				<?php get_search_form([true, 'aria_label' => __('Blog Search Form', 'surprise')]); ?>
				<h2 class="archive-header-title h2">
					<?php
					/* translators: %s: search query. */
					printf(esc_html__('Results for ‘%s’', 'surprise'), '<span>' . get_search_query() . '</span>'); ?>
				</h2>
			</div>
		</div>
	</div>
</section>

<section class="archive-posts">
	<div class="container">
		<div class="archive-posts-grid">
			<?php
			if (have_posts()) :
				// Load posts loop.
				while (have_posts()) : the_post(); ?>
					<div class="archive-posts-item">
						<?php get_template_part('template-parts/content/content-article-card', get_theme_mod('display_excerpt_or_full_post', 'excerpt')); ?>
					</div>
			<?php
				endwhile;
				// Previous/next page navigation.
				// surprise_the_posts_navigation();
			else :
				// If no content, include the "No posts found" template.
				get_template_part('template-parts/content/content-none');
			endif;
			?>
		</div>
	</div>
</section>

<?php
get_footer();
