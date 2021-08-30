<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Surprise
 * @since Surprise 1.0
 */

$title = get_field('blog_page_title', 'option') ?: get_the_title(get_option('page_for_posts', true));

get_header();
?>
<section class="blog-header">
	<div class="blog-header-wrapper">
		<div class="container">
			<div class="blog-header-top">
				<h2 class="h3 blog-header-title"><?php echo $title; ?></h2>
				<?php get_search_form([true, 'aria_label' => __('Blog Search Form', 'surprise')]); ?>
			</div>
			<?php get_template_part('template-parts/content/content-sticky', get_post_format()); ?>
		</div>
	</div>
</section>

<?php get_template_part('template-parts/blog/blog', 'categories'); ?>

<section class="blog-page-content">
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
				<div class="blog-latest-posts" id="blog-latest-posts">
					<h2 class="h3 blog-latest-title"><?php _e( 'Latest', 'surprise' ); ?></h2>
					<?php
					if (have_posts()) :
						// Load posts loop.
						while (have_posts()) : the_post(); ?>
							<?php get_template_part('template-parts/content/content', get_theme_mod('display_excerpt_or_full_post', 'excerpt')); ?>
					<?php
						endwhile;
						// Previous/next page navigation.
						surprise_paginator( get_pagenum_link() );
					else :
						// If no content, include the "No posts found" template.
						get_template_part('template-parts/content/content-none');
					endif;
					?>
				</div>

			</div>
			<?php get_template_part( 'template-parts/sidebar/sidebar-blog' ); ?>
		</div>
	</div>
</section>
<?php
get_footer();
