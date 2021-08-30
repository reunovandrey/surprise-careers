<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Surprise
 * @since Surprise 1.0
 */

?>

<?php if (is_home() || is_archive() || is_singular('post')) :
	get_template_part('template-blocks/block-upper-footer');
endif; ?>

</div><!-- #content -->

<footer id="colophon" class="site-footer">
	<?php get_template_part('template-parts/footer/site', 'footer'); ?>
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>