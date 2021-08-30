<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Surprise
 * @since Surprise 0.1
 */

$posts_per_row = get_field('posts_per_row', 'option');
$col = 12 / $posts_per_row;

get_header();

if (have_posts()) : ?>
	<section class="blog-page-content">
		<div class="container">
			<div class="row">
				<?php
				// Load posts loop.
				while (have_posts()) : the_post(); ?>
					<div class="col-lg-<?php echo $col; ?>">
						<?php get_template_part('template-parts/content/content', get_theme_mod('display_excerpt_or_full_post', 'excerpt')); ?>
					</div>
				<?php
				endwhile;
				// Previous/next page navigation.
				surprise_the_posts_navigation();
			else :
				// If no content, include the "No posts found" template.
				get_template_part('template-parts/content/content-none');
				?>
			</div>
		</div>
	</section>
<?php
endif;

get_footer();
