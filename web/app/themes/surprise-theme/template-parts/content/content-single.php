<?php

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Surprise
 * @since Surprise 1.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-container'); ?>>
	<div class="post-header-sticky">
		<div class="container">
			<div class="post-header-sticky-wrapper">
				<?php the_title('<h3 class="post-title h5">', '</h3>'); 
				surprise_share_post(); ?>
			</div>
		</div>
	</div>
	<header class="post-header">
		<div class="container">
			<div class="post-header-wrapper">
				<div class="post-header-top">
					<?php surprise_get_categories_list(); // Output post category links 
					?>
					<?php the_title('<h1 class="post-title h2">', '</h1>'); ?>
					<div class="post-meta">
						<?php
						surprise_posted_by();
						surprise_posted_on();
						surprise_comment_count();
						?>
					</div>
					<?php surprise_share_post(); ?>
				</div>

				<div class="post-header-bottom">
					<div class="post-preview">
						<?php the_post_thumbnail(); ?>
					</div>
				</div>
			</div>
		</div>
	</header><!-- .post-header -->

	<div class="post-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before'   => '<nav class="page-links" aria-label="' . esc_attr__('Page', 'surprise') . '">',
				'after'    => '</nav>',
				/* translators: %: Page number. */
				'pagelink' => esc_html__('Page %', 'surprise'),
			)
		);
		?>
	</div><!-- .entry-content -->

	<footer class="post-footer">
		<div class="container">
			<div class="post-footer-wrapper">
				<?php surprise_get_tags_list(); // Output post category links 
				?>
			</div>
		</div>
	</footer><!-- .entry-footer -->

	<?php if (!is_singular('attachment')) : ?>
		<?php get_template_part('template-parts/post/author-bio'); ?>
	<?php endif; ?>

</article><!-- #post-<?php the_ID(); ?> -->