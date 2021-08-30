<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Surprise
 */

get_header();
?>

<section class="post-page-content">
	<?php
	while (have_posts()) :
		the_post();

		get_template_part('template-parts/content/content-single');
	?>

		<?php
		// If comments are open or there is at least one comment, load up the comment template.
		if (comments_open() || get_comments_number()) : ?>
			<div class="post-page-comments">
				<div class="container">
					<?php comments_template(); ?>
				</div>
			</div>
		<?php endif; ?>

		<?php surprise_related_posts(get_the_ID(), 2); ?>

	<?php
	endwhile;
	?>
</section>

<?php
get_footer();
