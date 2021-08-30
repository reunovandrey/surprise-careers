<?php

/**
 * Displays the post header
 *
 * @package WordPress
 * @subpackage Surprise
 * @since Surprise 1.0
 */

// Don't show the title if the post-format is `aside` or `status`.
$post_format = get_post_format();
if ('aside' === $post_format || 'status' === $post_format) {
	return;
}
?>

<header class="entry-header">
	<a href="<?php echo esc_url(get_permalink()); ?>" class="post-thumbnail-link">
		<?php the_post_thumbnail();	?>
	</a>
</header><!-- .entry-header -->