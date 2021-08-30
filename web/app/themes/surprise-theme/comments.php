<?php

/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Surprise
 * @since Surprise 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password,
 * return early without loading the comments.
 */
if (post_password_required()) {
	return;
}

$surprise_comment_count = get_comments_number();
?>

<div id="comments" class="post-comments <?php echo get_option('show_avatars') ? 'show-avatars' : ''; ?>">
	<h2 class="comments-title h3">
		<?php if ('1' === $surprise_comment_count) : ?>
			<?php esc_html_e('Comment (1)', 'surprise'); ?>
		<?php else : ?>
			<?php
			printf(
				/* translators: %s: Comment count number. */
				esc_html(_nx('Comment (%s)', 'Comments (%s)', $surprise_comment_count, 'Comments title', 'surprise')),
				esc_html(number_format_i18n($surprise_comment_count))
			);
			?>
		<?php endif; ?>
	</h2><!-- .comments-title -->
	<?php
	comment_form(
		array(
			'logged_in_as'       => null,
			'title_reply'        => esc_html__('Leave a comment', 'surprise'),
			'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title screen-reader-text">',
			'title_reply_after'  => '</h2>',
			'label_submit'			 => __('Leave Comment', 'surprise'),
			'class_submit'			 => 'bttn bttn-primary bttn-md',
		)
	);
	?>
	<?php
	if (have_comments()) :;
	?>

		<ul class="comment-list">
			<?php
			wp_list_comments(
				array(
					'avatar_size' => 0,
					'style'       => 'ul',
					'type'				=> 'comment',
					'short_ping'  => true,
				)
			);
			?>
		</ul><!-- .comment-list -->

		<?php
		the_comments_pagination(
			array(
				'before_page_number' => esc_html__('Page', 'surprise') . ' ',
				'mid_size'           => 0,
				'prev_text'          => sprintf(
					'%s <span class="nav-prev-text">%s</span>',
					is_rtl() ? '>' : '<',
					esc_html__('Older comments', 'surprise')
				),
				'next_text'          => sprintf(
					'<span class="nav-next-text">%s</span> %s',
					esc_html__('Newer comments', 'surprise'),
					is_rtl() ? '<' : '>'
				),
			)
		);
		?>

		<?php if (!comments_open()) : ?>
			<p class="no-comments"><?php esc_html_e('Comments are closed.', 'surprise'); ?></p>
		<?php endif; ?>
	<?php endif; ?>

</div><!-- #comments -->