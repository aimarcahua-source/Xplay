<?php
/**
 * Comments template.
 *
 * @package FeedBuzz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( post_password_required() ) {
	return;
}

$comment_count = (int) get_comments_number();
?>
<section id="comments" class="fb-comments-area fb-comments-section">
	<h2 class="fb-article-section-title">
		<?php
		if ( have_comments() ) {
			printf(
				/* translators: %s: Number of comments. */
				esc_html( _nx( 'One comment', '%s comments', $comment_count, 'comments title', 'feedbuzz' ) ),
				esc_html( number_format_i18n( $comment_count ) )
			);
		} else {
			esc_html_e( 'Leave a comment', 'feedbuzz' );
		}
		?>
	</h2>

	<?php if ( have_comments() ) : ?>
		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 56,
				)
			);
			?>
		</ol>
		<?php the_comments_navigation(); ?>
	<?php endif; ?>

	<?php if ( ! comments_open() && $comment_count ) : ?>
		<p><?php esc_html_e( 'Comments are closed.', 'feedbuzz' ); ?></p>
	<?php endif; ?>

	<?php
	if ( comments_open() ) {
		comment_form(
			array(
				'class_form'           => 'comment-form fb-article-comment-form',
				'class_submit'         => 'submit fb-comment-submit',
				'title_reply_before'   => '<h3 class="fb-comment-reply-title">',
				'title_reply_after'    => '</h3>',
				'comment_notes_before' => '',
			)
		);
	}
	?>
</section>
